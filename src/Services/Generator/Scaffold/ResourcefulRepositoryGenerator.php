<?php

namespace Pratiksh\Imperium\Services\Generator\Scaffold;

use Pratiksh\Imperium\Contracts\Core\Generator\GeneratorInterface;
use Pratiksh\Imperium\Services\Generator\Generator;

class ResourcefulRepositoryGenerator extends Generator implements GeneratorInterface
{
    public function __construct(string $name, ?string $model_namespace = null)
    {
        parent::__construct($name, $model_namespace);
    }

    public function generate()
    {
        // Making the repository
        $this->generateRepository();

        // Making the interface
        $this->generateInterface();
    }

    public function generateRepository()
    {
        $template = str_replace(
            [
                '{{modelNamespace}}',
                '{{modelName}}',
            ],
            [
                $this->model_namespace,
                $this->name,
            ],
            $this->getStub('ResourcefulRepository'),
        );

        return $this->makeFile(app_path('Repositories/'.$this->name.'Repository.php'), $template);
    }

    public function generateInterface()
    {
        $template = str_replace(
            [
                '{{modelName}}',
            ],
            [
                $this->name,
            ],
            $this->getStub('ResourcefulRepositoryInterface'),
        );

        return $this->makeFile(app_path('Contracts/'.$this->name.'RepositoryInterface.php'), $template);
    }
}
