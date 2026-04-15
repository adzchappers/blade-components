<?php

declare(strict_types=1);

namespace AdzChappers\BladeComponents\Components\Forms;

class FormRadio extends FormComponent
{
    public function __construct(
        public ?string $name,
        public ?string $id,
        public ?string $label = null,
        public ?string $value = '1',
        public bool $checked = false,
        public bool $readonly = false,
        public bool $showError = false,
    ) {
        // Check to see if there has been a form submission
        if (session()->hasOldInput()) {
            // TODO: write a test to confirm this
            $this->checked = (old($this->convertNameToDotNotation(true)) == $value);
        }
    }
}
