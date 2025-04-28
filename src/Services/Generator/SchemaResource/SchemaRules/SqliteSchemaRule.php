<?php

namespace Pratiksh\Imperium\Services\Generator\SchemaResource\SchemaRules;

use Illuminate\Support\Str;
use Pratiksh\Imperium\Contracts\Imperium\Generator\SchemaRuleInterface;
use Pratiksh\Imperium\Services\Generator\SchemaResource\SchemaSuppliers\SqliteSchemaSupplier;
use stdClass;

class SqliteSchemaRule extends SqliteSchemaSupplier implements SchemaRuleInterface
{
    public array $rules = [];

    public function __construct(string $table_name)
    {
        $this->table_name = $table_name;
        parent::__construct($table_name);
    }

    public function rules(): array
    {
        $columns = $this->columns();

        $rules = [];

        foreach ($columns as $column_name => $column) {
            $rules[$column_name] = $this->generateColumnRules($column);
        }

        $this->rules = $rules;

        return $rules;
    }

    public function ruleForColumn(string $column_name): array
    {
        return [];
    }

    protected function generateColumnRules(stdClass $column): array
    {
        $columnRules = [];
        $columnRules[] = $column->notnull ? 'required' : 'nullable';

        if (! empty($column->Foreign)) {
            $columnRules[] = 'exists:'.implode(',', $column->Foreign);

            return $columnRules;
        }

        $type = Str::of($column->type);
        switch (true) {
            case $type == 'tinyint(1)' && config('schema-rules.tinyint1_to_bool'):
                $columnRules[] = 'boolean';

                break;
            case $type == 'varchar' || $type == 'text':
                $columnRules[] = 'string';
                $columnRules[] = 'min:'.config('schema-rules.string_min_length');

                break;
            case $type == 'integer':
                $columnRules[] = 'integer';
                $columnRules[] = 'min:-9223372036854775808';
                $columnRules[] = 'max:9223372036854775807';

                break;
            case $type->contains('numeric') || $type->contains('float'):
                // should we do more specific here?
                // some kind of regex validation for double, double unsigned, double(8, 2), decimal etc...?
                $columnRules[] = 'numeric';

                break;
            case $type == 'date' || $type == 'time' || $type == 'datetime':
                $columnRules[] = 'date';

                break;
            default:
                // I think we skip BINARY and BLOB for now
                break;
        }

        return $columnRules;
    }
}
