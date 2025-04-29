<?php

namespace Pratiksh\Imperium\Services\Generator\SchemaResource\SchemaRules;

use Illuminate\Support\Str;
use Pratiksh\Imperium\Contracts\Core\Generator\SchemaRuleInterface;
use Pratiksh\Imperium\Services\Generator\SchemaResource\SchemaSuppliers\PgsqlSchemaSupplier;
use stdClass;

class PgsqlSchemaRule extends PgsqlSchemaSupplier implements SchemaRuleInterface
{
    public static array $integerTypes = [
        'smallint' => ['-32768', '32767'],
        'integer' => ['-2147483648', '2147483647'],
        'bigint' => ['-9223372036854775808', '9223372036854775807'],
    ];

    public string $table_name;

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
        $columnRules[] = $column->is_nullable === 'YES' ? 'nullable' : 'required';

        if (! empty($column->Foreign)) {
            $columnRules[] = 'exists:' . implode(',', $column->Foreign);

            return $columnRules;
        }

        $type = Str::of($column->data_type);
        switch (true) {
            case $type == 'boolean':
                $columnRules[] = 'boolean';

                break;
            case $type->contains('char'):
                $columnRules[] = 'string';
                $columnRules[] = 'min:' . config('schema-rules.string_min_length');
                $columnRules[] = 'max:' . $column->character_maximum_length;

                break;
            case $type == 'text':
                $columnRules[] = 'string';
                $columnRules[] = 'min:' . config('schema-rules.string_min_length');

                break;
            case $type->contains('int'):
                $columnRules[] = 'integer';
                $columnRules[] = 'min:' . self::$integerTypes[$type->__toString()][0];
                $columnRules[] = 'max:' . self::$integerTypes[$type->__toString()][1];

                break;
            case $type->contains('double') ||
                $type->contains('decimal') ||
                $type->contains('numeric') ||
                $type->contains('real'):
                $columnRules[] = 'numeric';

                break;
            case $type == 'date' || $type->contains('time '):
                $columnRules[] = 'date';

                break;
            case $type->contains('json'):
                $columnRules[] = 'json';
                break;
            default:
                break;
        }

        return $columnRules;
    }
}
