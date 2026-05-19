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

        $view->assertSeeInOrder([
            '<select',
            'name="country"',
            '<option value="gb">United Kingdom</option>',
            '<option value="us">United States</option>',
            '</select>',
        ], false);
    }

    #[Test]
    public function it_will_show_required_if_set(): void
    {
        $view = $this->blade('<x-form-select name="country" required></x-form-select>');

        $view->assertSeeInOrder(['required', 'aria-required="true"'], false);
    }

    #[Test]
    public function it_will_show_disabled_if_set(): void
    {
        $view = $this->blade('<x-form-select name="country" disabled></x-form-select>');

        $view->assertSeeInOrder(['disabled', 'aria-disabled="true"'], false);
    }

    #[Test]
    public function it_will_show_readonly_if_set(): void
    {
        $view = $this->blade('<x-form-select name="country" readonly></x-form-select>');

        $view->assertSeeInOrder(['tabindex="-1"', 'aria-readonly="true"', 'pointer-events-none'], false);
    }

    #[Test]
    public function it_will_generate_id(): void
    {
        $view = $this->blade('<x-form-select name="country"></x-form-select>');

        $view->assertSeeInOrder(['id="'], false);
    }

    #[Test]
    public function it_will_show_a_label(): void
    {
        $view = $this->blade('<x-form-select name="country" label="Country"></x-form-select>');

        $view->assertSeeInOrder([
            '<label',
            'Country',
            '</label>',
            '<select',
            'name="country"',
            '</select>',
        ], false);
    }

    #[Test]
    public function it_will_have_the_same_id_as_label(): void
    {
        $view = $this->blade('<x-form-select name="country" label="Country" id="country-select"></x-form-select>');

        $view->assertSeeInOrder([
            '<label',
            'for="country-select"',
            'Country',
            '</label>',
            '<select',
            'id="country-select"',
            'name="country"',
            '</select>',
        ], false);
    }

    #[Test]
    public function it_wont_show_label_if_not_set(): void
    {
        $view = $this->blade('<x-form-select name="country"></x-form-select>');

        $view->assertDontSee('<label', false);
    }

    #[Test]
    public function it_shows_errors_as_default(): void
    {
        $this->shareErrors(['country' => 'Country is required']);

        $view = $this->blade('<x-form-select name="country"></x-form-select>');

        $view->assertSeeInOrder(['text-red-600', 'Country is required'], false);
    }

    #[Test]
    public function it_will_not_show_errors_if_false(): void
    {
        $this->shareErrors(['country' => 'Country is required']);

        $view = $this->blade('<x-form-select name="country" :show-error="false"></x-form-select>');

        $view->assertDontSee(['text-red-600', 'Country is required'], false);
    }

    #[Test]
    public function it_doesnt_show_errors_if_input_has_none(): void
    {
        $this->shareErrors(['name' => 'Name is required']);

        $view = $this->blade('<x-form-select name="country" show-error></x-form-select>');

        $view->assertDontSee('text-red-600', false);
    }

    #[Test]
    public function it_will_convert_array_to_dot_notation_for_error(): void
    {
        $this->shareErrors(['countries' => 'Countries are required']);

        $view = $this->blade('<x-form-select name="countries[]"></x-form-select>');

        $view->assertSeeInOrder(['Countries are required'], false);
    }

    #[Test]
    public function it_will_repopulate_selected_from_old_input(): void
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

        $view->assertSeeInOrder(['<option value="us" selected>United States</option>'], false);
        $view->assertDontSee('<option value="gb" selected>', false);
    }

    #[Test]
    public function it_will_merge_additional_variables(): void
    {
        $view = $this->blade('<x-form-select name="country" class="custom-class"></x-form-select>');

        $view->assertSeeInOrder(['custom-class'], false);
    }

    #[Test]
    public function it_will_show_multiple_if_set(): void
    {
        $view = $this->blade('<x-form-select name="countries" multiple></x-form-select>');

        $view->assertSeeInOrder(['name="countries[]"', 'multiple'], false);
    }

    #[Test]
    public function it_will_select_no_options_when_selected_is_null(): void
    {
        $view = $this->blade(
            '<x-form-select name="country" :options="$options" :selected="null" />',
            [
                'options' => [
                    'gb' => 'United Kingdom',
                    'us' => 'United States',
                ],
            ]
        );

        $view->assertDontSee(['<option value="gb" selected>', '<option value="us" selected>'], false);
    }

    #[Test]
    public function it_will_handle_falsy_old_input(): void
    {
        $this->flashFormData(['country' => '0']);

        $view = $this->blade(
            '<x-form-select name="country" :options="$options" :selected="$selected" />',
            [
                'options' => [
                    '0' => 'Unknown',
                    'gb' => 'United Kingdom',
                ],
                'selected' => 'gb',
            ]
        );

        $view->assertSeeInOrder(['<option value="0" selected>Unknown</option>'], false);
        $view->assertDontSee('<option value="gb" selected>', false);
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

        $view->assertSeeInOrder([
            '<option value="gb" selected>United Kingdom</option>',
            '<option value="us">United States</option>',
        ], false);
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

        $view->assertSeeInOrder([
            '<option value="gb" selected>United Kingdom</option>',
            '<option value="us">United States</option>',
        ], false);
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

        $view->assertSeeInOrder([
            '<option value="de">Germany</option>',
            '<option value="gb" selected>United Kingdom</option>',
            '<option value="us" selected>United States</option>',
        ], false);
    }
}
