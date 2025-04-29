<?php

namespace Pratiksh\Imperium\Services\Generator\Scaffold;


use Illuminate\Support\Str;
use function Laravel\Prompts\confirm;
use Illuminate\Support\Facades\Artisan;

use Pratiksh\Imperium\Facades\Imperium;
use function Laravel\Prompts\multiselect;

use Pratiksh\Imperium\Services\Generator\Generator;
use Pratiksh\Imperium\Contracts\Core\Generator\GeneratorInterface;


class ResourcefulScaffoldGenerator extends Generator implements GeneratorInterface
{
    public function __construct(string $name, ?string $model_namespace = null)
    {
        parent::__construct($name, $model_namespace);
    }

    public function generate()
    {
        $generateAll = confirm("Do you want to generate all resourceful components for {$this->name}?", true);

        if ($generateAll) {
            $this->generateResourcefulModel();
            $this->generateResourcefulController();
            $this->generateResourcefulVueComponent();
            $this->generateResourcefulRepository();
            $this->generateResourcefulPolicy();
            $this->generateMigration();
            $this->generateAuthorization();
        } else {
            $this->selectiveGeneration();
        }
    }

    private function selectiveGeneration()
    {
        $options = [
            'Model' => fn() => $this->generateResourcefulModel(),
            'Controller' => fn() => $this->generateResourcefulController(),
            'Vue Component' => fn() => $this->generateResourcefulVueComponent(),
            'Repository' => fn() => $this->generateResourcefulRepository(),
            'Policy' => fn() => $this->generateResourcefulPolicy(),
            'Migration' => fn() => $this->generateMigration(),
            'Authorization' => fn() => $this->generateAuthorization(),
        ];

        $selectedOptions = multiselect(
            'Select the components to generate:',
            array_keys($options),
            default: array_keys($options)
        );

        foreach ($selectedOptions as $option) {
            $options[$option]();
        }
    }

    private function generateResourcefulModel()
    {
        $generator = new ResourcefulModelGenerator($this->name);
        $model = $generator->generateResourcefulModel();
        $this->logSuccess('Model generated successfully : ' . $model);
    }

    private function generateResourcefulController()
    {
        $generator = new ResourcefulControllerGenerator($this->name);
        $controller = $generator->generateResourcefulController();
        $this->logSuccess('Controller generated successfully : ' . $controller);
    }

    private function generateResourcefulVueComponent()
    {
        $generator = new ResourcefulVueComponentGenerator($this->name);
        $index = $generator->generateModuleIndex();
        $form = $generator->generateModuleForm();
        $this->logSuccess('Vue module index components generated successfully : ' . $index);
        $this->logSuccess('Vue module form components generated successfully : ' . $form);
    }

    private function generateResourcefulPolicy()
    {
        $generator = new ResourcefulPolicyGenerator($this->name);
        $policy = $generator->generateResourcefulPolicy();
        $this->logSuccess('Policy generated successfully : ' . $policy);
    }

    private function generateResourcefulRepository()
    {
        $generator = new ResourcefulRepositoryGenerator($this->name);
        $repository = $generator->generateRepository();
        $interface = $generator->generateInterface();
        $this->logSuccess('Repository generated successfully : ' . $repository);
        $this->logSuccess('Interface generated successfully : ' . $interface);
    }

    private function generateMigration()
    {
        Artisan::call('make:migration', [
            'name' => 'create_' . strtolower(Str::plural($this->name)) . '_table',
            '--create' => strtolower(Str::plural($this->name)),
        ]);
        $this->logSuccess('Migration generated successfully.');
    }

    private function generateAuthorization()
    {
        $roles = Imperium::role()->all();
        $roles->each(function ($role) {
            Imperium::permission()->generateBREADForModel($this->name, $role);
        });
        $this->logSuccess('Authorization generated successfully.');
    }

    private function logSuccess(string $message)
    {
        info($message);
    }
}
