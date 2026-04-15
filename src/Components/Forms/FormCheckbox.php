<?php

declare(strict_types=1);

namespace AdzChappers\BladeComponents\Components\Forms;

use Illuminate\Support\Arr;

class FormCheckbox extends FormComponent
{
    public function __construct(
        public ?string $name,
        public ?string $id = null,
        public ?string $label = null,
        public ?string $value = '1',
        public bool $checked = false,
        public bool $required = false,
        public bool $readonly = false,
        public bool $showError = false,
    ) {
        // If checkbox is not checked, HTML forms do not send the specific input
        // field in the submission - this means it always falls back to the
        // default state, i.e. if the checkbox was checked by default and then
        // unchecked and there were form validation errors, the page would
        // render the checkbox as checked again, even if the user unchecked it

        // Check to see if there has been a form submission
        if (session()->hasOldInput()) {
            // Load up the old data if if exists for this item - if it's missing
            // i.e. (unchecked), old() returns null, set $this->checked false.
            $oldData = old($this->convertNameToDotNotation(true));

            $this->checked = in_array($this->value, Arr::wrap($oldData));
        }

        // Otherwise we keep the default state.
    }
}
