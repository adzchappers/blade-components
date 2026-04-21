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
    public function renders_with_name_and_value()
    {
        $view = $this->blade('<x-form-checkbox name="agree" value="1" />');

        $view->assertSeeHtmlInOrder(['type="checkbox"', 'name="agree"', 'value="1"']);
    }

    #[Test]
    public function renders_checked_when_checked_is_true()
    {
        $view = $this->blade('<x-form-checkbox name="agree" :checked="true" />');

        $view->assertSeeHtmlInOrder(['type="checkbox"', 'name="agree"', 'value="1"', 'checked']);
    }

    #[Test]
    public function renders_unchecked_when_default_was_checked_but_submitted_unchecked()
    {
        // Set a different key/value for a fake form submission
        // This is so that we can fake the request old data
        $this->flashFormData(['different-value' => '1']);

        $view = $this->blade('<x-form-checkbox name="agree" :checked="true" />');

        $view->assertDontSeeHtml('checked');
    }

    #[Test]
    public function renders_without_checked_if_not_checked()
    {
        $view = $this->blade('<x-form-checkbox name="agree" :checked="false" />');

        $view->assertSeeHtmlInOrder(['type="checkbox"', 'name="agree"', 'value="1"']);

        $view->assertDontSeeHtml('checked');
    }

    #[Test]
    public function renders_required_with_aria()
    {
        $view = $this->blade('<x-form-checkbox name="agree" required />');

        $view->assertSeeHtmlInOrder(['required', 'aria-required="true"']);
    }

    #[Test]
    public function renders_readonly_with_aria()
    {
        $view = $this->blade('<x-form-checkbox name="agree" readonly />');

        $view->assertSeeHtmlInOrder(['tabindex="-1"', 'aria-readonly="true"', 'pointer-events-none']);
    }

    #[Test]
    public function renders_with_label()
    {
        $view = $this->blade('<x-form-checkbox name="agree" label="I agree to the terms" />');

        $view->assertSeeHtmlInOrder([
            'type="checkbox"',
            'name="agree"',
            'value="1"',
            '<label',
            'I agree to the terms',
            '</label>',
        ]);
    }

    #[Test]
    public function renders_with_label_matching_id()
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
    public function renders_with_generated_id_when_not_provided()
    {
        $view = $this->blade('<x-form-checkbox name="agree" label="Agree" />');

        $view->assertSeeHtmlInOrder(['id="', '<label', 'for="', 'Agree', '</label>']);
    }

    #[Test]
    public function renders_without_label_when_not_provided()
    {
        $view = $this->blade('<x-form-checkbox name="agree" />');

        $view->assertDontSeeHtml('<label');
    }

    #[Test]
    public function renders_without_error_by_default(): void
    {
        $this->shareErrors(['agree' => 'You must agree']);

        $view = $this->blade('<x-form-checkbox name="agree" />');

        $view->assertDontSeeHtml('text-red-600');
    }

    #[Test]
    public function renders_with_error_when_show_errors_is_true(): void
    {
        $this->shareErrors(['agree' => 'You must agree']);

        $view = $this->blade('<x-form-checkbox name="agree" show-error />');

        $view->assertSeeHtmlInOrder(['text-red-600', 'You must agree']);
    }

    #[Test]
    public function renders_without_error_when_field_has_no_errors(): void
    {
        $this->shareErrors(['name' => 'Name is required']);

        $view = $this->blade('<x-form-checkbox name="agree" show-error />');

        $view->assertDontSeeHtml('text-red-600');
    }
}
