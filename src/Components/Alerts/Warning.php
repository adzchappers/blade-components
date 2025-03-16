<?php

declare(strict_types=1);

namespace AdzChappers\BladeComponents\Components\Alerts;

use AdzChappers\BladeComponents\Components\BladeComponent;

class Warning extends BladeComponent
{
    public function __construct(
        public string $type,
    ) {
        //
    }

    public function message(): string
    {
        return (string) Arr::first($this->messages());
    }

    public function messages(): array
    {
        return (array) session()->get($this->type);
    }

    public function exists(): bool
    {
        return session()->has($this->type) && ! empty($this->messages());
    }
}
