<?php

declare(strict_types=1);

namespace AdzChappers\BladeComponents\Components;

use Illuminate\Support\Str;
use Illuminate\View\Component;
use Illuminate\View\View;

abstract class BladeComponent extends Component
{
    private ?string $id = null;

    /**
     * {@inheritDoc}
     */
    public function render(): View
    {
        $component = Str::kebab(class_basename($this));

        // TODO: Add in a base styling reference here?
        // $styling = config('blade-components.styling');

        return view(config("blade-components.components.{$component}.view"));
    }

    /**
     * Returns the ID of a component if it exists
     * If the ID doesn't exist, a unique one is assigned and returned
     */
    public function id(): string
    {
        if ($this->id) {
            return $this->id;
        }

        return $this->id = 'auto_' . uniqid();
    }
}
