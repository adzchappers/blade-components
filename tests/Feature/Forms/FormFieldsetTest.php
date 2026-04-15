<?php

declare(strict_types=1);

namespace Tests\Feature\Forms;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FormFieldsetTest extends TestCase
{
    #[Test]
    public function fieldset_component_renders(): void
    {
        $view = $this->blade('<x-form-fieldset>Content</x-form-fieldset>');

        $view->assertSee('<fieldset', false)
            ->assertSee('Content', false);
    }

    #[Test]
    public function fieldset_component_renders_legend(): void
    {
        $view = $this->blade('<x-form-fieldset legend="Legend Title">Content</x-form-fieldset>');

        $view->assertSee('<legend', false)
            ->assertSee('Legend Title', false)
            ->assertSee('Content', false);
    }

    #[Test]
    public function fieldset_component_omits_legend_when_not_provided(): void
    {
        $view = $this->blade('<x-form-fieldset>Content</x-form-fieldset>');

        $view->assertSee('<fieldset', false)
            ->assertSee('Content', false)
            ->assertDontSee('<legend', false);
    }

    #[Test]
    public function fieldset_component_renders_disabled_state(): void
    {
        $view = $this->blade('<x-form-fieldset :disabled="true">Content</x-form-fieldset>');

        $view->assertSee('<fieldset', false)
            ->assertSee('disabled', false)
            ->assertSee('aria-disabled="true"', false);
    }

    #[Test]
    public function fieldset_component_is_not_disabled_by_default(): void
    {
        $view = $this->blade('<x-form-fieldset>Content</x-form-fieldset>');

        $view->assertDontSee('aria-disabled', false);
    }

    #[Test]
    public function fieldset_component_passes_through_extra_attributes(): void
    {
        $view = $this->blade('<x-form-fieldset class="custom-class">Content</x-form-fieldset>');

        $view->assertSee('custom-class', false);
    }

    #[Test]
    public function fieldset_component_renders_slot_content_as_raw_html(): void
    {
        $view = $this->blade('<x-form-fieldset><input type="text" name="test" /></x-form-fieldset>');

        $view->assertSee('<input type="text" name="test" />', false);
    }
}
