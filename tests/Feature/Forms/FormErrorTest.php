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
    public function it_will_not_show_if_no_errors(): void
    {
        $this->shareErrors();

        $view = $this->blade('<x-form-error name="email" />');

        $view->assertDontSee('<p', false);
    }

    #[Test]
    public function it_will_show_first_error_for_a_field(): void
    {
        $this->shareErrors(['email' => 'Email is required']);

        $view = $this->blade('<x-form-error name="email" />');

        $view->assertSeeInOrder(['<p', 'Email is required', '</p>'], false);
    }

    #[Test]
    public function it_will_not_show_error_for_other_field(): void
    {
        $this->shareErrors(['name' => 'Name is required']);

        $view = $this->blade('<x-form-error name="email" />');

        $view->assertDontSee(['<p', 'Name is required', '</p>'], false);
    }

    #[Test]
    public function it_shows_errors_from_named_bag(): void
    {
        $this->shareErrors(['email' => 'Email is required'], 'login');

        $view = $this->blade('<x-form-error name="email" bag="login" />');

        $view->assertSeeInOrder(['<p', 'Email is required', '</p>'], false);
    }

    #[Test]
    public function it_will_not_show_errors_from_other_bags(): void
    {
        $this->shareErrors(['email' => 'Email is required']);

        $view = $this->blade('<x-form-error name="email" bag="login" />');

        $view->assertDontSee('<p', false);
    }

    #[Test]
    public function it_will_strip_array_notation_to_display_error(): void
    {
        $this->shareErrors(['permissions' => 'Permissions are required']);

        $view = $this->blade('<x-form-error name="permissions[]" />');

        $view->assertSeeInOrder(['<p', 'Permissions are required', '</p>'], false);
    }

    #[Test]
    public function it_will_convert_array_to_dot_notation_for_error(): void
    {
        $this->shareErrors(['permissions.edit' => 'Edit permission is required']);

        $view = $this->blade('<x-form-error name="permissions[edit]" />');

        $view->assertSeeInOrder(['<p', 'Edit permission is required', '</p>'], false);
    }

    #[Test]
    public function it_will_resolve_deep_dot_notation_for_error(): void
    {
        $this->shareErrors(['users.0.email' => 'Email is required']);

        $view = $this->blade('<x-form-error name="users[0][email]" />');

        $view->assertSeeInOrder(['<p', 'Email is required', '</p>'], false);
    }

    #[Test]
    public function it_will_merge_additional_variables(): void
    {
        $this->shareErrors(['email' => 'Email is required']);

        $view = $this->blade('<x-form-error name="email" class="custom-class" />');

        $view->assertSeeInOrder(['<p', 'class="', 'custom-class'], false);
    }
}
