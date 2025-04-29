<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Pratiksh\Imperium\Facades\Imperium;

if (! function_exists('setting')) {
    function setting($name)
    {
        return config('imperium.' . trim($name), null);
    }
}

if (! function_exists('menus')) {
    function menus()
    {
        return Imperium::application()->menu()->toArray();
    }
}

if (! function_exists('appHeader')) {
    function appHeader()
    {
        return Imperium::application()->header();
    }
}

if (! function_exists('resources')) {
    function resources()
    {
        $namespace = 'App\\Imperium\\Resource';
        $path = base_path('app/Imperium/Resource');
        $resources = getFilesWithPaths($path);
        // $resources = getFilesWithPaths(base_path(str_replace('\\', '/', $namespace)));
        $data = [];
        foreach ($resources as $resource => $resource_file) {
            $resource_class = $namespace . '\\' . (trim(Str::ucfirst($resource)));
            $resource_data = (new ($resource_class))->get();
            $data[$resource_data['name']] = $resource_data;
        }

        return $data;
    }
}

if (! function_exists('getResource')) {
    function getResource($name)
    {
        $namespace = 'App\\Imperium\\Resource';

        return (new ($namespace . '\\' . (trim(Str::ucfirst($name)) . 'Resource')))->get();
    }
}

if (! function_exists('getFilesWithPaths')) {
    function getFilesWithPaths(string $basePath, string $extension = 'php'): array
    {
        $filesWithPaths = [];

        // Normalize the base path
        $basePath = realpath($basePath);

        if ($basePath === false || ! is_dir($basePath)) {
            return $filesWithPaths; // Return an empty array if the base path is invalid
        }

        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($basePath));

        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === $extension) {
                // Get the relative path from the base path
                $relativePath = str_replace($basePath . DIRECTORY_SEPARATOR, '', $file->getPathname());

                $filesWithPaths[basename($file->getFilename(), '.' . $extension)] = $basePath . DIRECTORY_SEPARATOR . $relativePath;
            }
        }

        return $filesWithPaths;
    }
}

function getFilesWithNameSpace(string $basePath, string $extension = 'php'): array
{
    $filesWithPaths = getFilesWithPaths($basePath, $extension);
    $filesWithNamespace = [];

    foreach ($filesWithPaths as $className => $filePath) {
        $namespace = extractNamespace($filePath);
        if ($namespace) {
            $filesWithNamespace[$className] = $namespace . '\\' . $className;
        }
    }

    return $filesWithNamespace;
}

/**
 * Extracts the namespace from a PHP file.
 */
function extractNamespace(string $filePath): ?string
{
    $lines = file($filePath);

    foreach ($lines as $line) {
        if (strpos($line, 'namespace ') === 0) {
            return trim(str_replace(['namespace', ';'], '', $line));
        }
    }

    return null;
}

if (! function_exists('getAllModels')) {
    function getAllModels()
    {
        $models = [];
        $basePath = app_path('Models');
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($basePath));

        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $relativePath = str_replace($basePath . DIRECTORY_SEPARATOR, '', $file->getPathname());
                $directory = dirname($relativePath);
                $namespace = 'App\\Models';

                // Add subdirectory to namespace if not in the root directory
                if ($directory !== '.') {
                    $namespace .= '\\' . str_replace('/', '\\', $directory);
                }

                $className = basename($file->getFilename(), '.php');
                $models[$className] = $namespace . '\\' . $className;
            }
        }

        return $models;
    }
}

if (! function_exists('getModelHavingName')) {
    function getModelHavingName($model)
    {
        $models = getAllModels();

        return $models[$model] ?? null;
    }
}

if (! function_exists('getDatabaseDriverName')) {
    function getDatabaseDriverName()
    {
        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");

        return $driver;
    }
}

if (! function_exists('migrationExistsForTable')) {
    function migrationExistsForTable($tableName)
    {
        return ! is_null(getMigrationFileForTable($tableName));
    }
}

if (! function_exists('getMigrationFileForTable')) {
    function getMigrationFileForTable($tableName)
    {
        // Get the migration folder path
        $migrationPath = database_path('migrations');

        // Get all migration files
        $migrationFiles = File::files($migrationPath);

        // Loop through migration files and check if any match the table name
        foreach ($migrationFiles as $migrationFile) {
            // Check if the migration file contains the table name
            if (Str::contains($migrationFile->getFilename(), 'create_' . $tableName . '_table')) {
                return $migrationFile;
            }
        }

        return null;
    }
}
