<?php

declare(strict_types=1);

namespace Tests\Concerns;

use Illuminate\Support\Facades\View;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;

trait InteractsWithErrors
{
    private function shareErrors(
        array $messages = [],
        string $bag = 'default'
    ): void {
        // Load up Laravel Session manager
        $session = app('session.store');

        // Create the error bag
        $viewErrorBag = new ViewErrorBag;

        // Add error messages if there are any
        if (count($messages) > 0) {
            $errors = new MessageBag($messages);
            $viewErrorBag->put($bag, $errors);
        }

        // Flash the bag to the session
        // Needed because components check to see if there is an error session
        $session->flash('errors', $viewErrorBag);

        // Share the bag to the view
        // Blade @error looks for the $errors shared in a View
        View::share('errors', $viewErrorBag);
    }
}
