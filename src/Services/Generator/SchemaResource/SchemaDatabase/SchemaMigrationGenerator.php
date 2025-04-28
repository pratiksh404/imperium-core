<?php

namespace Pratiksh\Imperium\Services\Generator\SchemaResource\SchemaDatabase;

use Exception;
use Illuminate\Support\Str;

class SchemaMigrationGenerator
{
    public string $table_name;

    public string $migration_schemas;

    public function __construct(string $table_name)
    {
        $this->table_name = trim($table_name);
    }

    public static function for(string $table_name): self
    {
        return new self($table_name);
    }

    public function schemas(string $migration_schemas)
    {
        $this->migration_schemas = $migration_schemas;

        return $this;
    }

    public function generate()
    {
        if (! migrationExistsForTable($this->table_name)) {
            $template = str_replace(
                [
                    '{{tableName}}',
                    '{{migrationSchemas}}',
                ],
                [
                    $this->table_name,
                    $this->migration_schemas,
                ],
                $this->getStub('ImperiumMigration'),
            );

            return $this->makeFile(database_path('migrations/'.date('Y_m_d_His').'_create_'.$this->table_name.'_table.php'), $template);
        } else {
            throw new Exception('Migration file already exists for table '.$this->table_name);
        }
    }

    public function makeFile(string $file_path, string $content)
    {
        file_put_contents($file_path, $content);

        return $file_path;
    }

    public function getStubPath(string $name)
    {
        $stubs = getFilesWithPaths(app_path('Stubs'), 'stub');
        $stub = $stubs[trim(Str::studly($name))];

        return $stub;
    }

    private function getStub(string $name)
    {
        return file_get_contents($this->getStubPath($name));
    }
}
