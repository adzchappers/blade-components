<?php

declare(strict_types=1);

namespace AdzChappers\BladeComponents\Components\Forms;

class FormRadio extends FormComponent
{
    public function __construct(
        public string $name,
        public ?string $id = null,
        public ?string $label = null,
        public ?string $value = '1',
        public bool $checked = false,
        public bool $required = false,
        public bool $disabled = false,
        public bool $readonly = false,
        public bool $showError = true,
    ) {
        if (session()->hasOldInput()) {
            $this->checked = (old($this->convertNameToDotNotation(true)) == $value);
        }
    }
}
