<?php

declare(strict_types=1);

namespace AdzChappers\BladeComponents\Components\Forms;

class FormInput extends FormComponent
{
    public function __construct(
        public string $name,
        public ?string $id,
        public ?string $label = null,
        public string $type = 'text',
        public ?string $placeholder = null,
        public ?string $value = null,
        public bool $disabled = false,
        public bool $required = false,
        public bool $readonly = false,
        public bool $showError = false,
    ) {
        $this->setValue($this->value);
    }
}
