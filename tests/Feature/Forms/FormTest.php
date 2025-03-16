<?php

declare(strict_types=1);

namespace Tests\Feature\Forms;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FormTest extends TestCase
{
    #[Test]
    public function form_component_renders_with_default_values()
    {
        $view = $this->blade('<x-form>Test Content</x-form>');

        $view->assertSee('<form method="POST"', false)
            ->assertSee('Test Content', false);

        $view->assertSee('enctype="multipart/form-data"', false)
            ->assertSee('<input type="hidden" name@csrf', false)
            ->assertSee('<input type="hidden" name="_method" value="', false);
    }

    #[Test]
    public function form_component_renders_with_get_method()
    {
        $view = $this->blade('<x-form method="GET">Test Content</x-form>');

        $view->assertSee('<form method="GET"', false)
            ->assertDontSee('enctype="multipart/form-data"', false)
            ->assertSee('Test Content', false)
            ->assertDontSee('@csrf', false)
            ->assertDontSee('@method', false);
    }

    #[Test]
    public function form_component_renders_with_put_method_spoofing()
    {
        $view = $this->blade('<x-form method="PUT">Test Content</x-form>');

        $view->assertSee('<form method="POST"', false)
            ->assertSee('@csrf', false)
            ->assertSee('@method("PUT")', false)
            ->assertSee('Test Content', false);
    }

    #[Test]
    public function form_component_renders_with_patch_method_spoofing()
    {
        $view = $this->blade('<x-form method="PATCH">Test Content</x-form>');

        $view->assertSee('<form method="POST"', false)
            ->assertSee('@csrf', false)
            ->assertSee('@method("PATCH")', false)
            ->assertSee('Test Content', false);
    }

    #[Test]
    public function form_component_renders_with_delete_method_spoofing()
    {
        $view = $this->blade('<x-form method="DELETE">Test Content</x-form>');

        $view->assertSee('<form method="POST"', false)
            ->assertSee('@csrf', false)
            ->assertSee('@method("DELETE")', false)
            ->assertSee('Test Content', false);
    }

    #[Test]
    public function form_component_renders_with_file_upload()
    {
        $view = $this->blade('<x-form has-files="true">Test Content</x-form>');

        $view->assertSee('<form method="POST" enctype="multipart/form-data"', false)
            ->assertSee('Test Content', false);
    }
}
