<?php

declare(strict_types=1);

namespace Tests\Feature\Forms;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FormLabelTest extends TestCase
{
    #[Test]
    public function it_will_show_for_attribute_and_slot_contents(): void
    {
        $view = $this->blade('<x-form-label for="email">Email address</x-form-label>');

        $view->assertSeeHtmlInOrder(['<label', 'for="email"', 'Email address']);
    }

    #[Test]
    public function it_shows_required_indicator_when_required_is_true(): void
    {
        $view = $this->blade('<x-form-label for="email" :required="true">Email</x-form-label>');

        $view->assertSeeHtmlInOrder(['Email', '<span>*</span>']);
    }

    #[Test]
    public function it_does_not_show_required_indicator_by_default(): void
    {
        $view = $this->blade('<x-form-label for="email">Email</x-form-label>');

        $view->assertDontSeeHtml('<span>*</span>');
    }

    #[Test]
    public function it_will_merge_additional_variables(): void
    {
        $view = $this->blade('<x-form-label for="email" class="font-bold">Email</x-form-label>');

        $view->assertSeeHtmlInOrder(['font-bold']);
    }
}
