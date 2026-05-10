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
    public function it_will_show_hidden_and_only_hidden()
    {
        $view = $this->blade('<x-form-input type="hidden" name="email" />');

        $view->assertSeeHtmlInOrder(['<input', 'type="hidden"', 'name="email"']);
        $view->assertDontSeeHtml(['div', 'label']);
    }

    #[Test]
    public function it_will_show_with_required_name()
    {
        $view = $this->blade('<x-form-input name="email" />');

        $view->assertSeeHtmlInOrder(['<input', 'type="text"', 'name="email"']);
    }

    #[Test]
    public function it_will_show_other_types()
    {
        $view = $this->blade('<x-form-input name="email" type="email" />');

        $view->assertSeeHtmlInOrder(['<input', 'type="email"', 'name="email"']);
        $view->assertDontSeeHtml('type="text"');
    }

    #[Test]
    public function it_will_show_placeholder()
    {
        $view = $this->blade('<x-form-input name="email" placeholder="Enter email" />');

        $view->assertSeeHtmlInOrder(['placeholder="Enter email"']);
    }

    #[Test]
    public function it_will_show_value()
    {
        $view = $this->blade('<x-form-input name="email" value="test@example.com" />');

        $view->assertSeeHtmlInOrder(['value="test@example.com"']);
    }

    #[Test]
    public function it_will_show_required_if_set()
    {
        $view = $this->blade('<x-form-input name="email" required />');

        $view->assertSeeHtmlInOrder(['required aria-required="true"']);
    }

    #[Test]
    public function it_will_show_disabled_if_set()
    {
        $view = $this->blade('<x-form-input name="email" disabled />');

        $view->assertSeeHtmlInOrder(['disabled aria-disabled="true"']);
    }

    #[Test]
    public function it_will_show_readonly_if_set()
    {
        $view = $this->blade('<x-form-input name="email" readonly />');

        $view->assertSeeHtmlInOrder(['readonly aria-readonly="true"']);
    }

    #[Test]
    public function it_will_generate_id()
    {
        $view = $this->blade('<x-form-input name="email" />');

        $view->assertSeeHtmlInOrder(['<input', 'id="', 'type="text"']);
    }

    #[Test]
    public function it_will_show_a_label()
    {
        $view = $this->blade('<x-form-input name="email" label="Email address" />');

        $view->assertSeeHtmlInOrder(['<label', 'Email address', '</label>', '<input', 'id="', 'type="text"']);
    }

    #[Test]
    public function it_will_have_the_same_id_as_label()
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
    public function it_wont_show_label_if_not_set()
    {
        $view = $this->blade('<x-form-input name="email" />');

        $view->assertDontSeeHtml('<label');
    }

    #[Test]
    public function it_shows_errors_as_default(): void
    {
        $this->shareErrors(['email' => 'Email is required']);

        $view = $this->blade('<x-form-input name="email" />');

        $view->assertSeeHtmlInOrder(['text-red-600', 'Email is required']);
    }

    #[Test]
    public function it_will_not_show_errors_if_false(): void
    {
        $this->shareErrors(['email' => 'Email is required']);

        $view = $this->blade('<x-form-input name="email" :show-error="false" />');

        $view->assertDontSeeHtml(['text-red-600', 'Email is required']);
    }

    #[Test]
    public function it_doesnt_show_errors_if_input_has_none(): void
    {
        $this->shareErrors(['name' => 'Name is required']);

        $view = $this->blade('<x-form-input name="email" />');

        $view->assertDontSeeHtml(['text-red-600', 'Name is required']);
    }

    #[Test]
    public function it_will_convert_array_to_dot_notation_for_error(): void
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
