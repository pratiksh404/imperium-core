<?php

namespace Pratiksh\Imperium\Services\Generator\SchemaResource\SchemaSuppliers;

use Illuminate\Support\Facades\DB;
use Pratiksh\Imperium\Contracts\Core\Generator\SchemaSupplierInterface;

class SqliteSchemaSupplier implements SchemaSupplierInterface
{
    public string $table_name;

    public function __construct(string $table_name)
    {
        $this->table_name = $table_name;
    }

    public function columns(): array
    {
        $table_name = $this->table_name;
        $tableColumns = collect(DB::select("PRAGMA table_info('{$table_name}')"))->keyBy('name')->toArray();

        $foreignKeys = DB::select("PRAGMA foreign_key_list({$table_name})");

        foreach ($foreignKeys as $foreignKey) {
            $tableColumns[$foreignKey->from]->Foreign = [
                'table' => $foreignKey->table,
                'id' => $foreignKey->to,
            ];
        }

        return $tableColumns;
    }

    public function tableName(): string
    {
        return $this->table_name;
    }
}
