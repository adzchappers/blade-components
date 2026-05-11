# Blade Components

[![Latest Version on Packagist](https://img.shields.io/packagist/v/adzchappers/blade-components.svg?style=flat-square)](https://packagist.org/packages/adzchappers/blade-components)
[![Tests](https://github.com/adzchappers/blade-components/actions/workflows/tests.yml/badge.svg?branch=main)](https://github.com/adzchappers/blade-components/actions/workflows/tests.yml)
[![Pint](https://github.com/adzchappers/blade-components/actions/workflows/pint.yml/badge.svg?branch=main)](https://github.com/adzchappers/blade-components/actions/workflows/pint.yml)
[![Static Analysis](https://github.com/adzchappers/blade-components/actions/workflows/static-analysis.yml/badge.svg?branch=main)](https://github.com/adzchappers/blade-components/actions/workflows/static-analysis.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/adzchappers/blade-components.svg?style=flat-square)](https://packagist.org/packages/adzchappers/blade-components)

A set of Tailwind-styled Blade components for making building blade templates easier.

## Features

- Components for most standard form elements with Tailwind CSS classes out of the box
- Automatic error rendering alongside each input
- Old-input repopulation via `old()` after failed form submissions
- Method spoofing for `PUT`, `PATCH`, and `DELETE` forms with automatic CSRF output
- Dot-notation conversion for array field names (e.g. `items[0][name]` → `items.0.name`)
- ARIA attributes (`aria-required`, `aria-disabled`, `aria-readonly`) applied automatically
- Easy override customisations

## Requirements

- PHP 8.2 or higher
- Laravel 11 or higher

## Installation

Install the package with composer:

```bash
composer require adzchappers/blade-components
```

Optionally publish the configuration file:

```bash
php artisan vendor:publish --tag="blade-components-config"
```

## Configuration

After publishing, `config/blade-components.php` exposes two keys:

- **`prefix`** - A string prepended to every component name. With `'prefix' => 'bc'`, `<x-form />` becomes `<x-bc-form />`. Defaults to `''` (no prefix).
- **`components`** - A map of component name → `['class' => ..., 'view' => ...]`. Override either entry to swap in a custom class or Blade view for any component.

```php
// config/blade-components.php
return [
    'prefix' => '',
    'components' => [
        'form-input' => [
            'class' => \App\View\Components\MyFormInput::class,
            'view'  => 'blade-components::forms.form-input',
        ],
        // ...
    ],
];
```

## Usage

### Form structure

#### `x-form`

Renders an HTML `<form>` tag. Automatically outputs a CSRF token and a spoofed method field when using `PUT`, `PATCH`, or `DELETE`. Normalises the `method` attribute to uppercase.

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `method` | `string` | `'POST'` | HTTP method. Normalised to uppercase. |
| `has-files` | `bool` | `false` | Adds `enctype="multipart/form-data"`. |

Additional attributes (e.g. `class`, `action`, `id`) are merged onto the `<form>` element.

```blade
<x-form action="{{ route('users.store') }}">
    {{-- CSRF added automatically --}}
    <x-form-input name="name" label="Name" required />
    <x-form-button>Save</x-form-button>
</x-form>

{{-- PUT form with file upload --}}
<x-form method="PUT" action="{{ route('users.update', $user) }}" has-files>
    {{-- CSRF + _method=PUT added automatically --}}
    <x-form-input name="avatar" type="file" label="Avatar" />
    <x-form-button>Update</x-form-button>
</x-form>
```

---

#### `x-form-fieldset`

Wraps content in a `<fieldset>` with an optional `<legend>`. Supports disabling the entire group.

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `legend` | `string\|null` | `null` | Legend text. Omitted when not set. |
| `disabled` | `bool` | `false` | Adds `disabled aria-disabled="true"`. |

```blade
<x-form-fieldset legend="Personal details" class="space-y-4">
    <x-form-input name="first_name" label="First name" />
    <x-form-input name="last_name" label="Last name" />
</x-form-fieldset>

{{-- Disabled group --}}
<x-form-fieldset legend="Billing" :disabled="true">
    <x-form-input name="card_number" label="Card number" />
</x-form-fieldset>
```

---

### Inputs

All input components share these behaviours: old-input repopulation, automatic error display, and ARIA attribute rendering. See [Behaviours](#behaviours) for details.

#### `x-form-input`

Renders a single `<input>` element wrapped in a `<div>` with an optional `<label>` and error message. Hidden inputs (`type="hidden"`) render without the wrapper, label, or error.

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `name` | `string` | - | Field name. Required. |
| `id` | `string\|null` | `null` | Element `id`. Auto-generated from `name` when not set. |
| `label` | `string\|null` | `null` | Label text. No `<label>` rendered when omitted. |
| `type` | `string` | `'text'` | Input type (e.g. `email`, `password`, `file`, `hidden`). |
| `placeholder` | `string\|null` | `null` | Placeholder text. |
| `value` | `string\|null` | `null` | Initial value. Overridden by old input when present. |
| `required` | `bool` | `false` | Adds `required aria-required="true"`. |
| `disabled` | `bool` | `false` | Adds `disabled aria-disabled="true"`. |
| `readonly` | `bool` | `false` | Adds `readonly aria-readonly="true"`. |
| `show-error` | `bool` | `true` | Renders the field error message. Set to `false` to suppress. |

```blade
<x-form-input name="email" type="email" label="Email address" placeholder="you@example.com" required />

<x-form-input name="amount" type="number" label="Amount (£)" value="0.00" />

<x-form-input type="hidden" name="_locale" value="en" />
```

---

#### `x-form-textarea`

Renders a `<textarea>` with an optional `<label>` and error message.

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `name` | `string` | - | Field name. Required. |
| `id` | `string\|null` | `null` | Element `id`. Auto-generated from `name` when not set. |
| `label` | `string\|null` | `null` | Label text. No `<label>` rendered when omitted. |
| `placeholder` | `string\|null` | `null` | Placeholder text. |
| `value` | `string\|null` | `null` | Initial content. Overridden by old input when present. |
| `required` | `bool` | `false` | Adds `required aria-required="true"`. |
| `disabled` | `bool` | `false` | Adds `disabled aria-disabled="true"`. |
| `readonly` | `bool` | `false` | Adds `readonly aria-readonly="true"`. |
| `show-error` | `bool` | `true` | Renders the field error message. Set to `false` to suppress. |

```blade
<x-form-textarea
    name="description"
    label="Description"
    placeholder="Enter a description…"
    :value="$model->description"
    required
/>
```

---

#### `x-form-select`

Renders a `<select>` element with an optional `<label>` and error message.

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `name` | `string` | - | Field name. Required. |
| `id` | `string\|null` | `null` | Element `id`. Auto-generated from `name` when not set. |
| `label` | `string\|null` | `null` | Label text. No `<label>` rendered when omitted. |
| `options` | `array` | `[]` | Associative array of `value => label` pairs. |
| `selected` | `string\|array\|null` | `null` | Selected value(s). Overridden by old input when present. |
| `multiple` | `bool` | `false` | Enables multi-select. |
| `required` | `bool` | `false` | Adds `required aria-required="true"`. |
| `disabled` | `bool` | `false` | Adds `disabled aria-disabled="true"`. |
| `readonly` | `bool` | `false` | Adds `readonly aria-readonly="true"`. |
| `show-error` | `bool` | `true` | Renders the field error message. Set to `false` to suppress. |

```blade
<x-form-select
    name="country"
    label="Country"
    :options="['gb' => 'United Kingdom', 'us' => 'United States', 'ca' => 'Canada']"
    :selected="$user->country"
/>

{{-- Multi-select --}}
<x-form-select
    name="roles"
    label="Roles"
    :options="$roles"
    :selected="$user->roles->pluck('id')->all()"
    multiple
/>
```

---

#### `x-form-checkbox`

Renders a single `<input type="checkbox">` with an optional `<label>` and error message. Handles old-input correctly - if the form was previously submitted and the checkbox was unchecked, it stays unchecked.

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `name` | `string` | - | Field name. Required. |
| `id` | `string\|null` | `null` | Element `id`. Auto-generated from `name` when not set. |
| `label` | `string\|null` | `null` | Label text. No `<label>` rendered when omitted. |
| `value` | `string\|null` | `'1'` | The value submitted when checked. |
| `checked` | `bool` | `false` | Whether the checkbox is initially checked. |
| `required` | `bool` | `false` | Adds `required aria-required="true"`. |
| `disabled` | `bool` | `false` | Adds `disabled aria-disabled="true"`. |
| `readonly` | `bool` | `false` | Adds `readonly aria-readonly="true"`. |
| `show-error` | `bool` | `true` | Renders the field error message. Set to `false` to suppress. |

```blade
<x-form-checkbox name="terms" label="I agree to the terms and conditions" required />

<x-form-checkbox name="newsletter" label="Subscribe to newsletter" :checked="$user->newsletter" />
```

---

#### `x-form-radio`

Renders a single `<input type="radio">` with an optional `<label>`. Typically used inside an `<x-form-fieldset>` to group related options.

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `name` | `string` | - | Field name. Required. |
| `id` | `string\|null` | `null` | Element `id`. Auto-generated from `name` when not set. |
| `label` | `string\|null` | `null` | Label text. No `<label>` rendered when omitted. |
| `value` | `string\|null` | `'1'` | The value submitted when this option is selected. |
| `checked` | `bool` | `false` | Whether this option is initially selected. |
| `required` | `bool` | `false` | Adds `required aria-required="true"`. |
| `disabled` | `bool` | `false` | Adds `disabled aria-disabled="true"`. |
| `readonly` | `bool` | `false` | Adds `readonly aria-readonly="true"`. |
| `show-error` | `bool` | `true` | Renders the field error message. Set to `false` to suppress. |

```blade
<x-form-fieldset legend="Preferred contact method">
    <x-form-radio name="contact" value="email" label="Email" :checked="$user->contact === 'email'" />
    <x-form-radio name="contact" value="phone" label="Phone" :checked="$user->contact === 'phone'" />
    <x-form-radio name="contact" value="post"  label="Post"  :checked="$user->contact === 'post'" />
</x-form-fieldset>
```

---

### Supporting

#### `x-form-label`

Renders a `<label>` element. Used automatically by input components when `label` is set, but also available standalone for custom layouts.

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `for` | `string` | - | The `id` of the associated input. Required. |
| `required` | `bool` | `false` | Appends a required indicator (`*`) to the label text. |

```blade
<x-form-label for="email" required>Email address</x-form-label>
<input id="email" type="email" name="email" />
```

---

#### `x-form-button`

Renders a `<button>` element. Validates the `type` attribute and falls back to `submit` for unrecognised values. When the slot is empty, the button renders the translatable string `Submit` as its label.

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `type` | `string` | `'submit'` | Button type: `submit`, `button`, or `reset`. |

```blade
<x-form-button>Save changes</x-form-button>

<x-form-button type="button" class="btn-secondary">Cancel</x-form-button>

<x-form-button type="reset">Clear form</x-form-button>
```

---

#### `x-form-error`

Renders the first validation error message for a named field. Used automatically by input components, but also available standalone.

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `name` | `string` | - | Field name to look up. Supports array notation (e.g. `items[0][name]`). Required. |
| `bag` | `string` | `'default'` | The error bag to read from. |

```blade
<input type="text" name="email" />
<x-form-error name="email" />
```

---

#### `x-form-error-list`

Renders all validation errors from an error bag as an unordered list. Useful at the top of a form to summarise every failure.

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `bag` | `string` | `'default'` | The error bag to read from. |

```blade
<x-form action="{{ route('users.store') }}">
    <x-form-error-list />

    <x-form-input name="name" label="Name" />
    <x-form-input name="email" type="email" label="Email" />
    <x-form-button>Save</x-form-button>
</x-form>
```

---

## Behaviours

### Old input repopulation

After a failed form submission, `x-form-input`, `x-form-textarea`, `x-form-select`, `x-form-checkbox`, and `x-form-radio` automatically call `old()` to restore the user's previous input. You do not need to write `:value="old('field', $default)"` manually.

`x-form-checkbox` handles the unchecked case correctly - HTML forms do not include unchecked checkboxes in the submission, so the component checks `session()->hasOldInput()` before deciding whether to restore state.

### Automatic error display

Input components render an `<x-form-error>` for their field by default. To suppress it for a specific field, pass `:show-error="false"`:

```blade
<x-form-input name="email" :show-error="false" />
```

Use `<x-form-error-list />` to render all errors in one place at the top of the form instead.

### Method spoofing and CSRF

`<x-form>` outputs a CSRF token on every state-changing form (anything other than `GET`, `HEAD`, or `OPTIONS`). When `method` is `PUT`, `PATCH`, or `DELETE`, it also outputs a hidden `_method` field and sets the `<form method="POST">`, conforming to [Laravel's method spoofing](https://laravel.com/docs/routing#form-method-spoofing):

```blade
<x-form method="DELETE" action="{{ route('users.destroy', $user) }}">
    {{-- Renders: <input type="hidden" name="_method" value="DELETE"> --}}
    <x-form-button>Delete account</x-form-button>
</x-form>
```

### Array field names and dot notation

Field names written in array notation (e.g. `items[0][name]`) are automatically converted to dot notation (`items.0.name`) when looking up validation errors and old input. This means standard Laravel validation error keys work correctly for array fields:

```blade
@foreach ($items as $index => $item)
    <x-form-input name="items[{{ $index }}][name]" label="Item name" :value="$item->name" />
@endforeach
```

Validation errors keyed as `items.0.name`, `items.1.name`, etc. will appear next to the correct field.

## Testing

```bash
composer test          # PHPUnit + PHPStan
composer test:phpunit  # PHPUnit only
composer test:phpstan  # PHPStan static analysis
composer pint          # check/fix code style
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Adz Chappers](https://github.com/adzchappers)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
