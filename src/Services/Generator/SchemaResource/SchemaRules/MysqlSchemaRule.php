<?php

namespace Pratiksh\Imperium\Services\Generator\SchemaResource\SchemaRules;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Pratiksh\Imperium\Contracts\Core\Generator\SchemaRuleInterface;
use Pratiksh\Imperium\Services\Generator\SchemaResource\SchemaSuppliers\MysqlSchemaSupplier;
use stdClass;

class MysqlSchemaRule implements SchemaRuleInterface
{
    public static array $minMaxDefault = [
        'tinyint' => [
            'unsigned' => ['min' => '0', 'max' => '255'],
            'signed' => ['min' => '-128', 'max' => '127'],
        ],
        'smallint' => [
            'unsigned' => ['min' => '0', 'max' => '65535'],
            'signed' => ['min' => '-32768', 'max' => '32767'],
        ],
        'mediumint' => [
            'unsigned' => ['min' => '0', 'max' => '16777215'],
            'signed' => ['min' => '-8388608', 'max' => '8388607'],
        ],
        'int' => [
            'unsigned' => ['min' => '0', 'max' => '4294967295'],
            'signed' => ['min' => '-2147483648', 'max' => '2147483647'],
        ],
        'bigint' => [
            'unsigned' => ['min' => '0', 'max' => '18446744073709551615'],
            'signed' => ['min' => '-9223372036854775808', 'max' => '9223372036854775807'],
        ],
    ];

    public string $table_name;

    public array $rules = [];

    public function __construct(string $table_name)
    {
        $this->table_name = $table_name;
    }

    public function rules(): array
    {
        $columns = (new MysqlSchemaSupplier($this->table_name))->columns();

        $rules = [];

        foreach ($columns as $column_name => $column) {
            if ($column->Key !== 'PRI' && $column_name !== 'deleted_at' && $column_name !== 'created_at' && $column_name !== 'updated_at') {
                $rules[$column_name] = $this->generateColumnRules($column);
            }
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
        $relationRules = $this->generateRelationRules($column);
        $uniqueRules = $this->generateUniqueRules($column);
        $typeRules = $this->generateTypeRules($column);

        return $this->getRulesForColumn(
            $typeRules['rule_type'],
            array_merge($relationRules, $uniqueRules, $typeRules['defined_rules']),
            $typeRules['is_unsigned']
        );
    }

    protected function generateRelationRules(stdClass $column): array
    {
        $relationRules = [];
        $relationRules[] = $column->Null === 'YES' ? 'nullable' : 'required';

        if (! empty($column->Foreign)) {
            $relationRules[] = 'exists:'.implode(',', $column->Foreign);
        }

        return $relationRules;
    }

    public function generateUniqueRules(stdClass $column): array
    {
        $uniqueRules = [];
        $field = $column->Field;
        if (Schema::hasIndex($this->table_name, [$field], 'unique')) {
            $uniqueRules[] = 'unique:'.$this->table_name.','.$field;
        }

        return $uniqueRules;
    }

    protected function generateTypeRules(stdClass $column): array
    {
        $type = Str::of($column->Type);
        $is_unsigned = false;
        $defined_rules = [];
        $rule_type = 'default';

        if ($type->contains('char')) {
            $defined_rules[] = 'max:'.filter_var($type, FILTER_SANITIZE_NUMBER_INT);
            $rule_type = 'char';
        } elseif ($type->contains('int')) {
            $is_unsigned = $type->contains('unsigned');
            $rule_type = $this->normalizeIntType($type);
        } elseif ($type->contains('enum') || $type->contains('set')) {
            $rule_type = $type->contains('enum') ? 'enum' : 'set';
            $defined_rules[] = $this->generateEnumSetRule($type);
        } else {
            $rule_type = $this->determineRuleType($type);
        }

        return [
            'rule_type' => strtolower($rule_type),
            'defined_rules' => $defined_rules,
            'is_unsigned' => $is_unsigned,
        ];
    }

    protected function normalizeIntType($type): string
    {
        $type = $type->before(' unsigned');
        $rule_type = preg_replace("/\([^)]+\)/", '', $type->value);

        return array_key_exists($rule_type, self::$minMaxDefault) ? $rule_type : 'int';
    }

    protected function generateEnumSetRule($type): string
    {
        preg_match_all("/'([^']*)'/", $type, $matches);

        return 'in:'.implode(',', $matches[1]);
    }

    protected function determineRuleType($type): string
    {
        $ruleTypes = [
            'text' => 'text',
            'double' => 'double',
            'float' => 'float',
            'decimal' => 'decimal',
            'dec' => 'dec',
            'year' => 'year',
            'time' => 'time',
            'timestamp' => 'timestamp',
            'json' => 'json',
        ];

        foreach ($ruleTypes as $keyword => $ruleType) {
            if ($type->contains($keyword)) {
                return $ruleType;
            }
        }

        return 'default';
    }

    public function getRulesForColumn(string $column_type, array $rules = [], bool $is_unsigned = false): array
    {
        $default_rules = config('imperium.schema.rules.'.trim($column_type).'.default', []);
        // Merge the default rules and provided rules
        $merged_rules = array_merge($default_rules, $rules);

        if (isset(self::$minMaxDefault[$column_type][$is_unsigned ? 'unsigned' : 'signed'])) {
            // Get the min and max values for the column type from $minMaxDefault
            $minMaxValues = self::$minMaxDefault[$column_type][$is_unsigned ? 'unsigned' : 'signed'];
            // Initialize min and max variables
            $minValue = null;
            $maxValue = null;

            // Parse the rules to extract min and max values
            foreach ($merged_rules as $rule) {
                if (strpos($rule, 'min:') === 0) {
                    $minValue = explode(':', $rule)[1]; // Extract value after 'min:'
                } elseif (strpos($rule, 'max:') === 0) {
                    $maxValue = explode(':', $rule)[1]; // Extract value after 'max:'
                }
            }

            // Validate and replace 'min' rule
            if ($minValue !== null) {
                if ($minValue < $minMaxValues['min']) {
                    // Replace invalid min value with default
                    $merged_rules = array_filter($merged_rules, fn ($rule) => strpos($rule, 'min:') !== 0);
                    $merged_rules[] = 'min:'.$minMaxValues['min'];
                }
            } else {
                // Add default min if missing
                $merged_rules[] = 'min:'.$minMaxValues['min'];
            }

            // Validate and replace 'max' rule
            if ($maxValue !== null) {
                if ($maxValue > $minMaxValues['max']) {
                    // Replace invalid max value with default
                    $merged_rules = array_filter($merged_rules, fn ($rule) => strpos($rule, 'max:') !== 0);
                    $merged_rules[] = 'max:'.$minMaxValues['max'];
                }
            } else {
                // Add default max if missing
                $merged_rules[] = 'max:'.$minMaxValues['max'];
            }
        }

        return array_unique($merged_rules);
    }
}
