<?php

namespace Pratiksh\Imperium\Services\Generator\SchemaResource\SchemaForm;

abstract class FieldMaker
{
    public string $field_name;

    public bool $required = false;

    public $default = null;

    public array $field_info;

    public string $input_field = '\n';

    public array $database_column;

    public array $request_rules;

    public function __construct(array $field_info)
    {
        $this->field_info = $field_info;
        $this->database_column = collect($field_info['database_column'])->toArray();
        $this->request_rules = $field_info['request_rules'];
        $this->field_name = $this->database_column['Field'];
    }

    public static function for(array $field_info): self
    {
        return new self($field_info);
    }

    protected function append(string $appendable): string
    {
        $this->input_field .= ('->'.trim($appendable));

        return $this->input_field;
    }

    protected function appendDefaultValue()
    {
        $default = $this->field_info['Default'];
        if (! is_null($default)) {
            $this->append('->default('.(is_numeric($default) ? $default : '"'.$default.'"').')');
        }
    }

    abstract public function grab(): string;
}
