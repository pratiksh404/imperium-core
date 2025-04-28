<?php

namespace Pratiksh\Imperium\Services\Generator;

use Illuminate\Support\Str;

class Generator
{
    public $stubs = [];

    public string $name;

    public string $model_namespace;

    public function __construct(string $name, ?string $model_namespace = null)
    {
        $this->name = Str::studly($name);
        $this->model_namespace = $model_namespace ?? $this->getModelNamespace($this->name);
        $this->stubs = getFilesWithPaths(app_path('Stubs'), 'stub');
    }

    public function getModelNamespace(string $name)
    {
        $namespace = getModelHavingName($name);
        if (is_null($namespace)) {
            // Making the model
            $template = str_replace(
                [
                    '{{modelName}}',
                ],
                [
                    $this->name,
                ],
                $this->getStub('ResourcefulModel'),
            );

            $this->makeFile(app_path('Models/Admin/'.$this->name.'.php'), $template);

            return $this->getModelNamespace($this->name);
        }

        return $namespace;
    }

    public function makeFolderIfNotExists(string $path)
    {
        if (! file_exists($path)) {
            mkdir($path, 0777, true);
        }
    }

    public function makeFile(string $file_path, string $content)
    {
        $this->makeFolderIfNotExists(dirname($file_path));

        file_put_contents($file_path, $content);

        return $file_path;
    }

    public function getStub(string $name)
    {
        return file_get_contents($this->getStubPath($name));
    }

    public function getStubPath(string $name)
    {
        $stubs = count($this->stubs ?? []) > 0 ? $this->stubs : getFilesWithPaths(app_path('Stubs'), 'stub');
        $stub = $stubs[trim(Str::studly($name))];

        return $stub;
    }
}
