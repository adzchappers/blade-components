<?php

declare(strict_types=1);

namespace Tests\Feature\Forms;

use PHPUnit\Framework\Attributes\Test;
use Tests\Concerns\InteractsWithErrors;
use Tests\TestCase;

class FormErrorTest extends TestCase
{
    use InteractsWithErrors;

    #[Test]
    public function error_does_not_render_when_field_has_no_errors(): void
    {
        $this->shareErrors();

        $view = $this->blade('<x-form-error name="email" />');

        $view->assertDontSee('<p', false);
    }

    #[Test]
    public function error_renders_first_error_for_field(): void
    {
        $this->shareErrors(['email' => 'Email is required']);

        $view = $this->blade('<x-form-error name="email" />');

        $view->assertSee('<p', false)
            ->assertSee('Email is required', false);
    }

    #[Test]
    public function error_does_not_render_when_different_field_has_errors(): void
    {
        $this->shareErrors(['name' => 'Name is required']);

        $view = $this->blade('<x-form-error name="email" />');

        $view->assertDontSee('<p', false)
            ->assertDontSee('Name is required', false);
    }

    #[Test]
    public function error_renders_from_named_bag(): void
    {
        $this->shareErrors(['email' => 'Email is required'], 'login');

        $view = $this->blade('<x-form-error name="email" bag="login" />');

        $view->assertSee('Email is required', false);
    }

    #[Test]
    public function error_does_not_render_from_wrong_bag(): void
    {
        $this->shareErrors(['email' => 'Email is required']);

        $view = $this->blade('<x-form-error name="email" bag="login" />');

        $view->assertDontSee('<p', false);
    }

    #[Test]
    public function error_strips_default_array_notation_from_name(): void
    {
        $this->shareErrors(['permissions' => 'Permissions are required']);

        $view = $this->blade('<x-form-error name="permissions[]" />');

        $view->assertSee('Permissions are required', false);
    }

    #[Test]
    public function error_converts_array_notation_from_name(): void
    {
        $this->shareErrors(['permissions.edit' => 'Edit permission is required']);

        $view = $this->blade('<x-form-error name="permissions[edit]" />');

        $view->assertSee('Edit permission is required', false);
    }

    #[Test]
    public function error_passes_through_additional_attributes(): void
    {
        $this->shareErrors(['email' => 'Email is required']);

        $view = $this->blade('<x-form-error name="email" class="custom-class" />');

        $view->assertSee('custom-class', false);
    }
}
