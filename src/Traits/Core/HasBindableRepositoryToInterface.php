<?php

namespace Pratiksh\Imperium\Traits\Core;

use Illuminate\Support\Facades\File;

trait HasBindableRepositoryToInterface
{
    protected function bindRepositoryToInterface(): void
    {
        // Define paths for contracts and repositories
        $contractsPath = app_path('Contracts');
        $repositoriesNamespace = 'App\Repositories';

        // Check if the Contracts directory exists
        if (File::exists($contractsPath)) {
            // Get all interface files from Contracts folder
            $files = File::files($contractsPath);
            foreach ($files as $file) {
                $interfaceName = $file->getFilenameWithoutExtension(); // e.g., "RoleRepositoryInterface"
                if ($interfaceName != 'ResourcefulInterface' && str_contains($interfaceName, 'RepositoryInterface')) {
                    $moduleName = str_replace('RepositoryInterface', '', $interfaceName); // Extract "Role"

                    // Construct class names
                    $interfaceClass = "Pratiksh\Imperium\\Contracts\\{$interfaceName}";
                    $repositoryClass = "{$repositoriesNamespace}\\{$moduleName}Repository";

                    // Check if the repository class exists
                    if (class_exists($repositoryClass)) {
                        $this->app->bind($interfaceClass, $repositoryClass);
                    }
                }
            }
        }
    }
}
