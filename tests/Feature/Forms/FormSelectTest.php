<?php

declare(strict_types=1);

namespace Tests\Feature\Forms;

use PHPUnit\Framework\Attributes\Test;
use Tests\Concerns\InteractsWithErrors;
use Tests\TestCase;

class FormSelectTest extends TestCase
{
    use InteractsWithErrors;

    #[Test]
    public function select_component_renders_with_required_name()
    {
        $view = $this->blade('<x-form-select name="country"></x-form-select>');

        $view->assertSee('<select', false)
            ->assertSee('name="country"', false);
    }

    #[Test]
    public function select_component_renders_options()
    {
        $view = $this->blade(
            '<x-form-select name="country" :options="$options" />',
            [
                'options' => [
                    'gb' => 'United Kingdom',
                    'us' => 'United States',
                ]
            ]
        );

        $view->assertSee('<option value="gb">United Kingdom</option>', false);
        $view->assertSee('<option value="us">United States</option>', false);
    }

    #[Test]
    public function select_component_renders_required_with_aria()
    {
        $view = $this->blade('<x-form-select name="country" required></x-form-select>');

        $view->assertSee('required', false)
            ->assertSee('aria-required="true"', false);
    }

    #[Test]
    public function select_component_renders_disabled_with_aria()
    {
        $view = $this->blade('<x-form-select name="country" disabled></x-form-select>');

        $view->assertSee('disabled', false)
            ->assertSee('aria-disabled="true"', false);
    }

    #[Test]
    public function select_component_generates_id()
    {
        $view = $this->blade('<x-form-select name="country"></x-form-select>');

        $view->assertSee('id="', false);
    }

    #[Test]
    public function select_component_renders_label()
    {
        $view = $this->blade('<x-form-select name="country" label="Country"></x-form-select>');

        $view->assertSee('Country', false)
            ->assertSee('<label', false);
    }

    #[Test]
    public function select_component_label_for_matches_select_id()
    {
        $view = $this->blade('<x-form-select name="country" label="Country" id="country-select"></x-form-select>');

        $view->assertSee('id="country-select"', false)
            ->assertSee('for="country-select"', false);
    }

    #[Test]
    public function select_component_renders_readonly()
    {
        $view = $this->blade('<x-form-select name="country" readonly></x-form-select>');

        $view->assertSee('tabindex="-1"', false)
            ->assertSee('aria-readonly="true"', false)
            ->assertSee('pointer-events-none', false);
    }

    #[Test]
    public function select_component_renders_multiple()
    {
        $view = $this->blade('<x-form-select name="countries" multiple></x-form-select>');

        $view->assertSee('multiple', false)
            ->assertSee('name="countries[]"', false);
    }

    #[Test]
    public function select_component_marks_option_as_selected_when_selected_string_matches()
    {
        $view = $this->blade(
            '<x-form-select name="country" :options="$options" :selected="$selected" />',
            [
                'options' => [
                    'gb' => 'United Kingdom',
                    'us' => 'United States',
                ],
                'selected' => 'gb',
            ]
        );

        $view->assertSee('<option value="gb" selected>United Kingdom</option>', false);
        $view->assertSee('<option value="us">United States</option>', false);
    }

    #[Test]
    public function select_component_marks_option_as_selected_when_selected_array_matches()
    {
        $view = $this->blade(
            '<x-form-select name="country" :options="$options" :selected="$selected" />',
            [
                'options' => [
                    'gb' => 'United Kingdom',
                    'us' => 'United States',
                ],
                'selected' => ['gb'],
            ]
        );

        $view->assertSee('<option value="gb" selected>United Kingdom</option>', false);
        $view->assertSee('<option value="us">United States</option>', false);
    }

    #[Test]
    public function select_component_marks_multiple_option_as_selected_when_selected_array_matches()
    {
        $view = $this->blade(
            '<x-form-select name="country" :options="$options" :selected="$selected" />',
            [
                'options' => [
                    'de' => 'Germany',
                    'gb' => 'United Kingdom',
                    'us' => 'United States',
                ],
                'selected' => ['gb', 'us'],
            ]
        );

        $view->assertSee('<option value="gb" selected>United Kingdom</option>', false);
        $view->assertSee('<option value="us" selected>United States</option>', false);
        $view->assertSee('<option value="de">Germany</option>', false);
    }

    #[Test]
    public function select_component_does_not_show_error_by_default(): void
    {
        $this->shareErrors(['country' => 'Country is required']);

        $view = $this->blade('<x-form-select name="country"></x-form-select>');

        $view->assertDontSee('text-red-600', false);
    }

    #[Test]
    public function select_component_shows_error_when_show_errors_is_true(): void
    {
        $this->shareErrors(['country' => 'Country is required']);

        $view = $this->blade('<x-form-select name="country" show-error></x-form-select>');

        $view->assertSee('Country is required', false)
            ->assertSee('text-red-600', false);
    }

    #[Test]
    public function select_component_does_not_show_error_when_field_has_no_errors(): void
    {
        $this->shareErrors(['name' => 'Name is required']);

        $view = $this->blade('<x-form-select name="country" show-error></x-form-select>');

        $view->assertDontSee('text-red-600', false);
    }
}
