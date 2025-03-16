<?php

namespace AdzChappers\BladeComponents\Components\Forms;

use AdzChappers\BladeComponents\Components\BladeComponent;

class Form extends BladeComponent
{
    /**
     * Request method.
     */
    public string $method;

    /**
     * HTML forms do not support PUT, PATCH, or DELETE actions
     * Laravel sends these as a POST with a spoofed method
     *
     * https://laravel.com/docs/master/routing#form-method-spoofing
     */
    public bool $spoofed = false;

    /**
     * Defines if the form should be set up to send files
     */
    public bool $hasFiles;

    public function __construct(
        string $method = 'POST',
        bool $hasFiles = false
    ) {
        $this->hasFiles = $hasFiles;
        $this->method = strtoupper($method);
        $this->spoofed = in_array($this->method, ['PUT', 'PATCH', 'DELETE']);
    }
}
