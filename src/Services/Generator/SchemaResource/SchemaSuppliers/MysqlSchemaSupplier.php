<?php

namespace Pratiksh\Imperium\Services\Generator\SchemaResource\SchemaSuppliers;

use Illuminate\Support\Facades\DB;
use Pratiksh\Imperium\Contracts\Imperium\Generator\SchemaSupplierInterface;

class MysqlSchemaSupplier implements SchemaSupplierInterface
{
    public string $table_name;

    public function __construct(string $table_name)
    {
        $this->table_name = $table_name;
    }

    public function columns(): array
    {
        $databaseName = config('database.connections.mysql.database');
        $tableName = $this->table_name;

        $tableColumns = collect(DB::select('SHOW COLUMNS FROM '.$tableName))->keyBy('Field')->toArray();

        $foreignKeys = DB::select("
            SELECT k.COLUMN_NAME, k.REFERENCED_TABLE_NAME, k.REFERENCED_COLUMN_NAME
            FROM information_schema.TABLE_CONSTRAINTS i
            LEFT JOIN information_schema.KEY_COLUMN_USAGE k ON i.CONSTRAINT_NAME = k.CONSTRAINT_NAME
            WHERE i.CONSTRAINT_TYPE = 'FOREIGN KEY'
            AND i.TABLE_SCHEMA = '{$databaseName}'
            AND i.TABLE_NAME = '{$tableName}'
        ");

        foreach ($foreignKeys as $foreignKey) {
            $tableColumns[$foreignKey->COLUMN_NAME]->Foreign = [
                'table' => $foreignKey->REFERENCED_TABLE_NAME,
                'id' => $foreignKey->REFERENCED_COLUMN_NAME,
            ];
        }

        return $tableColumns ?? [];
    }

    public function tableName(): string
    {
        return $this->table_name;
    }
}
