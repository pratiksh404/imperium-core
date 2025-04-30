<?php

namespace Pratiksh\Imperium\Services\Resource\DataTable\Columns;

use Illuminate\Support\Str;
use Pratiksh\Imperium\Services\Resource\DataTable\DataTableColumn;

class TextColumn extends DataTableColumn
{
    protected ?int $maxLength = null;

    protected bool $allowNewLines = true;

    public function __construct(string $field, ?string $label = null)
    {
        parent::__construct($field, $label);
    }

    public static function make(string $field, ?string $label = null): static
    {
        return new static($field, $label);
    }

    /**
     * Limit the text to a specific maximum length.
     *
     * @return $this
     */
    public function maxLength(int $length)
    {
        $this->maxLength = $length;

        return $this;
    }

    /**
     * Allow or disallow new lines in the text.
     *
     * @return $this
     */
    public function allowNewLines(bool $allow = true)
    {
        $this->allowNewLines = $allow;

        return $this;
    }

    /**
     * Render the column value with text-specific formatting.
     *
     * @param  mixed  $value
     * @param  mixed  $row
     * @return string
     */
    public function render($value, $row)
    {
        // Apply default value if set
        $value = $this->defaultCallback ? call_user_func($this->defaultCallback, $value) : $value;

        // Apply max length restriction
        if ($this->maxLength !== null && is_string($value)) {
            $value = Str::limit($value, $this->maxLength);
        }

        // Remove new lines if disallowed
        if (! $this->allowNewLines && is_string($value)) {
            $value = str_replace(["\r", "\n"], ' ', $value);
        }

        // Apply format callback if set
        if ($this->formatCallback) {
            $value = call_user_func($this->formatCallback, $value, $row, $this);
        }

        // Handle HTML rendering
        if ($this->isHtml) {
            return $value; // Render as raw HTML
        }

        return htmlspecialchars($value); // Render as plain text
    }
}
