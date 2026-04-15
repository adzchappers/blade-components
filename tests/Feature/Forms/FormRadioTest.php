<?php

declare(strict_types=1);

namespace Tests\Feature\Forms;

use PHPUnit\Framework\Attributes\Test;
use Tests\Concerns\InteractsWithErrors;
use Tests\TestCase;

class FormRadioTest extends TestCase
{
    use InteractsWithErrors;

    // TODO: Write one to show two radios, and different selections etc
    #[Test]
    public function radio_component_renders_with_name_and_value()
    {
        $view = $this->blade('<x-form-radio name="colour" value="red" />');

        $view->assertSee('type="radio"', false)
            ->assertSee('name="colour"', false)
            ->assertSee('value="red"', false);
    }

    #[Test]
    public function radio_component_renders_checked_when_selected()
    {
        $view = $this->blade('<x-form-radio name="colour" value="red" :checked="true" />');

        $view->assertSee('checked', false);
    }

    #[Test]
    public function radio_component_does_not_render_checked_when_not_selected()
    {
        $view = $this->blade('<x-form-radio name="colour" value="red" :checked="false" />');

        $view->assertDontSee('checked', false);
    }

    #[Test]
    public function radio_component_renders_readonly_with_aria()
    {
        $view = $this->blade('<x-form-radio name="colour" value="red" readonly />');

        $view->assertSee('tabindex="-1"', false)
            ->assertSee('aria-readonly="true"', false)
            ->assertSee('pointer-events-none', false);
    }

    #[Test]
    public function radio_component_renders_label()
    {
        $view = $this->blade('<x-form-radio name="colour" value="red" label="Red" />');

        $view->assertSee('Red', false)
            ->assertSee('<label', false);
    }

    #[Test]
    public function radio_component_label_for_matches_input_id()
    {
        $view = $this->blade('<x-form-radio name="colour" value="red" label="Red" id="colour-red" />');

        $view->assertSee('id="colour-red"', false)
            ->assertSee('for="colour-red"', false);
    }

    #[Test]
    public function radio_component_does_not_render_label_when_not_provided()
    {
        $view = $this->blade('<x-form-radio name="colour" value="red" />');

        $view->assertDontSee('<label', false);
    }

    #[Test]
    public function radio_component_does_not_show_error_by_default(): void
    {
        $this->shareErrors(['colour' => 'Colour is required']);

        $view = $this->blade('<x-form-radio name="colour" value="red" />');

        $view->assertDontSee('text-red-600', false);
    }

    #[Test]
    public function radio_component_shows_error_when_show_errors_is_true(): void
    {
        $this->shareErrors(['colour' => 'Colour is required']);

        $view = $this->blade('<x-form-radio name="colour" value="red" show-error />');

        $view->assertSee('Colour is required', false)
            ->assertSee('text-red-600', false);
    }

    #[Test]
    public function radio_component_does_not_show_error_when_field_has_no_errors(): void
    {
        $this->shareErrors(['name' => 'Name is required']);

        $view = $this->blade('<x-form-radio name="colour" value="red" show-error />');

        $view->assertDontSee('text-red-600', false);
    }
}
