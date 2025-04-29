<?php

namespace Pratiksh\Imperium\Services\Generator\SchemaResource\SchemaSuppliers;

use Illuminate\Support\Facades\DB;
use Pratiksh\Imperium\Contracts\Core\Generator\SchemaSupplierInterface;

class PgsqlSchemaSupplier implements SchemaSupplierInterface
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

        $tableColumns = collect(DB::select(
            '
            SELECT column_name, data_type, character_maximum_length, is_nullable, column_default
                FROM INFORMATION_SCHEMA.COLUMNS
            WHERE table_name = :table ORDER BY ordinal_position',
            ['table' => $tableName]
        ))->keyBy('column_name')->toArray();

        $foreignKeys = DB::select("
            SELECT
                kcu.column_name,
                ccu.table_name AS foreign_table_name,
                ccu.column_name AS foreign_column_name
            FROM
                information_schema.table_constraints AS tc
                JOIN information_schema.key_column_usage AS kcu
                  ON tc.constraint_name = kcu.constraint_name
                  AND tc.table_schema = kcu.table_schema
                JOIN information_schema.constraint_column_usage AS ccu
                  ON ccu.constraint_name = tc.constraint_name
                  AND ccu.table_schema = tc.table_schema
            WHERE tc.constraint_type = 'FOREIGN KEY' AND tc.table_name=? AND tc.table_catalog=?
        ", [$tableName, $databaseName]);

        foreach ($foreignKeys as $foreignKey) {
            $tableColumns[$foreignKey->column_name]->Foreign = [
                'table' => $foreignKey->foreign_table_name,
                'id' => $foreignKey->foreign_column_name,
            ];
        }

        return $tableColumns;
    }

    public function tableName(): string
    {
        return $this->table_name;
    }
}
