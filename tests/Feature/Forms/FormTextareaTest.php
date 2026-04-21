<?php

declare(strict_types=1);

namespace Tests\Feature\Forms;

use PHPUnit\Framework\Attributes\Test;
use Tests\Concerns\InteractsWithErrors;
use Tests\TestCase;

class FormTextareaTest extends TestCase
{
    use InteractsWithErrors;

    #[Test]
    public function renders_with_name()
    {
        $view = $this->blade('<x-form-textarea name="description" />');

        $view->assertSeeHtmlInOrder(['<textarea', 'name="description"']);
    }

    #[Test]
    public function _renders_value()
    {
        $view = $this->blade('<x-form-textarea name="description" value="Some text" />');

        $view->assertSeeHtmlInOrder(['Some text']);
    }

    #[Test]
    public function renders_required_with_aria()
    {
        $view = $this->blade('<x-form-textarea name="description" required />');

        $view->assertSeeHtmlInOrder(['required', 'aria-required="true"']);
    }

    #[Test]
    public function renders_readonly_with_aria()
    {
        $view = $this->blade('<x-form-textarea name="description" readonly />');

        $view->assertSeeHtmlInOrder(['readonly', 'aria-readonly="true"']);
    }

    #[Test]
    public function renders_label()
    {
        $view = $this->blade('<x-form-textarea name="description" label="Description" />');

        $view->assertSeeHtmlInOrder(['<label', 'Description']);
    }

    #[Test]
    public function renders_label_for_matches_textarea_id()
    {
        $view = $this->blade('<x-form-textarea name="description" label="Description" id="desc" />');

        $view->assertSeeHtmlInOrder(['for="desc"', 'id="desc"']);
    }

    #[Test]
    public function does_not_render_label_when_not_provided()
    {
        $view = $this->blade('<x-form-textarea name="description" />');

        $view->assertDontSeeHtml('<label');
    }

    #[Test]
    public function does_not_show_error_by_default(): void
    {
        $this->shareErrors(['description' => 'Description is required']);

        $view = $this->blade('<x-form-textarea name="description" />');

        $view->assertDontSeeHtml('text-red-600');
    }

    #[Test]
    public function renders_shows_error_when_show_errors_is_true(): void
    {
        $this->shareErrors(['description' => 'Description is required']);

        $view = $this->blade('<x-form-textarea name="description" show-error />');

        $view->assertSeeHtmlInOrder(['text-red-600', 'Description is required']);
    }

    #[Test]
    public function does_not_show_error_when_field_has_no_errors(): void
    {
        $this->shareErrors(['name' => 'Name is required']);

        $view = $this->blade('<x-form-textarea name="description" show-error />');

        $view->assertDontSeeHtml('text-red-600');
    }
}
