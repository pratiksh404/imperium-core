<?php

namespace Pratiksh\Imperium\Services\Resource\DataTable\Columns;

use Closure;

class DataTableColumn
{
    public string $field;

    public string $label;

    public bool $sortable = false;

    public bool $searchable = false;

    protected ?Closure $formatCallback = null;

    protected ?Closure $defaultCallback = null;

    protected bool $isHtml = false;

    /**
     * Create a new column instance.
     */
    public function __construct(string $field, ?string $label = null)
    {
        $this->field = $field;
        $this->label = $label ?? ucfirst($field);
    }

    /**
     * Make a new column instance.
     *
     * @return static
     */
    public static function make(string $field, ?string $label = null)
    {
        return new static($field, $label);
    }

    /**
     * Mark the column as sortable.
     *
     * @return $this
     */
    public function sortable()
    {
        $this->sortable = true;

        return $this;
    }

    /**
     * Mark the column as searchable.
     *
     * @return $this
     */
    public function searchable()
    {
        $this->searchable = true;

        return $this;
    }

    /**
     * Set a custom format callback for the column.
     *
     * @return $this
     */
    public function format(Closure $callback)
    {
        $this->formatCallback = $callback;

        return $this;
    }

    /**
     * Set a default value for empty or null fields.
     *
     * @return $this
     */
    public function default(string $default)
    {
        $this->defaultCallback = fn ($value) => $value ?? $default;

        return $this;
    }

    /**
     * Enable HTML rendering for the column.
     *
     * @return $this
     */
    public function html()
    {
        $this->isHtml = true;

        return $this;
    }

    /**
     * Render the column value.
     *
     * @param  mixed  $value
     * @param  mixed  $row
     * @return mixed
     */
    public function render($value, $row)
    {
        // Apply default value if set
        $value = $this->defaultCallback ? call_user_func($this->defaultCallback, $value) : $value;

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

    /**
     * Get the field name.
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * Get the label for the column.
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * Check if the column is sortable.
     */
    public function isSortable(): bool
    {
        return $this->sortable;
    }

    /**
     * Check if the column is searchable.
     */
    public function isSearchable(): bool
    {
        return $this->searchable;
    }
}
