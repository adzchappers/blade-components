<?php

declare(strict_types=1);

namespace Tests\Feature\Forms;

use PHPUnit\Framework\Attributes\Test;
use Tests\Concerns\InteractsWithErrors;
use Tests\Concerns\InteractsWithFlashedData;
use Tests\TestCase;

class FormRadioTest extends TestCase
{
    use InteractsWithErrors;
    use InteractsWithFlashedData;

    #[Test]
    public function it_shows_default_values()
    {
        $view = $this->blade('<x-form-radio name="colour" value="red" />');

        $view->assertSeeHtmlInOrder(['type="radio"', 'name="colour"', 'value="red"']);
        $view->assertDontSeeHtml(['checked', '<label']);
    }

    #[Test]
    public function it_will_show_as_checked_when_checked_is_true()
    {
        $view = $this->blade('<x-form-radio name="colour" value="red" :checked="true" />');

        $view->assertSeeHtmlInOrder(['type="radio"', 'name="colour"', 'value="red"', 'checked']);
    }

    #[Test]
    public function it_will_not_show_as_checked_if_checked_but_form_submission_unchecks()
    {
        // Set a different key/value for a fake form submission
        // This is so that we can fake the request old data
        $this->flashFormData(['colour' => 'blue']);

        $view = $this->blade('<x-form-radio name="colour" value="red" :checked="true" />');

        $view->assertDontSeeHtml('checked');
    }

    #[Test]
    public function it_will_show_readonly_if_set()
    {
        $view = $this->blade('<x-form-radio name="colour" value="red" readonly />');

        $view->assertSeeHtmlInOrder(['tabindex="-1"', 'aria-readonly="true"', 'pointer-events-none']);
    }

    #[Test]
    public function it_will_show_a_label()
    {
        $view = $this->blade('<x-form-radio name="colour" value="red" label="Red" />');

        $view->assertSeeHtmlInOrder([
            'id="',
            'type="radio"',
            'name="colour"',
            'value="red"',
            '<label',
            'for="',
            'Red',
            '</label>',
        ]);
    }

    #[Test]
    public function it_will_have_the_same_id_as_label()
    {
        $view = $this->blade('<x-form-radio name="colour" value="red" label="Red" id="colour-red" />');

        $view->assertSeeHtmlInOrder([
            'id="colour-red"',
            'type="radio"',
            'name="colour"',
            'value="red"',
            '<label',
            'for="colour-red"',
            'Red',
            '</label>',
        ]);
    }

    #[Test]
    public function it_wont_show_label_if_not_set()
    {
        $view = $this->blade('<x-form-radio name="colour" value="red" />');

        $view->assertDontSeeHtml('<label');
    }

    #[Test]
    public function it_shows_errors_as_default(): void
    {
        $this->shareErrors(['colour' => 'Colour is required']);

        $view = $this->blade('<x-form-radio name="colour" value="red" />');

        $view->assertSeeHtmlInOrder(['text-red-600', 'Colour is required']);
    }

    #[Test]
    public function it_will_not_show_errors_if_false(): void
    {
        $this->shareErrors(['colour' => 'Colour is required']);

        $view = $this->blade('<x-form-radio name="colour" value="red" :show-error="false" />');

        $view->assertDontSeeHtml('text-red-600');
    }

    #[Test]
    public function it_doesnt_show_errors_if_input_has_none(): void
    {
        $this->shareErrors(['name' => 'Name is required']);

        $view = $this->blade('<x-form-radio name="colour" value="red" />');

        $view->assertDontSeeHtml('text-red-600');
    }
}
