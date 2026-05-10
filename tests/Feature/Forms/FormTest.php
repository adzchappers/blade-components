<?php

declare(strict_types=1);

namespace Tests\Feature\Forms;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FormTest extends TestCase
{
    #[Test]
    public function it_shows_default_values(): void
    {
        $view = $this->blade('<x-form>Test Content</x-form>');

        $view->assertSeeHtmlInOrder(['<form method="POST"', 'Test Content']);

        $view->assertDontSeeHtml([
            'enctype="multipart/form-data"',
            '<input type="hidden" name="_method" value="',
        ]);
    }

    #[Test]
    public function it_will_show_post_method(): void
    {
        $view = $this->blade('<x-form method="POST">Test Content</x-form>');

        $view->assertSeeHtmlInOrder(['<form method="POST"', 'Test Content']);

        $view->assertDontSeeHtml([
            'enctype="multipart/form-data"',
            '<input type="hidden" name="_method" value="',
        ]);
    }

    #[Test]
    public function it_will_show_get_method(): void
    {
        $view = $this->blade('<x-form method="GET">Test Content</x-form>');

        $view->assertSeeHtmlInOrder(['<form method="GET"', 'Test Content']);

        $view->assertDontSeeHtml([
            'enctype="multipart/form-data"',
            '<input type="hidden" name="_token" value="',
            '<input type="hidden" name="_method" value="',
        ]);
    }

    #[Test]
    public function it_will_normalise_method_to_uppercase(): void
    {
        $view = $this->blade('<x-form method="put">Test Content</x-form>');

        $view->assertSeeHtmlInOrder([
            '<form method="POST"',
            '<input type="hidden" name="_token" value="',
            '<input type="hidden" name="_method" value="PUT">',
            'Test Content',
        ]);
    }

    #[Test]
    public function it_will_show_put_method_spoofing(): void
    {
        $view = $this->blade('<x-form method="PUT">Test Content</x-form>');

        $view->assertSeeHtmlInOrder([
            '<form method="POST"',
            '<input type="hidden" name="_token" value="',
            '<input type="hidden" name="_method" value="PUT">',
            'Test Content',
        ]);
    }

    #[Test]
    public function it_will_show_patch_method_spoofing(): void
    {
        $view = $this->blade('<x-form method="PATCH">Test Content</x-form>');

        $view->assertSeeHtmlInOrder([
            '<form method="POST"',
            '<input type="hidden" name="_token" value="',
            '<input type="hidden" name="_method" value="PATCH">',
            'Test Content',
        ]);
    }

    #[Test]
    public function it_will_show_delete_method_spoofing(): void
    {
        $view = $this->blade('<x-form method="DELETE">Test Content</x-form>');

        $view->assertSeeHtmlInOrder([
            '<form method="POST"',
            '<input type="hidden" name="_token" value="',
            '<input type="hidden" name="_method" value="DELETE">',
            'Test Content',
        ]);
    }

    #[Test]
    public function it_will_show_file_upload(): void
    {
        $view = $this->blade('<x-form has-files="true">Test Content</x-form>');

        $view->assertSeeHtmlInOrder([
            '<form method="POST" enctype="multipart/form-data"',
            'Test Content',
        ]);
    }

    #[Test]
    public function it_will_show_file_upload_with_spoofed_method(): void
    {
        $view = $this->blade('<x-form method="PUT" has-files="true">Test Content</x-form>');

        $view->assertSeeHtmlInOrder([
            '<form method="POST" enctype="multipart/form-data"',
            '<input type="hidden" name="_token" value="',
            '<input type="hidden" name="_method" value="PUT">',
            'Test Content',
        ]);
    }

    #[Test]
    public function it_will_merge_additional_variables(): void
    {
        $view = $this->blade('<x-form class="custom-class">Test Content</x-form>');

        $view->assertSeeHtmlInOrder(['<form', 'custom-class', 'Test Content']);
    }
}
