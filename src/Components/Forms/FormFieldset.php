<?php

declare(strict_types=1);

namespace AdzChappers\BladeComponents\Components\Forms;

use AdzChappers\BladeComponents\Components\BladeComponent;

class FormFieldset extends BladeComponent
{
    public function __construct(
        public ?string $legend = null,
        public bool $disabled = false,
    ) {}
}
