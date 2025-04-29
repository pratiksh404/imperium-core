<?php

namespace Pratiksh\Imperium\Contracts\Core\Generator;

interface SchemaSupplierInterface
{

    public function __construct(string $table_name);

    public function columns(): array;

    public function tableName(): string;
}
