<?php

namespace Pratiksh\Imperium\Services\Resource\Form\Fields;

use Carbon\Carbon;
use Pratiksh\Imperium\Services\Resource\Form\InputField;

class DatePickerField extends InputField
{
    // Selection Mode
    const MULTIPLE_MODE = 'multiple';

    const RANGE_MODE = 'range';

    // Hour Format
    const HOUR_12 = '12';

    const HOUR_24 = '24';

    // View Only
    const MONTH = 'month';

    const YEAR = 'year';

    public string $format = 'yy/mm/dd';

    public bool $showOnFocus = true;

    public bool $iconDisplay = true;

    public ?Carbon $minDate = null;

    public ?Carbon $maxDate = null;

    public bool $showButtonBar = false;

    public string $hourFormat = self::HOUR_24;

    public bool $timeOnly = false;

    public bool $showTime = false;

    public ?string $view = null;

    public ?string $selectionMode = null;

    public bool $inline = false;

    public int $numberOfMonths = 1;

    public bool $manualInput = false;

    public function __construct(string $field, ?string $label = null)
    {
        parent::__construct($field, $label);
    }

    /**
     * Get the type of input field.
     */
    protected function getType(): string
    {
        return 'datePicker';
    }

    /**
     * Set format for the input field.
     *
     * @return $this
     */
    public function format(string $format = 'yy/mm/dd')
    {
        $this->format = $format;

        return $this;
    }

    /**
     * Set showOnFocus for the input field.
     *
     * @return $this
     */
    public function showOnFocus(bool $showOnFocus = true)
    {
        $this->showOnFocus = $showOnFocus;
        if (! $this->showOnFocus) {
            $this->manualInput = true;
            $this->iconDisplay = false;
        }

        return $this;
    }

    /**
     * Set iconDisplay for the input field.
     *
     * @return $this
     */
    public function iconDisplay(bool $iconDisplay = true)
    {
        $this->iconDisplay = $iconDisplay;

        return $this;
    }

    /**
     * Set minimum date for the input field.
     *
     * @return $this
     */
    public function minDate(Carbon $minDate)
    {
        $this->minDate = $minDate;

        return $this;
    }

    /**
     * Set maximum date for the input field.
     *
     * @return $this
     */
    public function maxDate(Carbon $maxDate)
    {
        $this->maxDate = $maxDate;

        return $this;
    }

    /**
     * Set showButtonBar for the input field.
     *
     * @return $this
     */
    public function showButtonBar(bool $showButtonBar = true)
    {
        $this->showButtonBar = $showButtonBar;

        return $this;
    }

    /**
     * Set hourFormat for the input field.
     *
     * @return $this
     */
    public function hourFormat(string $hourFormat = self::HOUR_24)
    {
        $this->hourFormat = $hourFormat;
        $this->showTime = true;

        return $this;
    }

    /**
     * Set timeOnly for the input field.
     *
     * @return $this
     */
    public function timeOnly(bool $timeOnly = true)
    {
        $this->timeOnly = $timeOnly;
        $this->manualInput = false;
        $this->showTime = true;

        return $this;
    }

    /**
     * Set showTime for the input field.
     *
     * @return $this
     */
    public function showTime(bool $showTime = true)
    {
        $this->showTime = $showTime;
        $this->manualInput = false;

        return $this;
    }

    /**
     * Set view on month for the input field.
     *
     * @return $this
     */
    public function viewOnlyMonth()
    {
        $this->view = self::MONTH;

        return $this;
    }

    /**
     * Set view on year for the input field.
     *
     * @return $this
     */
    public function viewOnlyYear()
    {
        $this->view = self::YEAR;

        return $this;
    }

    /**
     * Set selection mode to multiple for the input field.
     *
     * @return $this
     */
    public function multiple()
    {
        $this->selectionMode = self::MULTIPLE_MODE;
        $this->manualInput = false;

        return $this;
    }

    /**
     * Set selection mode to range for the input field.
     *
     * @return $this
     */
    public function range()
    {
        $this->selectionMode = self::RANGE_MODE;
        $this->manualInput = false;
        $this->showOnFocus = true;

        return $this;
    }

    /**
     * Set inline for the input field.
     *
     * @return $this
     */
    public function inline(bool $inline = true)
    {
        $this->inline = $inline;

        return $this;
    }

    /**
     * Set number of months for the input field.
     *
     * @return $this
     */
    public function numberOfMonths(int $numberOfMonths = 1)
    {
        $this->numberOfMonths = $numberOfMonths;

        return $this;
    }

    /**
     * Set manualInput for the input field.
     *
     * @return $this
     */
    public function manualInput(bool $manualInput = true)
    {
        $this->manualInput = $manualInput;

        return $this;
    }
}
