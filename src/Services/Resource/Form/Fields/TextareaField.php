<?php

namespace Pratiksh\Imperium\Services\Resource\Form\Fields;

use Pratiksh\Imperium\Services\Resource\Form\InputField;

class TextareaField extends InputField
{
    public bool $autoResize = true;

    public int $rows = 5;

    public int $cols = 30;

    public function __construct(string $field, ?string $label = null)
    {
        parent::__construct($field, $label);
    }

    /**
     * Get the type of input field.
     */
    protected function getType(): string
    {
        return 'textarea';
    }

    /**
     * Set auto size for the textarea.
     *
     * @return $this
     */
    public function autoResize(bool $autoResize = true)
    {
        $this->autoResize = $autoResize;

        return $this;
    }

    /**
     * Set rows for the textarea.
     *
     * @return $this
     */
    public function rows(int $rows = 5)
    {
        $this->rows = $rows;

        return $this;
    }

    /**
     * Set cols for the textarea.
     *
     * @return $this
     */
    public function cols(int $cols = 30)
    {
        $this->cols = $cols;

        return $this;
    }
}
