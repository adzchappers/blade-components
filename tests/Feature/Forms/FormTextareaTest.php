<?php

declare(strict_types=1);

namespace Tests\Feature\Forms;

use PHPUnit\Framework\Attributes\Test;
use Tests\Concerns\InteractsWithErrors;
use Tests\Concerns\InteractsWithFlashedData;
use Tests\TestCase;

class FormTextareaTest extends TestCase
{
    use InteractsWithErrors;
    use InteractsWithFlashedData;

    #[Test]
    public function it_shows_default_values(): void
    {
        $view = $this->blade('<x-form-textarea name="description" value="Some text" />');

        $view->assertSeeHtmlInOrder([
            '<textarea',
            'name="description"',
            'Some text',
            '</textarea>',
        ]);
    }

    #[Test]
    public function it_will_show_required_if_set(): void
    {
        $view = $this->blade('<x-form-textarea name="description" required />');

        $view->assertSeeHtmlInOrder(['required', 'aria-required="true"']);
    }

    #[Test]
    public function it_will_show_disabled_if_set(): void
    {
        $view = $this->blade('<x-form-textarea name="description" disabled />');

        $view->assertSeeHtmlInOrder(['disabled aria-disabled="true"']);
    }

    #[Test]
    public function it_will_show_readonly_if_set(): void
    {
        $view = $this->blade('<x-form-textarea name="description" readonly />');

        $view->assertSeeHtmlInOrder(['readonly', 'aria-readonly="true"']);
    }

    #[Test]
    public function it_will_show_placeholder(): void
    {
        $view = $this->blade('<x-form-textarea name="description" placeholder="Enter description" />');

        $view->assertSeeHtmlInOrder(['placeholder="Enter description"']);
    }

    #[Test]
    public function it_will_generate_id(): void
    {
        $view = $this->blade('<x-form-textarea name="description" />');

        $view->assertSeeHtmlInOrder(['<textarea', 'id="']);
    }

    #[Test]
    public function it_will_show_a_label(): void
    {
        $view = $this->blade('<x-form-textarea name="description" label="Description" />');

        $view->assertSeeHtmlInOrder([
            '<label',
            'Description',
            '</label>',
            '<textarea',
            '</textarea>',
        ]);
    }

    #[Test]
    public function it_will_have_the_same_id_as_label(): void
    {
        $view = $this->blade('<x-form-textarea name="description" label="Description" id="desc" />');

        $view->assertSeeHtmlInOrder([
            '<label',
            'for="desc"',
            'Description',
            '</label>',
            '<textarea',
            'id="desc"',
            '</textarea>',
        ]);
    }

    #[Test]
    public function it_wont_show_label_if_not_set(): void
    {
        $view = $this->blade('<x-form-textarea name="description" />');

        $view->assertDontSeeHtml('<label');
    }

    #[Test]
    public function it_shows_errors_as_default(): void
    {
        $this->shareErrors(['description' => 'Description is required']);

        $view = $this->blade('<x-form-textarea name="description" />');

        $view->assertSeeHtmlInOrder(['text-red-600', 'Description is required']);
    }

    #[Test]
    public function it_will_not_show_errors_if_false(): void
    {
        $this->shareErrors(['description' => 'Description is required']);

        $view = $this->blade('<x-form-textarea name="description" :show-error="false" />');

        $view->assertDontSeeHtml(['text-red-600', 'Description is required']);
    }

    #[Test]
    public function it_doesnt_show_errors_if_input_has_none(): void
    {
        $this->shareErrors(['name' => 'Name is required']);

        $view = $this->blade('<x-form-textarea name="description" show-error />');

        $view->assertDontSeeHtml(['text-red-600', 'Name is required']);
    }

    #[Test]
    public function it_will_convert_array_to_dot_notation_for_error(): void
    {
        $this->shareErrors(['tags' => 'Tags are required']);

        $view = $this->blade('<x-form-textarea name="tags[]" />');

        $view->assertSeeHtmlInOrder(['Tags are required']);
    }

    #[Test]
    public function submitted_data_changes_default_value(): void
    {
        $this->flashFormData(['description' => 'new value']);

        $view = $this->blade('<x-form-textarea name="description" value="old value" />');

        $view->assertSeeHtmlInOrder(['new value']);
        $view->assertDontSeeHtml('old value');
    }
}
