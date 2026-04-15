<?php

declare(strict_types=1);

namespace AdzChappers\BladeComponents\Components\Forms;

use AdzChappers\BladeComponents\Components\BladeComponent;

class FormButton extends BladeComponent
{
    public function __construct(
        public string $type = 'submit',
    ) {
        $this->type = strtolower($this->type);

        if (!in_array($this->type, ['button', 'reset', 'submit'])) {
            $this->type = 'submit';
        }
    }
}
