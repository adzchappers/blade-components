<div>
    <div class="flex items-center gap-2">
        <input
            id="{{ $id() }}"
            type="radio"
            name="{{ $name }}"
            value="{{ $value }}"
            @if ($checked) checked @endif
            @if ($required) required aria-required="true" @endif
            @if ($disabled) disabled aria-disabled="true" @endif
            @if ($readonly) tabindex="-1" aria-readonly="true" @endif
            {{ $attributes->merge(['class' => 'h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500' .  ($readonly ? ' pointer-events-none' : '')]) }}
        />

        @if ($label)
            <x-form-label
                label="{{ $label }}"
                required="{{ $required }}"
                for="{{ $id() }}"
                class="{{ $hasError() ? 'error' : '' }}"
                />
        @endif
    </div>

    @if ($showError())
        <x-form-error name="{{ $name }}" />
    @endif
</div>
