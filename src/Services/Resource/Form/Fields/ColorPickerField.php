<?php

namespace Pratiksh\Imperium\Services\Resource\Form\Fields;

use Pratiksh\Imperium\Services\Resource\Form\InputField;

class ColorPickerField extends InputField
{
    // Colorfield format types
    const HEX = 'hex';

    const RGB = 'rgb';

    const HSB = 'hsb';

    public bool $inline = true;

    public string $format = self::HEX;

    public function __construct(string $field, ?string $label = null)
    {
        parent::__construct($field, $label);
    }

    /**
     * Get the type of input field.
     */
    protected function getType(): string
    {
        return 'colorPicker';
    }

    /**
     * Set the format of the color picker field.
     *
     * @return $this
     */
    public function format(string $format): self
    {
        $this->format = $format;

        return $this;
    }

    /**
     * Set the color picker field to be inline.
     *
     * @return $this
     */
    public function inline(): self
    {
        $this->inline = true;

        return $this;
    }
}
