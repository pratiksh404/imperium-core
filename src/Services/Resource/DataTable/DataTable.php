<?php

namespace Pratiksh\Imperium\Services\Resource\DataTable;

class DataTable
{
    // Table Properties
    public $dataKey = 'id';

    public bool $scrollable = true;

    public $scrollHeight = '70vh';

    public bool $paginator = true;

    public array $rowsPerPageOptions = [5, 10, 25, 50];

    public bool $canReorder = true;

    public bool $searchable = true;

    public bool $exportable = true;

    public bool $showGridlines = false;

    public bool $stripedRows = true;

    public bool $bulkDeletable = true;

    public bool $pooling = true;

    public $columns = [];

    public function columns(array $columns): self
    {
        $this->columns = $columns;

        return $this;
    }

    // Setter methods for changing properties

    public function setDataKey(string $dataKey): self
    {
        $this->dataKey = $dataKey;

        return $this;
    }

    public function scrollable(bool $scrollable = true): self
    {
        $this->scrollable = $scrollable;

        return $this;
    }

    public function scrollHeight(string $scrollHeight): self
    {
        $this->scrollHeight = $scrollHeight;

        return $this;
    }

    public function paginator(bool $paginator = true): self
    {
        $this->paginator = $paginator;

        return $this;
    }

    public function rowsPerPageOptions(array $rowsPerPageOptions): self
    {
        $this->rowsPerPageOptions = $rowsPerPageOptions;

        return $this;
    }

    public function canReorder(bool $canReorder = true): self
    {
        $this->canReorder = $canReorder;

        return $this;
    }

    public function searchable(bool $searchable = true): self
    {
        $this->searchable = $searchable;

        return $this;
    }

    public function exportable(bool $exportable = true): self
    {
        $this->exportable = $exportable;

        return $this;
    }

    public function setBulkDeletable(bool $bulkDeletable = true): self
    {
        $this->bulkDeletable = $bulkDeletable;

        return $this;
    }

    public function pooling(bool $pooling = true): self
    {
        $this->pooling = $pooling;

        return $this;
    }

    public function showGridlines(bool $showGridlines = true): self
    {
        $this->showGridlines = $showGridlines;

        return $this;
    }

    public function stripedRows(bool $stripedRows = true): self
    {
        $this->stripedRows = $stripedRows;

        return $this;
    }
}
