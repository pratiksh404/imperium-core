<?php

namespace Pratiksh\Imperium\Services\Generator\Scaffold;

use Pratiksh\Imperium\Contracts\Imperium\Generator\GeneratorInterface;
use Pratiksh\Imperium\Services\Generator\Generator;

class ResourcefulModelGenerator extends Generator implements GeneratorInterface
{
    public function __construct(string $name)
    {
        parent::__construct($name);
    }

    public function generate()
    {
        $this->generateResourcefulModel();
    }

    public function generateResourcefulModel()
    {
        $template = str_replace(
            [
                '{{modelName}}',
            ],
            [
                $this->name,
            ],
            $this->getStub('ResourcefulModel'),
        );

        return $this->makeFile(app_path('Models/Admin/'.$this->name.'.php'), $template);
    }
}
