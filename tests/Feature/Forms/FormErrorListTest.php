<?php

declare(strict_types=1);

namespace Tests\Feature\Forms;

use PHPUnit\Framework\Attributes\Test;
use Tests\Concerns\InteractsWithErrors;
use Tests\TestCase;

class FormErrorListTest extends TestCase
{
    use InteractsWithErrors;

    #[Test]
    public function does_not_render_when_no_errors(): void
    {
        $this->shareErrors();

        $view = $this->blade('<x-form-error-list />');

        $view->assertDontSeeHtml(['<div', '<ul']);
    }

    #[Test]
    public function renders_all_errors_from_default_bag(): void
    {
        $this->shareErrors(['email' => 'Email is required', 'name' => 'Name is required']);

        $view = $this->blade('<x-form-error-list />');

        $view->assertSeeHtmlInOrder([
            '<div',
            'role="alert"',
            '<ul',
            '<li>Email is required</li>',
            '<li>Name is required</li>',
            '</ul>',
        ]);
    }

    #[Test]
    public function renders_errors_from_named_bag(): void
    {
        $this->shareErrors(['email' => 'Email is required'], 'login');

        $view = $this->blade('<x-form-error-list bag="login" />');

        $view->assertSeeHtmlInOrder(['<li>Email is required</li>']);
    }

    #[Test]
    public function does_not_render_errors_from_wrong_bag(): void
    {
        $this->shareErrors(['email' => 'Email is required']);

        $view = $this->blade('<x-form-error-list bag="login" />');

        $view->assertDontSeeHtml(['Email is required', '<ul']);
    }

    #[Test]
    public function renders_with_additional_attributes(): void
    {
        $this->shareErrors(['email' => 'Email is required']);

        $view = $this->blade('<x-form-error-list class="custom-class" />');

        $view->assertSeeHtmlInOrder(['custom-class']);
    }
}
