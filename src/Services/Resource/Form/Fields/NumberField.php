<?php

namespace Pratiksh\Imperium\Services\Resource\Form\Fields;

use Pratiksh\Imperium\Services\Resource\Form\InputField;

class NumberField extends InputField
{
    // Stepper Layout
    const STEPPER_VERTICAL = 'vertical';

    const STEPPER_HORIZONTAL = 'horizontal';

    public int $min = 0;

    public int $max;

    public int $minFractionDigits = 2;

    public int $maxFractionDigits = 4;

    public bool $withGrouping = false;

    public $currency;

    public $prefixForNumber;

    public $suffixForNumber;

    public $stepper = false;

    public $stepperLayout;

    public $step = 1;

    public function __construct(string $field, ?string $label = null)
    {
        parent::__construct($field, $label);
    }

    /**
     * Get the type of input field.
     */
    protected function getType(): string
    {
        return 'number';
    }

    /**
     * Set minimum value for the input field.
     *
     * @return $this
     */
    public function min(int $min)
    {
        $this->min = $min;

        return $this;
    }

    /**
     * Set maximum value for the input field.
     *
     * @return $this
     */
    public function max(int $max)
    {
        $this->max = $max;

        return $this;
    }

    /**
     * Set minimum fraction value for the input field.
     *
     * @return $this
     */
    public function minFractionDigits(int $minFractionDigits)
    {
        $this->minFractionDigits = $minFractionDigits;

        return $this;
    }

    /**
     * Set maximum fraction value for the input field.
     *
     * @return $this
     */
    public function maxFractionDigits(int $maxFractionDigits)
    {
        $this->maxFractionDigits = $maxFractionDigits;

        return $this;
    }

    /**
     * Set currency for the input field.
     *
     * @return $this
     */
    public function currency(string $currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Set prefix for the input field.
     *
     * @return $this
     */
    public function prefixForNumber(string $prefixForNumber)
    {
        $this->prefixForNumber = $prefixForNumber;

        return $this;
    }

    /**
     * Set suffix for the input field.
     *
     * @return $this
     */
    public function suffixForNumber(string $suffixForNumber)
    {
        $this->suffixForNumber = $suffixForNumber;

        return $this;
    }

    /**
     * Set stepper for the input field.
     *
     * @return $this
     */
    public function stepper(?string $stepperLayout = null)
    {
        $this->stepper = true;

        $this->stepperLayout = $stepperLayout;

        return $this;
    }

    /**
     * Set step for the input field.
     *
     * @return $this
     */
    public function step($step = 1)
    {
        $this->stepper = true;

        $this->step = $step;

        return $this;
    }
}
