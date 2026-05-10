<div>
    @if ($label)
        <x-form-label
            label="{{ $label }}"
            required="{{ $required }}"
            for="{{ $id() }}"
            class="{{ $hasError() ? 'error' : '' }}"
            />
    @endif

    <textarea
        id="{{ $id() }}"
        name="{{ $name }}"
        @if ($placeholder !== null) placeholder="{{ $placeholder }}" @endif
        @if ($required) required aria-required="true" @endif
        @if ($disabled) disabled aria-disabled="true" @endif
        @if ($readonly) readonly aria-readonly="true" @endif
        {{ $attributes->merge(['class' => 'block w-full px-3 py-2 text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 read-only:bg-gray-100 read-only:cursor-not-allowed']) }}
    >{!! $value !!}</textarea>

    @if ($showError())
        <x-form-error name="{{ $name }}" />
    @endif
</div>
