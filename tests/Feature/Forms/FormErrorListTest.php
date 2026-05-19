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
    public function it_will_not_show_if_no_errors(): void
    {
        $this->shareErrors();

        $view = $this->blade('<x-form-error-list />');

        $view->assertDontSee(['<div', '<ul'], false);
    }

    #[Test]
    public function it_shows_errors_from_default_bag(): void
    {
        $this->shareErrors(['email' => 'Email is required', 'name' => 'Name is required']);

        $view = $this->blade('<x-form-error-list />');

        $view->assertSeeInOrder([
            '<div',
            'role="alert"',
            '<ul',
            '<li>Email is required</li>',
            '<li>Name is required</li>',
            '</ul>',
        ], false);
    }

    #[Test]
    public function it_shows_errors_from_named_bag(): void
    {
        $this->shareErrors(['email' => 'Email is required'], 'login');

        $view = $this->blade('<x-form-error-list bag="login" />');

        $view->assertSeeInOrder(['<li>Email is required</li>'], false);
    }

    #[Test]
    public function it_will_not_show_errors_from_other_bags(): void
    {
        $this->shareErrors(['email' => 'Email is required']);

        $view = $this->blade('<x-form-error-list bag="login" />');

        $view->assertDontSee(['Email is required', '<ul'], false);
    }

    #[Test]
    public function it_will_merge_additional_variables(): void
    {
        $this->shareErrors(['email' => 'Email is required']);

        $view = $this->blade('<x-form-error-list class="custom-class" />');

        $view->assertSeeInOrder(['custom-class'], false);
    }
}
