<?php

declare(strict_types=1);

namespace Tests\Feature\Forms;

use Illuminate\Support\Facades\Session;
use PHPUnit\Framework\Attributes\Test;
use Tests\Concerns\InteractsWithErrors;
use Tests\TestCase;

class FormCheckboxTest extends TestCase
{
    use InteractsWithErrors;

    #[Test]
    public function checkbox_component_renders_with_name_and_value()
    {
        $view = $this->blade('<x-form-checkbox name="agree" value="1" />');

        $view->assertSee('type="checkbox"', false)
            ->assertSee('name="agree"', false)
            ->assertSee('value="1"', false);
    }

    #[Test]
    public function checkbox_component_renders_checked_when_checked()
    {
        $view = $this->blade('<x-form-checkbox name="agree" :checked="true" />');

        $view->assertSee('checked', false);
    }

    #[Test]
    public function checkbox_component_does_not_renders_checked_when_checked_default_no_submission()
    {
        // Set a different key/value for a fake form submission
        // This is so that we can fake the request old data
        session()->flashInput(['different-value' => '1']);

        // Assign the session to the request (normally dealt with in the web middleware)
        // But we aren't testing a route
        request()->setLaravelSession(Session::driver());

        $view = $this->blade('<x-form-checkbox name="agree" :checked="true" />');

        $view->assertDontSee('checked');
    }

    #[Test]
    public function checkbox_component_does_not_render_checked_when_not_checked()
    {
        $view = $this->blade('<x-form-checkbox name="agree" :checked="false" />');

        $view->assertDontSee('checked', false);
    }

    #[Test]
    public function checkbox_component_renders_required_with_aria()
    {
        $view = $this->blade('<x-form-checkbox name="agree" required />');

        $view->assertSee('required', false)
            ->assertSee('aria-required="true"', false);
    }

    #[Test]
    public function checkbox_component_renders_readonly_with_aria()
    {
        $view = $this->blade('<x-form-checkbox name="agree" readonly />');

        $view->assertSee('tabindex="-1"', false)
            ->assertSee('aria-readonly="true"', false)
            ->assertSee('pointer-events-none', false);
    }

    #[Test]
    public function checkbox_component_renders_label()
    {
        $view = $this->blade('<x-form-checkbox name="agree" label="I agree to the terms" />');

        $view->assertSee('I agree to the terms', false)
            ->assertSee('<label', false);
    }

    #[Test]
    public function checkbox_component_label_for_matches_input_id()
    {
        $view = $this->blade('<x-form-checkbox name="agree" label="Agree" id="agree-checkbox" />');

        $view->assertSee('id="agree-checkbox"', false)
            ->assertSee('for="agree-checkbox"', false);
    }

    #[Test]
    public function checkbox_component_generates_id_when_not_provided()
    {
        $view = $this->blade('<x-form-checkbox name="agree" label="Agree" />');

        $view->assertSee('id="', false);
    }

    #[Test]
    public function checkbox_component_does_not_render_label_when_not_provided()
    {
        $view = $this->blade('<x-form-checkbox name="agree" />');

        $view->assertDontSee('<label', false);
    }

    #[Test]
    public function checkbox_component_does_not_show_error_by_default(): void
    {
        $this->shareErrors(['agree' => 'You must agree']);

        $view = $this->blade('<x-form-checkbox name="agree" />');

        $view->assertDontSee('text-red-600', false);
    }

    #[Test]
    public function checkbox_component_shows_error_when_show_errors_is_true(): void
    {
        $this->shareErrors(['agree' => 'You must agree']);

        $view = $this->blade('<x-form-checkbox name="agree" show-error />');

        $view->assertSee('You must agree', false)
            ->assertSee('text-red-600', false);
    }

    #[Test]
    public function checkbox_component_does_not_show_error_when_field_has_no_errors(): void
    {
        $this->shareErrors(['name' => 'Name is required']);

        $view = $this->blade('<x-form-checkbox name="agree" show-error />');

        $view->assertDontSee('text-red-600', false);
    }
}
