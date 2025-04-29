<?php

namespace Pratiksh\Imperium\Services\Generator\SchemaResource;

use Exception;
use Pratiksh\Imperium\Contracts\Core\Generator\SchemaRuleInterface;
use Pratiksh\Imperium\Contracts\Core\Generator\SchemaSupplierInterface;
use Pratiksh\Imperium\Services\Generator\SchemaResource\SchemaRules\MysqlSchemaRule;
use Pratiksh\Imperium\Services\Generator\SchemaResource\SchemaRules\PgsqlSchemaRule;
use Pratiksh\Imperium\Services\Generator\SchemaResource\SchemaRules\SqliteSchemaRule;
use Pratiksh\Imperium\Services\Generator\SchemaResource\SchemaSuppliers\MysqlSchemaSupplier;
use Pratiksh\Imperium\Services\Generator\SchemaResource\SchemaSuppliers\PgsqlSchemaSupplier;
use Pratiksh\Imperium\Services\Generator\SchemaResource\SchemaSuppliers\SqliteSchemaSupplier;

class DatabaseSchema
{
    public string $driver_name;

    public SchemaSupplierInterface $supplier;

    public SchemaRuleInterface $arbiter;

    public string $table_name;

    final public function __construct(string $table_name)
    {
        $this->driver_name = getDatabaseDriverName();
        $this->table_name = $table_name;
        $this->supplier = $this->supplier();
        $this->arbiter = $this->arbiter();
    }

    public static function for(string $table_name): self
    {
        return new static($table_name);
    }

    public function columns()
    {
        return $this->supplier->columns();
    }

    public function rules()
    {
        return $this->arbiter->rules();
    }

    private function arbiter(): SchemaRuleInterface
    {
        $database_driver_name = getDatabaseDriverName();
        // Check if the database driver name is supported
        if ($database_driver_name == 'mysql') {
            return new MysqlSchemaRule($this->table_name);
        } elseif ($database_driver_name == 'pgsql') {
            return new PgsqlSchemaRule($this->table_name);
        } elseif ($database_driver_name == 'sqlite') {
            return new SqliteSchemaRule($this->table_name);
        } else {
            throw new Exception('Unsupported Database');
        }
    }

    private function supplier(): SchemaSupplierInterface
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
