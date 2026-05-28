<?php

declare(strict_types=1);

namespace AdzChappers\BladeComponents\Components\Forms;

use AdzChappers\BladeComponents\Components\BladeComponent;

class FormLabel extends BladeComponent
{
    public function __construct(
        public string $for,
        public bool $required = false,
    ) {}
}
