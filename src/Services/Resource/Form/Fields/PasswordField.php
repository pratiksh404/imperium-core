<?php

namespace Pratiksh\Imperium\Services\Resource\Form\Fields;

use Pratiksh\Imperium\Services\Resource\Form\InputField;

class PasswordField extends InputField
{
    public bool $feedback = true;

    public bool $showPassword = true;

    public bool $confirmPassword = false;

    public function __construct(string $field, ?string $label = null)
    {
        parent::__construct($field, $label);
    }

    /**
     * Get the type of input field.
     */
    protected function getType(): string
    {
        return 'password';
    }

    /**
     * Set password strength feedback dialog.
     *
     * @return $this
     */
    public function feedback(bool $feedback = true)
    {
        $this->feedback = $feedback;

        return $this;
    }

    /**
     * Set show password option.
     *
     * @return $this
     */
    public function showPassword(bool $showPassword = true)
    {
        $this->showPassword = $showPassword;

        return $this;
    }

    /**
     * Set confirm password option.
     *
     * @return $this
     */
    public function confirmPassword(bool $confirmPassword = true)
    {
        $this->confirmPassword = $confirmPassword;

        return $this;
    }
}
