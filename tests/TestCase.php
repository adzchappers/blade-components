<?php

namespace Tests;

use AdzChappers\BladeComponents\BladeComponentsServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            BladeComponentsServiceProvider::class,
        ];
    }
}
