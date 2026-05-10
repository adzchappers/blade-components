<?php

declare(strict_types=1);

namespace AdzChappers\BladeComponents\Components\Forms;

use Illuminate\Support\Arr;

class FormCheckbox extends FormComponent
{
    public function __construct(
        public string $name,
        public ?string $id = null,
        public ?string $label = null,
        public ?string $value = '1',
        public bool $checked = false,
        public bool $required = false,
        public bool $readonly = false,
        public bool $showError = true,
    ) {
        // If checkbox is not checked, HTML forms do not send the input field in
        // the submission - this means blade old with $default will revert to
        // the original $default if a default checked checkbox is unchecked.

        // Check to see if there is a submission - Otherwise keep the default
        if (session()->hasOldInput()) {
            $oldData = old($this->convertNameToDotNotation(true));
            $this->checked = in_array($this->value, Arr::wrap($oldData));
        }
    }
}
