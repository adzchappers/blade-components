<?php

declare(strict_types=1);

namespace AdzChappers\BladeComponents\Components\Forms;

use AdzChappers\BladeComponents\Components\BladeComponent;

class FormErrorList extends BladeComponent
{
    public function __construct(
        public string $bag = 'default',
    ) {}
}
