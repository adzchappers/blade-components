<?php

declare(strict_types=1);

namespace Tests\Feature\Forms;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FormFieldsetTest extends TestCase
{
    #[Test]
    public function it_does_not_show_legend_if_not_set(): void
    {
        $view = $this->blade('<x-form-fieldset>Content</x-form-fieldset>');

        $view->assertSeeInOrder(['<fieldset', 'Content', '</fieldset>'], false);

        $view->assertDontSee('<legend', false);
    }

    #[Test]
    public function it_will_show_legend_if_set(): void
    {
        $view = $this->blade('<x-form-fieldset legend="Legend Title">Content</x-form-fieldset>');

        $view->assertSeeInOrder([
            '<fieldset',
            '<legend',
            'Legend Title',
            '</legend>',
            'Content',
            '</fieldset>',
        ], false);
    }

    #[Test]
    public function it_will_show_disabled_if_set(): void
    {
        $view = $this->blade('<x-form-fieldset :disabled="true">Content</x-form-fieldset>');

        $view->assertSeeInOrder(['disabled aria-disabled="true"'], false);
    }

    #[Test]
    public function it_will_show_legend_and_disabled_combined(): void
    {
        $view = $this->blade('<x-form-fieldset legend="Legend Title" :disabled="true">Content</x-form-fieldset>');

        $view->assertSeeInOrder([
            '<fieldset',
            'disabled aria-disabled="true"',
            '<legend',
            'Legend Title',
            '</legend>',
            'Content',
            '</fieldset>',
        ], false);
    }

    #[Test]
    public function it_will_merge_additional_variables(): void
    {
        $view = $this->blade('<x-form-fieldset class="custom-class">Content</x-form-fieldset>');

        $view->assertSeeInOrder(['<fieldset', 'class="', 'custom-class', 'Content', '</fieldset>'], false);
    }

    #[Test]
    public function it_will_show_slot_content_as_raw_html(): void
    {
        $view = $this->blade('<x-form-fieldset><input type="text" name="test" /></x-form-fieldset>');
        $view->assertSeeInOrder(['<fieldset', '<input type="text" name="test" />', '</fieldset>'], false);
    }
}
