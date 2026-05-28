<?php

declare(strict_types=1);

namespace AdzChappers\BladeComponents\Concerns\Forms;

use Illuminate\Support\Str;

trait InteractsWithFormName
{
    /**
     * Strips out array notation so "somename[key]" -> "somename.key"
     * Can also remove the dynamic array notation so "somename[]" -> "somename"
     *
     * Needed for:
     *  - old() - needs the dot notation key name
     *  - errors - Laravel returns errors as dot notation
     */
    public function convertNameToDotNotation(
        bool $dropArraySuffix = false
    ): string {
        $name = $this->name;

        if ($dropArraySuffix) {
            $name = Str::before($name, '[]');
        }

        return str_replace(['[', ']'], ['.', ''], $name);
    }
}
