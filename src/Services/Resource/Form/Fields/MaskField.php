<?php

namespace Pratiksh\Imperium\Services\Resource\Form\Fields;

use Pratiksh\Imperium\Services\Resource\Form\InputField;

class MaskField extends InputField
{
    public string $mask = '(999) 999-9999';

    public string $slotChar;

    public function __construct(string $field, ?string $label = null)
    {
        parent::__construct($field, $label);
    }

    /**
     * Get the type of input field.
     */
    protected function getType(): string
    {
        return 'mask';
    }

    /**
     * Set mask for the input field.
     *
     * @return $this
     */
    public function mask(string $mask)
    {
        $this->mask = $mask;

        return $this;
    }

    /**
     * Set slot char for the input field.
     *
     * @return $this
     */
    public function slotChar(string $slotChar)
    {
        $this->slotChar = $slotChar;

        return $this;
    }
}
