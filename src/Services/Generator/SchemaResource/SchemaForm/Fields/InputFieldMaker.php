<?php

namespace Pratiksh\Imperium\Services\Generator\SchemaResource\SchemaForm\Fields;

use Pratiksh\Imperium\Services\Generator\SchemaResource\SchemaForm\FieldMaker;

class InputFieldMaker extends FieldMaker
{
    public function __construct(array $field_info)
    {
        parent::__construct($field_info);
    }

    public static function for(array $field_info): self
    {
        return new self($field_info);
    }

    public function grab(): string
    {
        $field_name = $this->field_name;
        // Appending input field class
        $this->append('Pratiksh\Imperium\Services\Resource\Form\Fields\TextField::make("'.$field_name.'")');

        // Default
        $this->appendDefaultValue();

        return $this->input_field;
    }
}
