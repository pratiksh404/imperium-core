<?php

namespace Pratiksh\Imperium\Services\Generator\SchemaResource\SchemaSuppliers;

use Exception;
use Pratiksh\Imperium\Contracts\Core\Generator\SchemaSupplierInterface;

class SchemaSupplier implements SchemaSupplierInterface
{
    public string $table_name;

    public SchemaSupplierInterface $schema_provider_agent;

    final public function __construct(string $table_name)
    {
        $this->table_name = $table_name;
        $this->schema_provider_agent = $this->schemaProviderAgent();
    }

    public static function for(string $table_name): self
    {
        return new static($table_name);
    }

    public function columns(): array
    {
        return $this->schema_provider_agent->columns();
    }

    public function tableName(): string
    {
        return $this->table_name;
    }

    private function schemaProviderAgent(): SchemaSupplierInterface
    {
        $database_driver_name = getDatabaseDriverName();
        // Check if the database driver name is supported
        if ($database_driver_name == 'mysql') {
            return new MysqlSchemaSupplier($this->table_name);
        } elseif ($database_driver_name == 'pgsql') {
            return new PgsqlSchemaSupplier($this->table_name);
        } elseif ($database_driver_name == 'sqlite') {
            return new SqliteSchemaSupplier($this->table_name);
        } else {
            throw new Exception('Unsupported Database');
        }
    }
}
