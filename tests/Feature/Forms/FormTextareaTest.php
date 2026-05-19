<?php

declare(strict_types=1);

namespace Tests\Feature\Forms;

use PHPUnit\Framework\Attributes\Test;
use Tests\Concerns\InteractsWithErrors;
use Tests\Concerns\InteractsWithFlashedData;
use Tests\TestCase;

class FormTextareaTest extends TestCase
{
    use InteractsWithErrors;
    use InteractsWithFlashedData;

    #[Test]
    public function it_shows_default_values(): void
    {
        $view = $this->blade('<x-form-textarea name="description" value="Some text" />');

        $view->assertSeeInOrder([
            '<textarea',
            'name="description"',
            'Some text',
            '</textarea>',
        ], false);
    }

    #[Test]
    public function it_will_show_required_if_set(): void
    {
        $view = $this->blade('<x-form-textarea name="description" required />');

        $view->assertSeeInOrder(['required', 'aria-required="true"'], false);
    }

    #[Test]
    public function it_will_show_disabled_if_set(): void
    {
        $view = $this->blade('<x-form-textarea name="description" disabled />');

        $view->assertSeeInOrder(['disabled aria-disabled="true"'], false);
    }

    #[Test]
    public function it_will_show_readonly_if_set(): void
    {
        $view = $this->blade('<x-form-textarea name="description" readonly />');

        $view->assertSeeInOrder(['readonly', 'aria-readonly="true"'], false);
    }

    #[Test]
    public function it_will_show_placeholder(): void
    {
        $view = $this->blade('<x-form-textarea name="description" placeholder="Enter description" />');

        $view->assertSeeInOrder(['placeholder="Enter description"'], false);
    }

    #[Test]
    public function it_will_show_empty_string_placeholder(): void
    {
        $view = $this->blade('<x-form-textarea name="description" placeholder="" />');

        $view->assertSeeInOrder(['placeholder=""'], false);
    }

    #[Test]
    public function it_will_generate_id(): void
    {
        $view = $this->blade('<x-form-textarea name="description" />');

        $view->assertSeeInOrder(['<textarea', 'id="'], false);
    }

    #[Test]
    public function it_will_show_a_label(): void
    {
        $view = $this->blade('<x-form-textarea name="description" label="Description" />');

        $view->assertSeeInOrder([
            '<label',
            'Description',
            '</label>',
            '<textarea',
            '</textarea>',
        ], false);
    }

    #[Test]
    public function it_will_have_the_same_id_as_label(): void
    {
        $view = $this->blade('<x-form-textarea name="description" label="Description" id="desc" />');

        $view->assertSeeInOrder([
            '<label',
            'for="desc"',
            'Description',
            '</label>',
            '<textarea',
            'id="desc"',
            '</textarea>',
        ], false);
    }

    #[Test]
    public function it_wont_show_label_if_not_set(): void
    {
        $view = $this->blade('<x-form-textarea name="description" />');

        $view->assertDontSee('<label', false);
    }

    #[Test]
    public function it_shows_errors_as_default(): void
    {
        $this->shareErrors(['description' => 'Description is required']);

        $view = $this->blade('<x-form-textarea name="description" />');

        $view->assertSeeInOrder(['text-red-600', 'Description is required'], false);
    }

    #[Test]
    public function it_will_not_show_errors_if_false(): void
    {
        $this->shareErrors(['description' => 'Description is required']);

        $view = $this->blade('<x-form-textarea name="description" :show-error="false" />');

        $view->assertDontSee(['text-red-600', 'Description is required'], false);
    }

    #[Test]
    public function it_doesnt_show_errors_if_input_has_none(): void
    {
        $this->shareErrors(['name' => 'Name is required']);

        $view = $this->blade('<x-form-textarea name="description" show-error />');

        $view->assertDontSee(['text-red-600', 'Name is required'], false);
    }

    #[Test]
    public function it_will_convert_array_to_dot_notation_for_error(): void
    {
        $this->shareErrors(['tags' => 'Tags are required']);

        $view = $this->blade('<x-form-textarea name="tags[]" />');

        $view->assertSeeInOrder(['Tags are required'], false);
    }

    #[Test]
    public function it_will_repopulate_value_from_old_input(): void
    {
        $this->flashFormData(['description' => 'new value']);

        $view = $this->blade('<x-form-textarea name="description" value="old value" />');

        $view->assertSeeInOrder(['new value'], false);
        $view->assertDontSee('old value', false);
    }

    #[Test]
    public function it_will_merge_additional_variables(): void
    {
        $view = $this->blade('<x-form-textarea name="description" class="custom-class" />');

        $view->assertSeeInOrder(['custom-class'], false);
    }
}
