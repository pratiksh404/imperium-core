<?php

namespace Pratiksh\Imperium\Contracts\Imperium\Generator;

interface SchemaRuleInterface
{
    public function __construct(string $table_name);

    public function rules(): array;

    public function ruleForColumn(string $column_name): array;
}
