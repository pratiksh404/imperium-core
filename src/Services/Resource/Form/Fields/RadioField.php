<?php

namespace Pratiksh\Imperium\Services\Resource\Form\Fields;

use Illuminate\Support\Collection;
use Pratiksh\Imperium\Services\Resource\Form\InputField;

class RadioField extends InputField
{
    public $options = [];

    public function __construct(string $field, ?string $label = null)
    {
        parent::__construct($field, $label);
    }

    /**
     * Get the type of input field.
     */
    protected function getType(): string
    {
        return 'radio';
    }

    public function options(array $options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Prepare options from collection for select.
     */
    public function optionCollection(Collection $collection, $label, $value)
    {
        $this->options = $collection->map(function ($data) use ($value, $label) {
            $value = $data->$value;
            $label = $data->$label;

            return CheckboxOption::make($value, $label);
        })->toArray();

        return $this;
    }
}

class RadioOption
{
    public $value;

    public $label;

    public function __construct($value, $label)
    {
        $this->value = $value;
        $this->label = $label;
    }

    public static function make($value, $label)
    {
        return new static($value, $label);
    }
}
