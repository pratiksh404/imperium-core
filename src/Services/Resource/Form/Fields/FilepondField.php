<?php

namespace Pratiksh\Imperium\Services\Resource\Form\Fields;

use Pratiksh\Imperium\Services\Resource\Form\InputField;

class FilepondField extends InputField
{
    const INSERT_ITEM_BEFORE = 'before';

    const INSERT_ITEM_AFTER = 'after';

    // Upload Type
    const IMAGE = 'image';

    const FILE = 'file';

    public string $uploadType = self::FILE;

    // Core Properties
    public string $name = 'filepond';

    public bool $allowDrop = true;

    public bool $allowBrowse = true;

    public bool $allowPaste = true;

    public bool $allowMultiple = true;

    public bool $allowReplace = true;

    public bool $allowRevert = true;

    public bool $allowRemove = true;

    public bool $allowReorder = false;

    public int $maxFiles = 10;

    public int $maxParallelUploads = 2;

    public int $itemInsertInterval = 75;

    public string $itemInsertLocation = self::INSERT_ITEM_BEFORE;

    // Drag and drop properties
    public bool $dropOnPage = false;

    public bool $dropOnElement = true;

    public bool $dropValidation = false;

    public array $ignoredFiles = ['.ds_store', 'thumbs.db', 'desktop.ini'];

    // File Size Validation
    public bool $allowFileSizeValidation = true;

    public string $minFileSize = '1KB';

    public string $maxFileSize = '10MB';

    public string $maxTotalFileSize = '50MB';

    public string $labelMaxFileSizeExceeded = 'File is too large';

    public string $labelMaxTotalFileSizeExceeded = 'Maximum total size exceeded';

    // File Type Validation
    public bool $allowFileTypeValidation = true;

    public array $acceptedFileTypes = ['image/*'];

    public function __construct(string $field, ?string $label = null)
    {
        parent::__construct($field, $label);
    }

    /**
     * Get the type of input field.
     */
    protected function getType(): string
    {
        return 'filepond';
    }

    /**
     * Set the field to allow dropping files.
     *
     * @return $this
     */
    public function allowDrop(bool $allow = true): self
    {
        $this->allowDrop = $allow;

        return $this;
    }

    /**
     * Set the field to allow browsing files.
     *
     * @return $this
     */
    public function allowBrowse(bool $allow = true): self
    {
        $this->allowBrowse = $allow;

        return $this;
    }

    /**
     * Set the field to allow pasting files.
     *
     * @return $this
     */
    public function allowPaste(bool $allow = true): self
    {
        $this->allowPaste = $allow;

        return $this;
    }

    /**
     * Set the field to allow multiple files.
     *
     * @return $this
     */
    public function allowMultiple(bool $allow = true): self
    {
        $this->allowMultiple = $allow;

        return $this;
    }

    /**
     * Set the field to allow replacing files.
     *
     * @return $this
     */
    public function allowReplace(bool $allow = true): self
    {
        $this->allowReplace = $allow;

        return $this;
    }

    /**
     * Set the field to allow reverting files.
     *
     * @return $this
     */
    public function allowRevert(bool $allow = true): self
    {
        $this->allowRevert = $allow;

        return $this;
    }

    /**
     * Set the field to allow removing files.
     *
     * @return $this
     */
    public function allowRemove(bool $allow = true): self
    {
        $this->allowRemove = $allow;

        return $this;
    }

    /**
     * Set the field to allow reordering files.
     *
     * @return $this
     */
    public function allowReorder(bool $allow = true): self
    {
        $this->allowReorder = $allow;

        return $this;
    }

    /**
     * Set the maximum number of files.
     *
     * @return $this
     */
    public function maxFiles(int $max): self
    {
        $this->maxFiles = $max;

        return $this;
    }

    /**
     * Set the maximum number of parallel uploads.
     *
     * @return $this
     */
    public function maxParallelUploads(int $max): self
    {
        $this->maxParallelUploads = $max;

        return $this;
    }

    /**
     * Set the item insert interval.
     *
     * @return $this
     */
    public function itemInsertInterval(int $interval): self
    {
        $this->itemInsertInterval = $interval;

        return $this;
    }

    /**
     * Set dropOnPage property
     *
     * @return $this
     */
    public function dropOnPage(bool $drop = true): self
    {
        $this->dropOnPage = $drop;

        return $this;
    }

    /**
     * Set dropOnElement property
     *
     * @return $this
     */
    public function dropOnElement(bool $drop = true): self
    {
        $this->dropOnElement = $drop;
        $this->dropOnPage = false;

        return $this;
    }

    /**
     * Set dropValidation property
     *
     * @return $this
     */
    public function dropValidation(bool $drop = true): self
    {
        $this->dropValidation = $drop;

        return $this;
    }

    /**
     * Set ignoredFiles property
     *
     * @return $this
     */
    public function ignoredFiles(array $files): self
    {
        $this->ignoredFiles = $files;

        return $this;
    }

    /**
     * Set the item insert location.
     *
     * @return $this
     */
    public function itemInsertLocation(string $location): self
    {
        $this->itemInsertLocation = $location;

        return $this;
    }

    /**
     * Set the minimum file size.
     *
     * @return $this
     */
    public function minFileSize(string $size): self
    {
        $this->minFileSize = $size;

        return $this;
    }

    /**
     * Set the maximum file size.
     *
     * @return $this
     */
    public function maxFileSize(string $size): self
    {
        $this->maxFileSize = $size;

        return $this;
    }

    /**
     * Set the maximum total file size.
     *
     * @return $this
     */
    public function maxTotalFileSize(string $size): self
    {
        $this->maxTotalFileSize = $size;

        return $this;
    }

    /**
     * Set the label for the maximum file size exceeded message.
     *
     * @return $this
     */
    public function labelMaxFileSizeExceeded(string $label): self
    {
        $this->labelMaxFileSizeExceeded = $label;

        return $this;
    }

    /**
     * Set the label for the maximum total file size exceeded message.
     *
     * @return $this
     */
    public function labelMaxTotalFileSizeExceeded(string $label): self
    {
        $this->labelMaxTotalFileSizeExceeded = $label;

        return $this;
    }

    /**
     * Set the file size validation.
     *
     * @return $this
     */
    public function allowFileSizeValidation(bool $allow = true): self
    {
        $this->allowFileSizeValidation = $allow;

        return $this;
    }

    /**
     * Set the accepted file types.
     *
     * @return $this
     */
    public function acceptedFileTypes(array $types): self
    {
        $this->acceptedFileTypes = $types;

        return $this;
    }
}
