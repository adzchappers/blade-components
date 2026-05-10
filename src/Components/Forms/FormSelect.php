<?php

declare(strict_types=1);

namespace AdzChappers\BladeComponents\Components\Forms;

use Illuminate\Support\Arr;

class FormSelect extends FormComponent
{
    public function __construct(
        public string $name,
        public ?string $id = null,
        public ?string $label = null,
        public ?string $placeholder = null, // TODO: Need to put this somewhere
        public array $options = [],
        public bool $multiple = false,
        public array | string | null $selected = null,
        public bool $disabled = false,
        public bool $required = false,
        public bool $readonly = false,
        public bool $showError = true,
    ) {
        if ($oldData = old($this->convertNameToDotNotation(true))) {
            $this->selected = Arr::wrap($oldData);
        } else {
            $this->selected = Arr::wrap($this->selected);
        }
    }

    public function isSelected($key)
    {
        return in_array($key, $this->selected);
    }
}
