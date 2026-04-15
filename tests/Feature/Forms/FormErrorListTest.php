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
    public function error_list_does_not_render_when_no_errors(): void
    {
        $this->shareErrors();

        $view = $this->blade('<x-form-error-list />');

        $view->assertDontSee('<div', false)
            ->assertDontSee('<ul', false);
    }

    #[Test]
    public function error_list_renders_all_errors_from_default_bag(): void
    {
        $this->shareErrors(['email' => 'Email is required', 'name' => 'Name is required']);

        $view = $this->blade('<x-form-error-list />');

        $view->assertSee('Email is required', false)
            ->assertSee('Name is required', false)
            ->assertSee('<ul', false)
            ->assertSee('<li>Email is required</li>', false)
            ->assertSee('<li>Name is required</li>', false)
            ->assertSee('role="alert"', false);
    }

    #[Test]
    public function error_list_renders_errors_from_named_bag(): void
    {
        $this->shareErrors(['email' => 'Email is required'], 'login');

        $view = $this->blade('<x-form-error-list bag="login" />');

        $view->assertSee('<li>Email is required</li>', false)
    }

    #[Test]
    public function error_list_does_not_render_errors_from_wrong_bag(): void
    {
        $this->shareErrors(['email' => 'Email is required']);

        $view = $this->blade('<x-form-error-list bag="login" />');

        $view->assertDontSee('Email is required', false)
            ->assertDontSee('<ul', false);
    }

    #[Test]
    public function error_list_passes_through_additional_attributes(): void
    {
        $this->shareErrors(['email' => 'Email is required']);

        $view = $this->blade('<x-form-error-list class="custom-class" />');

        $view->assertSee('custom-class', false);
    }
}
