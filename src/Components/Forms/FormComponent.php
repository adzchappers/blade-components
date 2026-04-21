<?php

declare(strict_types=1);

namespace AdzChappers\BladeComponents\Components\Forms;

use AdzChappers\BladeComponents\Components\BladeComponent;
use Illuminate\Support\Str;

abstract class FormComponent extends BladeComponent
{
    public ?string $id = null;

    public ?string $value = null;

    public ?string $name = null;

    public bool $showError = false;

    /**
     * If the id is set when adding a blade component to a page, then this is
     * returned, otherwise, a unique id is automatically generated and returned
     */
    public function id(): string
    {
        if ($this->id) {
            return $this->id;
        }

        return $this->id = 'auto_' . uniqid();
    }

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

    /**
     * Checks to see if there is an error on this component
     */
    public function hasError(string $bag = 'default'): bool
    {
        if (session()->has('errors')) {
            $errorBag = session('errors')->getBag($bag);
            $errorName = $this->convertNameToDotNotation(true);

            // Check to see if name or name child has error
            if ($errorBag && ($errorBag->has($errorName) || $errorBag->has($errorName . '.*'))) {
                return true;
            }
        }

        return false;
    }

    /**
     * Should this component show an error
     */
    public function showError(): bool
    {
        return $this->showError && $this->hasError();
    }

    /**
     * Sets the value for the form component
     */
    public function setValue(
        ?string $default = null
    ): void {
        $this->value = old(
            $this->convertNameToDotNotation(),
            $default
        );
    }
}
