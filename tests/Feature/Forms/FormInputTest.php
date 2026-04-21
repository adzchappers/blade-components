<?php

declare(strict_types=1);

namespace Tests\Feature\Forms;

use PHPUnit\Framework\Attributes\Test;
use Tests\Concerns\InteractsWithErrors;
use Tests\Concerns\InteractsWithFlashedData;
use Tests\TestCase;

class FormInputTest extends TestCase
{
    use InteractsWithErrors;
    use InteractsWithFlashedData;

    #[Test]
    public function renders_hidden_and_only_hidden()
    {
        $view = $this->blade('<x-form-input type="hidden" name="email" />');

        $view->assertSeeHtmlInOrder(['<input', 'type="hidden"', 'name="email"']);
        $view->assertDontSeeHtml(['div', 'label']);
    }

    #[Test]
    public function renders_with_required_name()
    {
        $view = $this->blade('<x-form-input name="email" />');

        $view->assertSeeHtmlInOrder(['<input', 'type="text"', 'name="email"']);
    }

    #[Test]
    public function renders_with_custom_type()
    {
        $view = $this->blade('<x-form-input name="email" type="email" />');

        $view->assertSeeHtmlInOrder(['<input', 'type="email"', 'name="email"']);
        $view->assertDontSeeHtml('type="text"');
    }

    #[Test]
    public function renders_with_placeholder()
    {
        $view = $this->blade('<x-form-input name="email" placeholder="Enter email" />');

        $view->assertSeeHtmlInOrder(['placeholder="Enter email"']);
    }

    #[Test]
    public function renders_with_value()
    {
        $view = $this->blade('<x-form-input name="email" value="test@example.com" />');

        $view->assertSeeHtmlInOrder(['value="test@example.com"']);
    }

    #[Test]
    public function input_component_renders_required_with_aria()
    {
        $view = $this->blade('<x-form-input name="email" required />');

        $view->assertSeeHtmlInOrder(['required aria-required="true"']);
    }

    #[Test]
    public function renders_disabled_with_aria()
    {
        $view = $this->blade('<x-form-input name="email" disabled />');

        $view->assertSeeHtmlInOrder(['disabled aria-disabled="true"']);
    }

    #[Test]
    public function renders_readonly_with_aria()
    {
        $view = $this->blade('<x-form-input name="email" readonly />');

        $view->assertSeeHtmlInOrder(['readonly aria-readonly="true"']);
    }

    #[Test]
    public function renders_with_generated_id()
    {
        $view = $this->blade('<x-form-input name="email" />');

        $view->assertSeeHtmlInOrder(['<input', 'id="', 'type="text"']);
    }

    #[Test]
    public function renders_label()
    {
        $view = $this->blade('<x-form-input name="email" label="Email address" />');

        $view->assertSeeHtmlInOrder(['<label', 'Email address', '</label>', '<input', 'id="', 'type="text"']);
    }

    #[Test]
    public function renders_label_for_matches_input_id()
    {
        $view = $this->blade('<x-form-input name="email" label="Email address" id="email-field" />');

        $view->assertSeeHtmlInOrder([
            '<label',
            'for="email-field"',
            'Email address',
            '</label>',
            '<input',
            'id="email-field"',
            'type="text"',
        ]);
    }

    #[Test]
    public function does_not_render_label_when_not_provided()
    {
        $view = $this->blade('<x-form-input name="email" />');

        $view->assertDontSeeHtml('<label');
    }

    #[Test]
    public function does_not_show_error_by_default(): void
    {
        $this->shareErrors(['email' => 'Email is required']);

        $view = $this->blade('<x-form-input name="email" />');

        $view->assertDontSeeHtml(['text-red-600', 'Email is required']);
    }

    #[Test]
    public function shows_error_when_show_errors_is_true(): void
    {
        $this->shareErrors(['email' => 'Email is required']);

        $view = $this->blade('<x-form-input name="email" show-error />');

        $view->assertSeeHtmlInOrder(['text-red-600', 'Email is required']);
    }

    #[Test]
    public function does_not_show_error_when_field_has_no_errors(): void
    {
        $this->shareErrors(['name' => 'Name is required']);

        $view = $this->blade('<x-form-input name="email" show-error />');

        $view->assertDontSeeHtml(['text-red-600', 'Name is required']);
    }

    #[Test]
    public function strips_array_notation_for_error_lookup(): void
    {
        $this->shareErrors(['tags' => 'Tags are required']);

        $view = $this->blade('<x-form-input name="tags[]" show-error />');

        $view->assertSeeHtmlInOrder(['Tags are required']);
    }

    #[Test]
    public function submitted_data_changes_default_value()
    {
        $this->flashFormData(['email' => 'this-is-a-different-value']);

        $view = $this->blade('<x-form-input name="email" value="test@example.com" />');

        $view->assertSeeHtmlInOrder(['value="this-is-a-different-value"']);
        $view->assertDontSeeHtml(['value="test@example.com"']);
    }
}
