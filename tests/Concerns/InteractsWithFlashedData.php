<?php

declare(strict_types=1);

namespace Tests\Concerns;

use Illuminate\Support\Facades\Session;

trait InteractsWithFlashedData
{
    private function flashFormData(
        array $data = []
    ): void {
        // Flash the submitted form data so that  we have access to it in old()
        // Array should be a key/value pair
        session()->flashInput($data);

        // Assign the session to the request - this is normally dealt with in
        // the web middleware, but we aren't testing a route
        request()->setLaravelSession(Session::driver());
    }
}
