<?php

declare(strict_types=1);

namespace Tests\Feature\Forms;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FormButtonTest extends TestCase
{
    #[Test]
    public function button_component_defaults_to_submit_type()
    {
        $view = $this->blade('<x-form-button>Save</x-form-button>');

        $view->assertSee('type="submit"', false)
            ->assertSee('Save', false);
    }

    #[Test]
    public function button_component_renders_button_type()
    {
        $view = $this->blade('<x-form-button type="button">Cancel</x-form-button>');

        $view->assertSee('type="button"', false);
    }

    #[Test]
    public function button_component_renders_reset_type()
    {
        $view = $this->blade('<x-form-button type="reset">Reset</x-form-button>');

        $view->assertSee('type="reset"', false);
    }

    #[Test]
    public function button_component_falls_back_to_submit_for_invalid_type()
    {
        $view = $this->blade('<x-form-button type="invalid">Save</x-form-button>');

        $view->assertSee('type="submit"', false);
    }

    #[Test]
    public function button_component_renders_slot_as_label()
    {
        $view = $this->blade('<x-form-button>Submit Form</x-form-button>');

        $view->assertSee('Submit Form', false);
    }
}
