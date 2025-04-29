<?php

namespace Pratiksh\Imperium\Services\Resource\Form;

class Form
{
    public bool $authorize = true;

    public string $formComponent;

    public array $fields = [];

    public array $steppers = [];

    public array $tabs = [];

    /*
    |--------------------------------------------------------------------------
    | Mode in which form can be rendered
    |--------------------------------------------------------------------------
    |
    */
    const DRAWER_MODE = 'drawer';

    const DIALOG_MODE = 'dialog';

    public string $opensIn = self::DRAWER_MODE;

    public bool $precognition_mode = false;

    /**
     * Form authorization
     *
     * @return $this
     */
    public function authorize(bool $authorize = true)
    {
        $this->authorize = $authorize;

        return $this;
    }

    /**
     * Add a field to the form.
     *
     * @return $this
     */
    public function fields(array $fields): self
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * Add a stepper to the form.
     *
     * @return $this
     */
    public function steppers(array $steppers): self
    {
        $this->steppers = $steppers;

        return $this;
    }

    /**
     * Add a tab to the form.
     *
     * @return $this
     */
    public function tabs(array $tabs): self
    {
        $this->tabs = $tabs;

        return $this;
    }

    /**
     * Sets a opensIn in which form can be rendered
     *
     * @return $this
     */
    public function opensIn(string $opensIn): self
    {
        $this->opensIn = $opensIn;

        return $this;
    }

    /**
     * Sets a precognition mode in which form can be rendered
     *
     * @return $this
     */
    public function precognitionMode(bool $precognition_mode = true): self
    {
        $this->precognition_mode = $precognition_mode;

        return $this;
    }
}

class Group
{
    public string $title;

    public bool $authorize = true;

    public array $fields = [];

    final public function __construct(string $title)
    {
        $this->title = $title;
    }

    /**
     * Make a new stepper instance.
     *
     * @return static
     */
    public static function make(string $field)
    {
        return new static($field);
    }

    /**
     * Form authorization
     *
     * @return $this
     */
    public function authorize(bool $authorize = true)
    {
        $this->authorize = $authorize;

        return $this;
    }

    /**
     * Add a field to the form.
     *
     * @return $this
     */
    public function fields(array $fields): self
    {
        $this->fields = $fields;

        return $this;
    }
}
