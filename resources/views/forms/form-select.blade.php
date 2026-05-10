<div>
    @if ($label)
        <x-form-label
            label="{{ $label }}"
            required="{{ $required }}"
            for="{{ $id() }}"
            class="{{ $hasError() ? 'error' : '' }}"
            />
    @endif

    <div class="relative">
        <select
            id="{{ $id() }}"
            name="{{ $name }}{{ $multiple ? '[]' : '' }}"
            @if ($multiple) multiple @endif
            @if ($required) required aria-required="true" @endif
            @if ($disabled) disabled aria-disabled="true" @endif
            @if ($readonly) tabindex="-1" aria-readonly="true" @endif
            {{ $attributes->merge(['class' => 'block w-full pl-3 pr-10 py-2 text-sm border border-gray-300 rounded-md shadow-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 disabled:bg-gray-100 disabled:cursor-not-allowed appearance-none' . ($readonly ? ' pointer-events-none bg-gray-100' : '')]) }}
        >
            @foreach ($options as $k => $v)
                <option value="{{ $k }}"{{ $isSelected($k) ? ' selected' : '' }}>{{ $v }}</option>
            @endforeach
        </select>

        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
            </svg>
        </div>
    </div>

    @if ($showError())
        <x-form-error name="{{ $name }}" />
    @endif
</div>
