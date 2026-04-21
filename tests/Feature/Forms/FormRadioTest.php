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
    public function renders_with_name_and_value()
    {
        $view = $this->blade('<x-form-radio name="colour" value="red" />');

        $view->assertSeeHtmlInOrder(['type="radio"', 'name="colour"', 'value="red"']);
    }

    #[Test]
    public function renders_checked_when_selected()
    {
        $view = $this->blade('<x-form-radio name="colour" value="red" :checked="true" />');

        $view->assertSeeHtmlInOrder(['checked']);
    }

    #[Test]
    public function does_not_render_checked_when_not_selected()
    {
        $view = $this->blade('<x-form-radio name="colour" value="red" :checked="false" />');

        $view->assertDontSeeHtml('checked');
    }

    #[Test]
    public function renders_readonly_with_aria()
    {
        $view = $this->blade('<x-form-radio name="colour" value="red" readonly />');

        $view->assertSeeHtmlInOrder(['tabindex="-1"', 'aria-readonly="true"', 'pointer-events-none']);
    }

    #[Test]
    public function renders_with_label()
    {
        $view = $this->blade('<x-form-radio name="colour" value="red" label="Red" />');

        $view->assertSeeHtmlInOrder(['<label', 'Red']);
    }

    #[Test]
    public function label_for_matches_input_id()
    {
        $view = $this->blade('<x-form-radio name="colour" value="red" label="Red" id="colour-red" />');

        $view->assertSeeHtmlInOrder(['id="colour-red"', 'for="colour-red"']);
    }

    #[Test]
    public function does_not_render_label_when_not_provided()
    {
        $view = $this->blade('<x-form-radio name="colour" value="red" />');

        $view->assertDontSeeHtml('<label');
    }

    #[Test]
    public function does_not_show_error_by_default(): void
    {
        $this->shareErrors(['colour' => 'Colour is required']);

        $view = $this->blade('<x-form-radio name="colour" value="red" />');

        $view->assertDontSeeHtml('text-red-600');
    }

    #[Test]
    public function shows_error_when_show_errors_is_true(): void
    {
        $this->shareErrors(['colour' => 'Colour is required']);

        $view = $this->blade('<x-form-radio name="colour" value="red" show-error />');

        $view->assertSeeHtmlInOrder(['text-red-600', 'Colour is required']);
    }

    #[Test]
    public function does_not_show_error_when_field_has_no_errors(): void
    {
        $this->shareErrors(['name' => 'Name is required']);

        $view = $this->blade('<x-form-radio name="colour" value="red" show-error />');

        $view->assertDontSeeHtml('text-red-600');
    }
}
