@if ($type === 'hidden')
    <input
        type="{{ $type }}"
        id="{{ $id() }}"
        name="{{ $name }}"
        value="{{ $value }}"
        />
@else
    <div>
        @if ($label)
            <x-form-label
                label="{{ $label }}"
                required="{{ $label }}"
                for="{{ $id() }}"
                class="{{ $hasError() ? 'error' : '' }}"
                />
        @endif

        <div class="flex rounded-md shadow-sm">
            <input
                id="{{ $id() }}"
                type="{{ $type }}"
                name="{{ $name }}"
                value="{{ $value }}"
                @if ($placeholder !== null) placeholder="{{ $placeholder }}" @endif
                @if ($required) required aria-required="true" @endif
                @if ($disabled) disabled aria-disabled="true" @endif
                @if ($readonly) readonly aria-readonly="true" @endif
                {{ $attributes->except('id')->merge(['id' => $id(), 'class' => 'flex-1 block w-full min-w-0 px-3 py-2 text-sm border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 disabled:bg-gray-100 disabled:cursor-not-allowed read-only:bg-gray-100 read-only:cursor-not-allowed']) }}
            />
        </div>

        @if ($showError())
            <x-form-error name="{{ $name }}" />
        @endif
    </div>
@endif
