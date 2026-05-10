<?php

declare(strict_types=1);

namespace Tests\Feature\Forms;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FormButtonTest extends TestCase
{
    #[Test]
    public function it_shows_default_values()
    {
        $view = $this->blade('<x-form-button></x-form-button>');

        $view->assertSeeHtmlInOrder(['<button', 'type="submit"', 'Submit', '</button>']);
    }

    #[Test]
    public function it_shows_type_button()
    {
        $view = $this->blade('<x-form-button type="button">Cancel</x-form-button>');

        $view->assertSeeHtmlInOrder(['<button', 'type="button"', 'Cancel', '</button>']);
    }

    #[Test]
    public function it_shows_type_reset()
    {
        $view = $this->blade('<x-form-button type="reset">Reset</x-form-button>');

        $view->assertSeeHtmlInOrder(['<button', 'type="reset"', 'Reset', '</button>']);
    }

    #[Test]
    public function it_will_fallback_to_type_submit()
    {
        $view = $this->blade('<x-form-button type="invalid">Save</x-form-button>');

        $view->assertSeeHtmlInOrder(['<button', 'type="submit"', 'Save', '</button>']);
    }

    #[Test]
    public function it_will_merge_additional_variables(): void
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
