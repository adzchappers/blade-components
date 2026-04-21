<?php

declare(strict_types=1);

namespace Tests\Feature\Forms;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FormFieldsetTest extends TestCase
{
    #[Test]
    public function renders_without_legend(): void
    {
        $view = $this->blade('<x-form-fieldset>Content</x-form-fieldset>');

        $view->assertSeeHtmlInOrder(['<fieldset', 'Content', '</fieldset>']);

        $view->assertDontSeeHtml('<legend');
    }

    #[Test]
    public function renders_with_legend(): void
    {
        $view = $this->blade('<x-form-fieldset legend="Legend Title">Content</x-form-fieldset>');

        $view->assertSeeHtmlInOrder([
            '<fieldset',
            '<legend',
            'Legend Title',
            '</legend>',
            'Content',
            '</fieldset>'
        ]);
    }

    #[Test]
    public function renders_disabled_state(): void
    {
        $view = $this->blade('<x-form-fieldset :disabled="true">Content</x-form-fieldset>');

        $view->assertSeeHtmlInOrder(['disabled aria-disabled="true"']);
    }

    #[Test]
    public function does_not_render_disabled_by_default(): void
    {
        $view = $this->blade('<x-form-fieldset>Content</x-form-fieldset>');

        $view->assertDontSeeHtml('aria-disabled');
    }

    #[Test]
    public function renders_with_additional_attributes(): void
    {
        $view = $this->blade('<x-form-fieldset class="custom-class">Content</x-form-fieldset>');

        $view->assertSeeHtmlInOrder(['<fieldset', 'class="', 'custom-class', 'Content', '</fieldset>']);
    }

    #[Test]
    public function renders_slot_content_as_raw_html(): void
    {
        $view = $this->blade('<x-form-fieldset><input type="text" name="test" /></x-form-fieldset>');
        $view->assertSeeHtmlInOrder(['<fieldset', '<input type="text" name="test" />', '</fieldset>']);
    }
}
