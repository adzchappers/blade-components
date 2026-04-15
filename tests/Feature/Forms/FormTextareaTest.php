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
    public function textarea_component_renders_with_name()
    {
        $view = $this->blade('<x-form-textarea name="description" />');

        $view->assertSee('<textarea', false)
            ->assertSee('name="description"', false);
    }

    #[Test]
    public function textarea_component_renders_value()
    {
        $view = $this->blade('<x-form-textarea name="description" value="Some text" />');

        $view->assertSee('Some text', false);
    }

    #[Test]
    public function textarea_component_renders_required_with_aria()
    {
        $view = $this->blade('<x-form-textarea name="description" required />');

        $view->assertSee('required', false)
            ->assertSee('aria-required="true"', false);
    }

    #[Test]
    public function textarea_component_renders_readonly_with_aria()
    {
        $view = $this->blade('<x-form-textarea name="description" readonly />');

        $view->assertSee('readonly', false)
            ->assertSee('aria-readonly="true"', false);
    }

    #[Test]
    public function textarea_component_renders_label()
    {
        $view = $this->blade('<x-form-textarea name="description" label="Description" />');

        $view->assertSee('Description', false)
            ->assertSee('<label', false);
    }

    #[Test]
    public function textarea_component_label_for_matches_textarea_id()
    {
        $view = $this->blade('<x-form-textarea name="description" label="Description" id="desc" />');

        $view->assertSee('id="desc"', false)
            ->assertSee('for="desc"', false);
    }

    #[Test]
    public function textarea_component_does_not_render_label_when_not_provided()
    {
        $view = $this->blade('<x-form-textarea name="description" />');

        $view->assertDontSee('<label', false);
    }

    #[Test]
    public function textarea_component_does_not_show_error_by_default(): void
    {
        $this->shareErrors(['description' => 'Description is required']);

        $view = $this->blade('<x-form-textarea name="description" />');

        $view->assertDontSee('text-red-600', false);
    }

    #[Test]
    public function textarea_component_shows_error_when_show_errors_is_true(): void
    {
        $this->shareErrors(['description' => 'Description is required']);

        $view = $this->blade('<x-form-textarea name="description" show-error />');

        $view->assertSee('Description is required', false)
            ->assertSee('text-red-600', false);
    }

    #[Test]
    public function textarea_component_does_not_show_error_when_field_has_no_errors(): void
    {
        $this->shareErrors(['name' => 'Name is required']);

        $view = $this->blade('<x-form-textarea name="description" show-error />');

        $view->assertDontSee('text-red-600', false);
    }
}
