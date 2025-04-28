<?php

namespace Pratiksh\Imperium\Services\Resource\Form\Fields;

use Pratiksh\Imperium\Services\Resource\Form\InputField;

class ToggleButtonField extends InputField
{
    public string $onLabel = 'On';

    public string $offLabel = 'Off';

    public string $onIcon = 'pi pi-check';

    public string $offIcon = 'pi pi-times';

    public bool $hideIcon = false;

    public function __construct(string $field, ?string $label = null)
    {
        parent::__construct($field, $label);
        $this->size(InputField::SMALL);
    }

    /**
     * Get the type of input field.
     */
    protected function getType(): string
    {
        return 'toggleButton';
    }

    /**
     * Set on label for the toggle button.
     *
     * @return $this
     */
    public function onLabel(string $onLabel)
    {
        $this->onLabel = $onLabel;

        return $this;
    }

    /**
     * Set off label for the toggle button.
     *
     * @return $this
     */
    public function offLabel(string $offLabel)
    {
        $this->offLabel = $offLabel;

        return $this;
    }

    /**
     * Set on icon for the toggle button.
     *
     * @return $this
     */
    public function onIcon(string $onIcon)
    {
        $this->onIcon = $onIcon;

        return $this;
    }

    /**
     * Set off icon for the toggle button.
     *
     * @return $this
     */
    public function offIcon(string $offIcon)
    {
        $this->offIcon = $offIcon;

        return $this;
    }

    /**
     * Hide icon for the toggle button.
     *
     * @return $this
     */
    public function hideIcon(bool $hideIcon = true)
    {
        $this->hideIcon = $hideIcon;

        return $this;
    }
}
