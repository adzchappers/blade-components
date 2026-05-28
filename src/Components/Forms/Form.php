<?php

declare(strict_types=1);

namespace AdzChappers\BladeComponents\Components\Forms;

use AdzChappers\BladeComponents\Components\BladeComponent;

class Form extends BladeComponent
{
    /**
     * HTML forms do not support PUT, PATCH, or DELETE actions
     * Laravel sends these as a POST with a spoofed method
     *
     * https://laravel.com/docs/master/routing#form-method-spoofing
     */
    public bool $spoofed;

    public function __construct(
        public string $method = 'POST',
        public bool $hasFiles = false,
    ) {
        $this->method = strtoupper($this->method);
        $this->spoofed = in_array($this->method, ['PUT', 'PATCH', 'DELETE'], strict: true);
    }
}
