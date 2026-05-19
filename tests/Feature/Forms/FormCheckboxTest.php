<?php

declare(strict_types=1);

namespace Tests\Feature\Forms;

use PHPUnit\Framework\Attributes\Test;
use Tests\Concerns\InteractsWithErrors;
use Tests\Concerns\InteractsWithFlashedData;
use Tests\TestCase;

class FormCheckboxTest extends TestCase
{
    use InteractsWithErrors;
    use InteractsWithFlashedData;

    #[Test]
    public function it_shows_default_values(): void
    {
        $view = $this->blade('<x-form-checkbox name="agree" value="1" />');

        $view->assertSeeHtmlInOrder(['type="checkbox"', 'name="agree"', 'value="1"']);

        $view->assertDontSeeHtml(['checked ', '<label']);
    }

    #[Test]
    public function it_will_show_as_checked_when_checked_is_true(): void
    {
        $view = $this->blade('<x-form-checkbox name="agree" :checked="true" />');

        $view->assertSeeHtmlInOrder(['type="checkbox"', 'name="agree"', 'value="1"', 'checked ']);
    }

    #[Test]
    public function it_will_not_show_as_checked_if_checked_but_form_submission_unchecks(): void
    {
        // Set a different key/value for a fake form submission
        // This is so that we can fake the request old data
        $this->flashFormData(['different-value' => '1']);

        $view = $this->blade('<x-form-checkbox name="agree" :checked="true" />');

        $view->assertDontSeeHtml('checked ');
    }

    #[Test]
    public function it_will_show_required_if_set(): void
    {
        $view = $this->blade('<x-form-checkbox name="agree" required />');

        $view->assertSeeHtmlInOrder(['required', 'aria-required="true"']);
    }

    #[Test]
    public function it_will_show_disabled_if_set(): void
    {
        $view = $this->blade('<x-form-checkbox name="agree" disabled />');

        $view->assertSeeHtmlInOrder(['disabled', 'aria-disabled="true"']);
    }

    #[Test]
    public function it_will_show_readonly_if_set(): void
    {
        $view = $this->blade('<x-form-checkbox name="agree" readonly />');

        $view->assertSeeHtmlInOrder(['tabindex="-1"', 'aria-readonly="true"', 'pointer-events-none']);
    }

    #[Test]
    public function it_will_generate_id(): void
    {
        $view = $this->blade('<x-form-checkbox name="agree" />');

        $view->assertSeeHtmlInOrder(['<input', 'id="', 'type="checkbox"']);
    }

    #[Test]
    public function it_will_show_a_label(): void
    {
        $view = $this->blade('<x-form-checkbox name="agree" label="I agree to the terms" />');

        $view->assertSeeHtmlInOrder([
            'id="',
            'type="checkbox"',
            'name="agree"',
            'value="1"',
            '<label',
            'for="',
            'I agree to the terms',
            '</label>',
        ]);
    }

    #[Test]
    public function it_will_have_the_same_id_as_label(): void
    {
        $view = $this->blade('<x-form-checkbox name="agree" label="Agree" id="agree-checkbox" />');

        $view->assertSeeHtmlInOrder([
            'id="agree-checkbox"',
            'type="checkbox"',
            'name="agree"',
            'value="1"',
            '<label',
            'for="agree-checkbox"',
            'Agree',
            '</label>',
        ]);
    }

    #[Test]
    public function it_wont_show_label_if_not_set(): void
    {
        $view = $this->blade('<x-form-checkbox name="agree" />');

        $view->assertDontSeeHtml('<label');
    }

    #[Test]
    public function it_shows_errors_as_default(): void
    {
        $this->shareErrors(['agree' => 'You must agree']);

        $view = $this->blade('<x-form-checkbox name="agree" />');

        $view->assertSeeHtmlInOrder(['text-red-600', 'You must agree']);
    }

    #[Test]
    public function it_will_not_show_errors_if_false(): void
    {
        $this->shareErrors(['agree' => 'You must agree']);

        $view = $this->blade('<x-form-checkbox name="agree" :show-error="false" />');

        $view->assertDontSeeHtml('text-red-600');
    }

    #[Test]
    public function it_doesnt_show_errors_if_input_has_none(): void
    {
        $this->shareErrors(['name' => 'Name is required']);

        $view = $this->blade('<x-form-checkbox name="agree" />');

        $view->assertDontSeeHtml('text-red-600');
    }

    #[Test]
    public function it_will_convert_array_to_dot_notation_for_error(): void
    {
        $this->shareErrors(['permissions' => 'Permissions are required']);

        $view = $this->blade('<x-form-checkbox name="permissions[]" />');

        $view->assertSeeHtmlInOrder(['Permissions are required']);
    }

    #[Test]
    public function it_will_be_checked_from_old_input(): void
    {
        $this->flashFormData(['agree' => '1']);

        $view = $this->blade('<x-form-checkbox name="agree" value="1" />');

        $view->assertSeeHtmlInOrder(['checked ']);
    }

    #[Test]
    public function it_will_merge_additional_variables(): void
    {
        $view = $this->blade('<x-form-checkbox name="agree" class="custom-class" />');

        $view->assertSeeHtmlInOrder(['custom-class']);
    }
}
