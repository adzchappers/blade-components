<?php

declare(strict_types=1);

namespace Tests\Feature\Forms;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FormButtonTest extends TestCase
{
    #[Test]
    public function renders_with_default_of_submit()
    {
        $view = $this->blade('<x-form-button></x-form-button>');

        $view->assertSeeHtmlInOrder(['<button', 'type="submit"', 'Submit', '</button>']);
    }

    #[Test]
    public function renders_type_button()
    {
        $view = $this->blade('<x-form-button type="button">Cancel</x-form-button>');

        $view->assertSeeHtmlInOrder(['<button', 'type="button"', 'Cancel', '</button>']);
    }

    #[Test]
    public function renders_type_reset()
    {
        $view = $this->blade('<x-form-button type="reset">Reset</x-form-button>');

        $view->assertSeeHtmlInOrder(['<button', 'type="reset"', 'Reset', '</button>']);
    }

    #[Test]
    public function renders_with_submit_fallback_for_invalid_type()
    {
        $view = $this->blade('<x-form-button type="invalid">Save</x-form-button>');

        $view->assertSeeHtmlInOrder(['<button', 'type="submit"', 'Save', '</button>']);
    }

    #[Test]
    public function renders_slot_as_content()
    {
        $view = $this->blade('<x-form-button>Submit Form</x-form-button>');

        $view->assertSeeHtmlInOrder(['<button', 'type="submit"', 'Submit', '</button>']);
    }

    #[Test]
    public function renders_with_additional_attributes(): void
    {
        $view = $this->blade('<x-form-button class="custom-class">Submit Form</x-form-button>');

        $view->assertSeeHtmlInOrder([
            '<button',
            'type="submit"',
            'class="',
            'custom-class',
            'Submit Form',
            '</button>',
        ]);
    }
}
