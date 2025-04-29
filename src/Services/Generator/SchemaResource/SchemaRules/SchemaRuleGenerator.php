<?php

namespace Pratiksh\Imperium\Services\Generator\SchemaResource\SchemaRules;

use Pratiksh\Imperium\Contracts\Core\Generator\GeneratorInterface;
use Pratiksh\Imperium\Services\Generator\Generator;
use Pratiksh\Imperium\Services\Generator\SchemaResource\DatabaseSchema;

class SchemaRuleGenerator extends Generator implements GeneratorInterface
{
    public function __construct(string $name, ?string $model_namespace = null)
    {
        parent::__construct($name, $model_namespace);
    }

    public function generate()
    {
        $tableName = (new ($this->model_namespace))->getTable();
        $rules = DatabaseSchema::for($tableName)->rules();

        // Convert array to PHP code with correct syntax
        // Convert the rules array into a properly formatted PHP array string
        $formatValue = function ($v) use (&$formatValue) {
            if (is_array($v)) {
                return '['.implode(', ', array_map($formatValue, $v)).']';
            }
            if (is_string($v)) {
                return "'".addslashes($v)."'";
            }
            if (is_bool($v)) {
                return $v ? 'true' : 'false';
            }

            return $v;
        };

        $moduleRules = '['.implode(",\n", array_map(function ($key, $value) use ($formatValue) {
            return "'".addslashes($key)."' => ".$formatValue($value);
        }, array_keys($rules), $rules)).']';

        $template = str_replace(
            [
                '{{modelName}}',
                '{{moduleRules}}',
            ],
            [
                $this->name,
                $moduleRules,
            ],
            $this->getStub('ResourcefulRequest'),
        );

        return $this->makeFile(app_path('Http/Requests/'.$this->name.'Request.php'), $template);
    }
}
