<?php

namespace Pratiksh\Imperium\Services\Resource\Form\Fields;

use Pratiksh\Imperium\Services\Resource\Form\InputField;

class OtpField extends InputField
{
    public int $length = 4;

    public bool $masked = false;

    public bool $integerOnly = false;

    public function __construct(string $field, ?string $label = null)
    {
        parent::__construct($field, $label);
    }

    /**
     * Get the type of input field.
     */
    protected function getType(): string
    {
        return 'otp';
    }

    /**
     * Set the length of the OTP.
     *
     * @return $this
     */
    public function length(int $length): self
    {
        $this->length = $length;

        return $this;
    }

    /**
     * Set mask of the OTP.
     *
     * @return $this
     */
    public function masked(bool $masked = true): self
    {
        $this->masked = $masked;

        return $this;
    }

    /**
     * Set integer only of the OTP.
     *
     * @return $this
     */
    public function integerOnly(bool $integerOnly = true): self
    {
        $this->integerOnly = $integerOnly;

        return $this;
    }
}
