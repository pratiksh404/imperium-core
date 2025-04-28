<?php

namespace Pratiksh\Imperium\Services\Resource\Form\Fields;

use Pratiksh\Imperium\Services\Resource\Form\InputField;

class RatingField extends InputField
{
    public int $stars = 5;

    public function __construct(string $field, ?string $label = null)
    {
        parent::__construct($field, $label);
    }

    /**
     * Get the type of input field.
     */
    protected function getType(): string
    {
        return 'rating';
    }

    /**
     * Set number of stars for the input field.
     *
     * @return $this
     */
    public function stars(int $stars = 5)
    {
        $this->stars = $stars;

        return $this;
    }
}
