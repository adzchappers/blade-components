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
    public function renders_with_required_name()
    {
        $view = $this->blade('<x-form-select name="country"></x-form-select>');

        $view->assertSeeHtmlInOrder(['<select', 'name="country"']);
    }

    #[Test]
    public function renders_options()
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

        $view->assertSeeHtmlInOrder([
            '<option value="gb">United Kingdom</option>',
            '<option value="us">United States</option>',
        ]);
    }

    #[Test]
    public function renders_required_with_aria()
    {
        $view = $this->blade('<x-form-select name="country" required></x-form-select>');

        $view->assertSeeHtmlInOrder(['required', 'aria-required="true"']);
    }

    #[Test]
    public function renders_disabled_with_aria()
    {
        $view = $this->blade('<x-form-select name="country" disabled></x-form-select>');

        $view->assertSeeHtmlInOrder(['disabled', 'aria-disabled="true"']);
    }

    #[Test]
    public function renders_with_generated_id()
    {
        $view = $this->blade('<x-form-select name="country"></x-form-select>');

        $view->assertSeeHtmlInOrder(['id="']);
    }

    #[Test]
    public function renders_label()
    {
        $view = $this->blade('<x-form-select name="country" label="Country"></x-form-select>');

        $view->assertSeeHtmlInOrder(['<label', 'Country']);
    }

    #[Test]
    public function renders_label_for_matches_select_id()
    {
        $view = $this->blade('<x-form-select name="country" label="Country" id="country-select"></x-form-select>');

        $view->assertSeeHtmlInOrder(['for="country-select"', 'id="country-select"']);
    }

    #[Test]
    public function renders_readonly()
    {
        $view = $this->blade('<x-form-select name="country" readonly></x-form-select>');

        $view->assertSeeHtmlInOrder(['tabindex="-1"', 'aria-readonly="true"', 'pointer-events-none']);
    }

    #[Test]
    public function renders_multiple()
    {
        $view = $this->blade('<x-form-select name="countries" multiple></x-form-select>');

        $view->assertSeeHtmlInOrder(['name="countries[]"', 'multiple']);
    }

    #[Test]
    public function renders_with_option_as_selected_when_selected_string_matches()
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

        $view->assertSeeHtmlInOrder([
            '<option value="gb" selected>United Kingdom</option>',
            '<option value="us">United States</option>',
        ]);
    }

    #[Test]
    public function renders_with_option_as_selected_when_selected_array_matches()
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

        $view->assertSeeHtmlInOrder([
            '<option value="gb" selected>United Kingdom</option>',
            '<option value="us">United States</option>',
        ]);
    }

    #[Test]
    public function renders_with_multiple_option_as_selected_when_selected_array_matches()
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

        $view->assertSeeHtmlInOrder([
            '<option value="de">Germany</option>',
            '<option value="gb" selected>United Kingdom</option>',
            '<option value="us" selected>United States</option>',
        ]);
    }

    #[Test]
    public function does_not_show_error_by_default(): void
    {
        $this->shareErrors(['country' => 'Country is required']);

        $view = $this->blade('<x-form-select name="country"></x-form-select>');

        $view->assertDontSeeHtml('text-red-600');
    }

    #[Test]
    public function shows_error_when_show_errors_is_true(): void
    {
        $this->shareErrors(['country' => 'Country is required']);

        $view = $this->blade('<x-form-select name="country" show-error></x-form-select>');

        $view->assertSeeHtmlInOrder(['text-red-600', 'Country is required']);
    }

    #[Test]
    public function does_not_show_error_when_field_has_no_errors(): void
    {
        $this->shareErrors(['name' => 'Name is required']);

        $view = $this->blade('<x-form-select name="country" show-error></x-form-select>');

        $view->assertDontSeeHtml('text-red-600');
    }
}
