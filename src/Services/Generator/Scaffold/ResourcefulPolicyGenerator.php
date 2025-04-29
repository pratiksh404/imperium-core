<?php

namespace Pratiksh\Imperium\Services\Generator\Scaffold;

use Pratiksh\Imperium\Contracts\Core\Generator\GeneratorInterface;
use Pratiksh\Imperium\Services\Generator\Generator;

class ResourcefulPolicyGenerator extends Generator implements GeneratorInterface
{
    public function __construct(string $name, ?string $model_namespace = null)
    {
        parent::__construct($name, $model_namespace);
    }

    public function generate()
    {
        $this->generateResourcefulPolicy();
    }

    public function generateResourcefulPolicy()
    {
        $template = str_replace(
            [
                '{{modelNamespace}}',
                '{{modelName}}',
                '{{modelNameLowercase}}',
            ],
            [
                $this->model_namespace,
                $this->name,
                strtolower($this->name),
            ],
            $this->getStub('ResourcefulPolicy'),
        );

        return $this->makeFile(app_path('Policies/'.$this->name.'Policy.php'), $template);
    }
}
