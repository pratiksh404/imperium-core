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
        $moduleRules = preg_replace(
            ["/^array \(/", "/\)$/", "/ => \n\s+array \(/", "/\d+ => /", "/\),/"],
            ['[', ']', ' => [', '', '],'],
            var_export($rules, true)
        );

        // Convert single-line arrays into one-liners
        $moduleRules = preg_replace("/\[\n\s+([^]]+)\n\s+\]/", '[$1]', $moduleRules);

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

        return $this->makeFile(app_path('Http/Requests/' . $this->name . 'Request.php'), $template);
    }
}
