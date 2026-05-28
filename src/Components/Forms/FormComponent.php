<?php

declare(strict_types=1);

namespace AdzChappers\BladeComponents\Components\Forms;

use AdzChappers\BladeComponents\Components\BladeComponent;
use AdzChappers\BladeComponents\Concerns\Forms\InteractsWithFormName;

abstract class FormComponent extends BladeComponent
{
    use InteractsWithFormName;

    public string $name;

    public bool $showError;

    public ?string $id = null;

    public ?string $value = null;

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
