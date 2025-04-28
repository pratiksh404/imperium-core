<?php

namespace Pratiksh\Imperium\Services\Generator\Scaffold;

use Illuminate\Support\Str;
use Pratiksh\Imperium\Contracts\Imperium\Generator\GeneratorInterface;
use Pratiksh\Imperium\Services\Generator\Generator;

class ResourcefulVueComponentGenerator extends Generator implements GeneratorInterface
{
    public function __construct(string $name)
    {
        parent::__construct($name);
    }

    public function generate()
    {
        // Form Component
        $this->generateModuleForm();
        // Index Component
        $this->generateModuleIndex();
    }

    public function generateModuleIndex()
    {
        $template = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePluralLowercase}}',
            ],
            [
                $this->name,
                Str::plural(strtolower($this->name)),
            ],
            $this->getStub('Index'),
        );

        return $this->makeFile(resource_path('js/Pages/Admin/Modules/'.$this->name.'/Index.vue'), $template);
    }

    public function generateModuleForm()
    {
        $template = str_replace(
            [
                '{{modelName}}',
            ],
            [
                $this->name,
            ],
            $this->getStub('Form'),
        );

        return $this->makeFile(resource_path('js/Components/Form/'.$this->name.'/Form.vue'), $template);
    }
}
