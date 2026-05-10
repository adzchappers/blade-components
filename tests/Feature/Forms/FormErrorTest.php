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

        $view->assertDontSeeHtml('<p');
    }

    #[Test]
    public function it_will_show_first_error_for_a_field(): void
    {
        $this->shareErrors(['email' => 'Email is required']);

        $view = $this->blade('<x-form-error name="email" />');

        $view->assertSeeHtmlInOrder(['<p', 'Email is required', '</p>']);
    }

    #[Test]
    public function it_will_not_show_error_for_other_field(): void
    {
        $this->shareErrors(['name' => 'Name is required']);

        $view = $this->blade('<x-form-error name="email" />');

        $view->assertDontSeeHtml(['<p', 'Name is required', '</p>']);
    }

    #[Test]
    public function it_shows_errors_from_named_bag(): void
    {
        $this->shareErrors(['email' => 'Email is required'], 'login');

        $view = $this->blade('<x-form-error name="email" bag="login" />');

        $view->assertSeeHtmlInOrder(['<p', 'Email is required', '</p>']);
    }

    #[Test]
    public function it_will_not_show_errors_from_other_bags(): void
    {
        $this->shareErrors(['email' => 'Email is required']);

        $view = $this->blade('<x-form-error name="email" bag="login" />');

        $view->assertDontSeeHtml('<p');
    }

    #[Test]
    public function it_will_strip_array_notatin_to_display_error(): void
    {
        $this->shareErrors(['permissions' => 'Permissions are required']);

        $view = $this->blade('<x-form-error name="permissions[]" />');

        $view->assertSeeHtmlInOrder(['<p', 'Permissions are required', '</p>']);
    }

    #[Test]
    public function it_will_convert_array_to_dot_notation_for_error(): void
    {
        $this->shareErrors(['permissions.edit' => 'Edit permission is required']);

        $view = $this->blade('<x-form-error name="permissions[edit]" />');

        $view->assertSeeHtmlInOrder(['<p', 'Edit permission is required', '</p>']);
    }

    #[Test]
    public function it_will_merge_additional_variables(): void
    {
        $this->shareErrors(['email' => 'Email is required']);

        $view = $this->blade('<x-form-error name="email" class="custom-class" />');

        $view->assertSeeHtmlInOrder(['<p', 'class="', 'custom-class']);
    }
}
