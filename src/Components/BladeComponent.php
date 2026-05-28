<?php

declare(strict_types=1);

namespace AdzChappers\BladeComponents\Components;

use Illuminate\Support\Str;
use Illuminate\View\Component;
use Illuminate\View\View;

abstract class BladeComponent extends Component
{
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
}
