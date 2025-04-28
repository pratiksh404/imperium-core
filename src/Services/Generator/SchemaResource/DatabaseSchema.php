<?php

namespace Pratiksh\Imperium\Services\Generator\SchemaResource;

use Exception;
use Pratiksh\Imperium\Contracts\Imperium\Generator\SchemaRuleInterface;
use Pratiksh\Imperium\Contracts\Imperium\Generator\SchemaSupplierInterface;
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

    public function __construct(string $table_name)
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

        switch ($database_driver_name) {
            case 'mysql':
                return new MysqlSchemaRule($this->table_name);
                break;
            case 'pgsql':
                return new PgsqlSchemaRule($this->table_name);
                break;
            case 'sqlite':
                return new SqliteSchemaRule($this->table_name);
                break;
            default:
                throw new Exception('Unsupported Database');
                break;
        }
    }

    private function supplier(): SchemaSupplierInterface
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
