<?php

declare(strict_types=1);

namespace Tests\Feature\Forms;

use PHPUnit\Framework\Attributes\Test;
use Tests\Concerns\InteractsWithErrors;
use Tests\TestCase;

class FormInputTest extends TestCase
{
    use InteractsWithErrors;

    #[Test]
    public function input_component_renders_with_required_name()
    {
        $view = $this->blade('<x-form-input name="email" />');

        $view->assertSee('name="email"', false)
            ->assertSee('type="text"', false);
    }

    #[Test]
    public function input_component_renders_with_custom_type()
    {
        $view = $this->blade('<x-form-input name="email" type="email" />');

        $view->assertSee('type="email"', false);
    }

    #[Test]
    public function input_component_renders_with_placeholder()
    {
        $view = $this->blade('<x-form-input name="email" placeholder="Enter email" />');

        $view->assertSee('placeholder="Enter email"', false);
    }

    #[Test]
    public function input_component_renders_with_value()
    {
        $view = $this->blade('<x-form-input name="email" value="test@example.com" />');

        $view->assertSee('value="test@example.com"', false);
    }

    #[Test]
    public function input_component_renders_required_with_aria()
    {
        $view = $this->blade('<x-form-input name="email" required />');

        $view->assertSee('required', false)
            ->assertSee('aria-required="true"', false);
    }

    #[Test]
    public function input_component_renders_disabled_with_aria()
    {
        $view = $this->blade('<x-form-input name="email" disabled />');

        $view->assertSee('disabled', false)
            ->assertSee('aria-disabled="true"', false);
    }

    #[Test]
    public function input_component_generates_id()
    {
        $view = $this->blade('<x-form-input name="email" />');

        $view->assertSee('id="', false);
    }

    #[Test]
    public function input_component_renders_label()
    {
        $view = $this->blade('<x-form-input name="email" label="Email address" />');

        $view->assertSee('Email address', false)
            ->assertSee('<label', false);
    }

    #[Test]
    public function input_component_label_for_matches_input_id()
    {
        $view = $this->blade('<x-form-input name="email" label="Email address" id="email-field" />');

        $view->assertSee('id="email-field"', false)
            ->assertSee('for="email-field"', false);
    }

    #[Test]
    public function input_component_does_not_render_label_when_not_provided()
    {
        $view = $this->blade('<x-form-input name="email" />');

        $view->assertDontSee('<label', false);
    }

    #[Test]
    public function input_component_renders_readonly_with_aria()
    {
        $view = $this->blade('<x-form-input name="email" readonly />');

        $view->assertSee('readonly', false)
            ->assertSee('aria-readonly="true"', false);
    }

    #[Test]
    public function input_component_does_not_show_error_by_default(): void
    {
        $this->shareErrors(['email' => 'Email is required']);

        $view = $this->blade('<x-form-input name="email" />');

        $view->assertDontSee('text-red-600', false);
    }

    #[Test]
    public function input_component_shows_error_when_show_errors_is_true(): void
    {
        $this->shareErrors(['email' => 'Email is required']);

        $view = $this->blade('<x-form-input name="email" show-error />');

        $view->assertSee('Email is required', false)
            ->assertSee('text-red-600', false);
    }

    #[Test]
    public function input_component_does_not_show_error_when_field_has_no_errors(): void
    {
        $this->shareErrors(['name' => 'Name is required']);

        $view = $this->blade('<x-form-input name="email" show-error />');

        $view->assertDontSee('text-red-600', false);
    }

    #[Test]
    public function input_component_strips_array_notation_for_error_lookup(): void
    {
        $this->shareErrors(['tags' => 'Tags are required']);

        $view = $this->blade('<x-form-input name="tags[]" show-error />');

        $view->assertSee('Tags are required', false);
    }
}
