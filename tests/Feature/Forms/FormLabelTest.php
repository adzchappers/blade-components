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

        $view->assertSeeInOrder(['<label', 'for="email"', 'Email address'], false);
    }

    #[Test]
    public function it_shows_required_indicator_when_required_is_true(): void
    {
        $view = $this->blade('<x-form-label for="email" :required="true">Email</x-form-label>');

        $view->assertSeeInOrder(['Email', '<span class="text-red-500">*</span>'], false);
    }

    #[Test]
    public function it_does_not_show_required_indicator_by_default(): void
    {
        $view = $this->blade('<x-form-label for="email">Email</x-form-label>');

        $view->assertDontSee('<span class="text-red-500">', false);
    }

    #[Test]
    public function it_will_merge_additional_variables(): void
    {
        $view = $this->blade('<x-form-label for="email" class="font-bold">Email</x-form-label>');

        $view->assertSeeInOrder(['font-bold'], false);
    }
}
