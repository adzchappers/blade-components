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
    public function it_shows_default_values(): void
    {
        $view = $this->blade('<x-form-input name="email" />');

        $view->assertSeeInOrder(['<input', 'type="text"', 'name="email"'], false);
    }

    #[Test]
    public function it_will_show_required_if_set(): void
    {
        $view = $this->blade('<x-form-input name="email" required />');

        $view->assertSeeInOrder(['required aria-required="true"'], false);
    }

    #[Test]
    public function it_will_show_disabled_if_set(): void
    {
        $view = $this->blade('<x-form-input name="email" disabled />');

        $view->assertSeeInOrder(['disabled aria-disabled="true"'], false);
    }

    #[Test]
    public function it_will_show_readonly_if_set(): void
    {
        $view = $this->blade('<x-form-input name="email" readonly />');

        $view->assertSeeInOrder(['readonly aria-readonly="true"'], false);
    }

    #[Test]
    public function it_will_generate_id(): void
    {
        $view = $this->blade('<x-form-input name="email" />');

        $view->assertSeeInOrder(['<input', 'id="', 'type="text"'], false);
    }

    #[Test]
    public function it_will_show_a_label(): void
    {
        $view = $this->blade('<x-form-input name="email" label="Email address" />');

        $view->assertSeeInOrder(['<label', 'Email address', '</label>', '<input', 'id="', 'type="text"'], false);
    }

    #[Test]
    public function it_will_have_the_same_id_as_label(): void
    {
        $view = $this->blade('<x-form-input name="email" label="Email address" id="email-field" />');

        $view->assertSeeInOrder([
            '<label',
            'for="email-field"',
            'Email address',
            '</label>',
            '<input',
            'id="email-field"',
            'type="text"',
        ], false);
    }

    #[Test]
    public function it_wont_show_label_if_not_set(): void
    {
        $view = $this->blade('<x-form-input name="email" />');

        $view->assertDontSee('<label', false);
    }

    #[Test]
    public function it_shows_errors_as_default(): void
    {
        $this->shareErrors(['email' => 'Email is required']);

        $view = $this->blade('<x-form-input name="email" />');

        $view->assertSeeInOrder(['text-red-600', 'Email is required'], false);
    }

    #[Test]
    public function it_will_not_show_errors_if_false(): void
    {
        $this->shareErrors(['email' => 'Email is required']);

        $view = $this->blade('<x-form-input name="email" :show-error="false" />');

        $view->assertDontSee(['text-red-600', 'Email is required'], false);
    }

    #[Test]
    public function it_doesnt_show_errors_if_input_has_none(): void
    {
        $this->shareErrors(['name' => 'Name is required']);

        $view = $this->blade('<x-form-input name="email" />');

        $view->assertDontSee(['text-red-600', 'Name is required'], false);
    }

    #[Test]
    public function it_will_convert_array_to_dot_notation_for_error(): void
    {
        $this->shareErrors(['tags' => 'Tags are required']);

        $view = $this->blade('<x-form-input name="tags[]" show-error />');

        $view->assertSeeInOrder(['Tags are required'], false);
    }

    #[Test]
    public function it_will_repopulate_value_from_old_input(): void
    {
        $this->flashFormData(['email' => 'this-is-a-different-value']);

        $view = $this->blade('<x-form-input name="email" value="test@example.com" />');

        $view->assertSeeInOrder(['value="this-is-a-different-value"'], false);
        $view->assertDontSee(['value="test@example.com"'], false);
    }

    #[Test]
    public function it_will_merge_additional_variables(): void
    {
        $view = $this->blade('<x-form-input name="email" class="custom-class" />');

        $view->assertSeeInOrder(['custom-class'], false);
    }

    #[Test]
    public function it_will_show_other_types(): void
    {
        $view = $this->blade('<x-form-input name="email" type="email" />');

        $view->assertSeeInOrder(['<input', 'type="email"', 'name="email"'], false);
        $view->assertDontSee('type="text"', false);
    }

    #[Test]
    public function it_will_show_placeholder(): void
    {
        $view = $this->blade('<x-form-input name="email" placeholder="Enter email" />');

        $view->assertSeeInOrder(['placeholder="Enter email"'], false);
    }

    #[Test]
    public function it_will_show_empty_string_placeholder(): void
    {
        $view = $this->blade('<x-form-input name="email" placeholder="" />');

        $view->assertSeeInOrder(['placeholder=""'], false);
    }

    #[Test]
    public function it_will_show_value(): void
    {
        $view = $this->blade('<x-form-input name="email" value="test@example.com" />');

        $view->assertSeeInOrder(['value="test@example.com"'], false);
    }

    #[Test]
    public function it_will_show_hidden_and_only_hidden(): void
    {
        $view = $this->blade('<x-form-input type="hidden" name="email" />');

        $view->assertSeeInOrder(['<input', 'type="hidden"', 'name="email"'], false);
        $view->assertDontSee(['div', 'label'], false);
    }

    #[Test]
    public function it_will_not_show_label_when_hidden(): void
    {
        $view = $this->blade('<x-form-input type="hidden" name="email" label="Email" />');

        $view->assertDontSee('<label', false);
    }

    #[Test]
    public function it_will_not_show_error_when_hidden(): void
    {
        $this->shareErrors(['email' => 'Email is required']);

        $view = $this->blade('<x-form-input type="hidden" name="email" />');

        $view->assertDontSee('text-red-600', false);
    }
}
