<?php

namespace Pratiksh\Imperium\Services\Generator\SchemaResource\SchemaSuppliers;

use Exception;
use Pratiksh\Imperium\Contracts\Imperium\Generator\SchemaSupplierInterface;

class SchemaSupplier implements SchemaSupplierInterface
{
    public string $table_name;

    public SchemaSupplierInterface $schema_provider_agent;

    public function __construct(string $table_name)
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

        switch ($database_driver_name) {
            case 'mysql':
                return new MysqlSchemaSupplier($this->table_name);
                break;
            case 'pgsql':
                return new PgsqlSchemaSupplier($this->table_name);
                break;
            case 'sqlite':
                return new SqliteSchemaSupplier($this->table_name);
                break;
            default:
                throw new Exception('Unsupported Database');
        }
    }
}
