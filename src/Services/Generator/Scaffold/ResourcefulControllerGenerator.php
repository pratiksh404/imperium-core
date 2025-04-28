<?php

namespace Pratiksh\Imperium\Services\Generator\Scaffold;

use Illuminate\Support\Str;
use Pratiksh\Imperium\Contracts\Imperium\Generator\GeneratorInterface;
use Pratiksh\Imperium\Services\Generator\Generator;

class ResourcefulControllerGenerator extends Generator implements GeneratorInterface
{
    public function __construct(string $name, ?string $model_namespace = null)
    {
        parent::__construct($name, $model_namespace);
    }

    public function generate()
    {
        $this->generateResourcefulController();
    }

    public function generateResourcefulController()
    {
        $template = str_replace(
            [
                '{{modelNamespace}}',
                '{{modelName}}',
                '{{modelNameSingularLowercase}}',
                '{{modelNamePluralLowercase}}',
            ],
            [
                $this->model_namespace,
                $this->name,
                strtolower($this->name),
                Str::plural(strtolower($this->name)),
            ],
            $this->getStub('ResourcefulController'),
        );

        return $this->makeFile(app_path('Http/Controllers/Admin/Resourceful/'.$this->name.'Controller.php'), $template);
    }
}
