<?php

declare(strict_types=1);

namespace Tests\Feature\Forms;

use PHPUnit\Framework\Attributes\Test;
use Tests\Concerns\InteractsWithErrors;
use Tests\TestCase;

class FormTextareaTest extends TestCase
{
    use InteractsWithErrors;

    #[Test]
    public function it_shows_default_values()
    {
        $view = $this->blade('<x-form-textarea name="description" value="Some text" />');

        $view->assertSeeHtmlInOrder([
            '<textarea',
            'name="description"',
            'Some text',
            '</textarea>'
        ]);
    }

    #[Test]
    public function it_will_show_required_if_set()
    {
        $view = $this->blade('<x-form-textarea name="description" required />');

        $view->assertSeeHtmlInOrder(['required', 'aria-required="true"']);
    }

    #[Test]
    public function it_will_show_readonly_if_set()
    {
        $view = $this->blade('<x-form-textarea name="description" readonly />');

        $view->assertSeeHtmlInOrder(['readonly', 'aria-readonly="true"']);
    }

    #[Test]
    public function it_will_show_a_label()
    {
        $view = $this->blade('<x-form-textarea name="description" label="Description" />');

        $view->assertSeeHtmlInOrder([
            '<label',
            'Description',
            '</label>',
            '<textarea',
            '</textarea>',
        ]);
    }

    #[Test]
    public function it_will_have_the_same_id_as_label()
    {
        $view = $this->blade('<x-form-textarea name="description" label="Description" id="desc" />');

        $view->assertSeeHtmlInOrder([
            '<label',
            'for="desc"',
            'Description',
            '</label>',
            '<textarea',
            'id="desc"',
            '</textarea>',
        ]);
    }

    #[Test]
    public function it_wont_show_label_if_not_set()
    {
        $view = $this->blade('<x-form-textarea name="description" />');

        $view->assertDontSeeHtml('<label');
    }

    #[Test]
    public function it_shows_errors_as_default(): void
    {
        $this->shareErrors(['description' => 'Description is required']);

        $view = $this->blade('<x-form-textarea name="description" />');

        $view->assertSeeHtmlInOrder(['text-red-600', 'Description is required']);
    }

    #[Test]
    public function it_will_not_show_errors_if_false(): void
    {
        $this->shareErrors(['description' => 'Description is required']);

        $view = $this->blade('<x-form-textarea name="description" :show-error="false" />');

        $view->assertDontSeeHtml(['text-red-600', 'Description is required']);
    }

    #[Test]
    public function it_doesnt_show_errors_if_input_has_none(): void
    {
        $this->shareErrors(['name' => 'Name is required']);

        $view = $this->blade('<x-form-textarea name="description" show-error />');

        $view->assertDontSeeHtml(['text-red-600', 'Name is required']);
    }
}
