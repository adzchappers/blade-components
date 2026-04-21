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
    public function does_not_render_when_field_has_no_errors(): void
    {
        $this->shareErrors();

        $view = $this->blade('<x-form-error name="email" />');

        $view->assertDontSeeHtml('<p');
    }

    #[Test]
    public function renders_first_error_for_field(): void
    {
        $this->shareErrors(['email' => 'Email is required']);

        $view = $this->blade('<x-form-error name="email" />');

        $view->assertSeeHtmlInOrder(['<p', 'Email is required', '</p>']);
    }

    #[Test]
    public function does_not_render_when_different_field_has_errors(): void
    {
        $this->shareErrors(['name' => 'Name is required']);

        $view = $this->blade('<x-form-error name="email" />');

        $view->assertDontSeeHtml(['<p', 'Name is required', '</p>']);
    }

    #[Test]
    public function renders_from_named_bag(): void
    {
        $this->shareErrors(['email' => 'Email is required'], 'login');

        $view = $this->blade('<x-form-error name="email" bag="login" />');

        $view->assertSeeHtmlInOrder(['<p', 'Email is required', '</p>']);
    }

    #[Test]
    public function does_not_render_from_wrong_bag(): void
    {
        $this->shareErrors(['email' => 'Email is required']);

        $view = $this->blade('<x-form-error name="email" bag="login" />');

        $view->assertDontSeeHtml('<p');
    }

    #[Test]
    public function renders_with_stripped_array_notation_from_name(): void
    {
        $this->shareErrors(['permissions' => 'Permissions are required']);

        $view = $this->blade('<x-form-error name="permissions[]" />');

        $view->assertSeeHtmlInOrder(['<p', 'Permissions are required', '</p>']);
    }

    #[Test]
    public function renders_with_converted_array_notation_from_name(): void
    {
        $this->shareErrors(['permissions.edit' => 'Edit permission is required']);

        $view = $this->blade('<x-form-error name="permissions[edit]" />');

        $view->assertSeeHtmlInOrder(['<p', 'Edit permission is required', '</p>']);
    }

    #[Test]
    public function renders_with_additional_attributes(): void
    {
        $this->shareErrors(['email' => 'Email is required']);

        $view = $this->blade('<x-form-error name="email" class="custom-class" />');

        $view->assertSeeHtmlInOrder(['<p', 'class="', 'custom-class']);
    }
}
