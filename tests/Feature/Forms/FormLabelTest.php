<?php

declare(strict_types=1);

namespace Tests\Feature\Forms;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FormLabelTest extends TestCase
{
    #[Test]
    public function renders_with_for_attribute_and_slot_content()
    {
        $view = $this->blade('<x-form-label for="email">Email address</x-form-label>');

        $view->assertSeeHtmlInOrder(['<label', 'for="email"', 'Email address']);
    }

    #[Test]
    public function renders_with_additional_attributes()
    {
        $view = $this->blade('<x-form-label for="email" class="font-bold">Email</x-form-label>');

        $view->assertSeeHtmlInOrder(['font-bold']);
    }
}
