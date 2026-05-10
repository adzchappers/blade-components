<?php

declare(strict_types=1);

namespace Tests\Feature\Forms;

use PHPUnit\Framework\Attributes\Test;
use Tests\Concerns\InteractsWithErrors;
use Tests\Concerns\InteractsWithFlashedData;
use Tests\TestCase;

class FormSelectTest extends TestCase
{
    use InteractsWithErrors;
    use InteractsWithFlashedData;

    #[Test]
    public function it_shows_default_values(): void
    {
        $view = $this->blade(
            '<x-form-select name="country" :options="$options" />',
            [
                'options' => [
                    'gb' => 'United Kingdom',
                    'us' => 'United States',
                ],
            ]
        );

        $view->assertSeeHtmlInOrder([
            '<select',
            'name="country"',
            '<option value="gb">United Kingdom</option>',
            '<option value="us">United States</option>',
            '</select>',
        ]);
    }

    #[Test]
    public function it_will_show_required_if_set(): void
    {
        $view = $this->blade('<x-form-select name="country" required></x-form-select>');

        $view->assertSeeHtmlInOrder(['required', 'aria-required="true"']);
    }

    #[Test]
    public function it_will_show_disabled_if_set(): void
    {
        $view = $this->blade('<x-form-select name="country" disabled></x-form-select>');

        $view->assertSeeHtmlInOrder(['disabled', 'aria-disabled="true"']);
    }

    #[Test]
    public function it_will_show_readonly_if_set(): void
    {
        $view = $this->blade('<x-form-select name="country" readonly></x-form-select>');

        $view->assertSeeHtmlInOrder(['tabindex="-1"', 'aria-readonly="true"', 'pointer-events-none']);
    }

    #[Test]
    public function it_will_generate_id(): void
    {
        $view = $this->blade('<x-form-select name="country"></x-form-select>');

        $view->assertSeeHtmlInOrder(['id="']);
    }

    #[Test]
    public function it_will_show_a_label(): void
    {
        $view = $this->blade('<x-form-select name="country" label="Country"></x-form-select>');

        $view->assertSeeHtmlInOrder([
            '<label',
            'Country',
            '</label>',
            '<select',
            'name="country"',
            '</select>',
        ]);
    }

    #[Test]
    public function it_will_have_the_same_id_as_label(): void
    {
        $view = $this->blade('<x-form-select name="country" label="Country" id="country-select"></x-form-select>');

        $view->assertSeeHtmlInOrder([
            '<label',
            'for="country-select"',
            'Country',
            '</label>',
            '<select',
            'id="country-select"',
            'name="country"',
            '</select>',
        ]);
    }

    #[Test]
    public function it_wont_show_label_if_not_set(): void
    {
        $view = $this->blade('<x-form-select name="country"></x-form-select>');

        $view->assertDontSeeHtml('<label');
    }

    #[Test]
    public function it_shows_errors_as_default(): void
    {
        $this->shareErrors(['country' => 'Country is required']);

        $view = $this->blade('<x-form-select name="country"></x-form-select>');

        $view->assertSeeHtmlInOrder(['text-red-600', 'Country is required']);
    }

    #[Test]
    public function it_will_not_show_errors_if_false(): void
    {
        $this->shareErrors(['country' => 'Country is required']);

        $view = $this->blade('<x-form-select name="country" :show-error="false"></x-form-select>');

        $view->assertDontSeeHtml(['text-red-600', 'Country is required']);
    }

    #[Test]
    public function it_doesnt_show_errors_if_input_has_none(): void
    {
        $this->shareErrors(['name' => 'Name is required']);

        $view = $this->blade('<x-form-select name="country" show-error></x-form-select>');

        $view->assertDontSeeHtml('text-red-600');
    }

    #[Test]
    public function it_will_convert_array_to_dot_notation_for_error(): void
    {
        $this->shareErrors(['countries' => 'Countries are required']);

        $view = $this->blade('<x-form-select name="countries[]"></x-form-select>');

        $view->assertSeeHtmlInOrder(['Countries are required']);
    }

    #[Test]
    public function submitted_data_changes_selected(): void
    {
        $this->flashFormData(['country' => 'us']);

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

        $view->assertSeeHtmlInOrder(['<option value="us" selected>United States</option>']);
        $view->assertDontSeeHtml('<option value="gb" selected>');
    }

    #[Test]
    public function it_will_show_multiple_if_set(): void
    {
        $view = $this->blade('<x-form-select name="countries" multiple></x-form-select>');

        $view->assertSeeHtmlInOrder(['name="countries[]"', 'multiple']);
    }

    #[Test]
    public function it_will_select_correct_option_when_set_as_string(): void
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
    public function it_will_select_correct_option_when_set_as_array(): void
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
    public function it_will_select_multiple_correct_options_when_set_as_array(): void
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
}
