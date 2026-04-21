<?php

declare(strict_types=1);

namespace AdzChappers\BladeComponents\Components\Forms;

use AdzChappers\BladeComponents\Components\BladeComponent;
use AdzChappers\BladeComponents\Concerns\Forms\InteractsWithFormName;

class FormError extends BladeComponent
{
    use InteractsWithFormName;

    // Want to change this so it doesn't extend form component, but i need this to be convertname aware :think:
    public function __construct(
        public string $name,
        public string $bag = 'default',
    ) {
        // Need to convert the given name to a dot notation
        // Name could be the field name e.g. "somename[key]"
        // Or this could be called directly as a specific errro to look for
        // e.g. somename.key
        $this->name = $this->convertNameToDotNotation(true);
    }
}
