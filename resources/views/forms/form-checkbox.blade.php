<div>
    <div class="flex items-center gap-2">
        <input
            id="{{ $id() }}"
            type="checkbox"
            name="{{ $name }}"
            value="{{ $value }}"
            @if ($checked) checked @endif
            @if ($required) required aria-required="true" @endif
            @if ($disabled) disabled aria-disabled="true" @endif
            @if ($readonly) tabindex="-1" aria-readonly="true" @endif
            @if ($hasError()) aria-invalid="true" @endif
            {{ $attributes->merge(['class' => 'h-4 w-4 appearance-none rounded-sm border border-slate-300 bg-white text-slate-600 transition duration-300 hover:border-slate-400 checked:border-slate-600 checked:bg-slate-600 indeterminate:border-slate-600 indeterminate:bg-slate-600 focus:outline-none focus:ring-0 focus-visible:ring-2 focus-visible:ring-slate-600 focus-visible:ring-offset-0 disabled:cursor-not-allowed disabled:border-slate-200 disabled:bg-slate-100 disabled:opacity-50 disabled:checked:bg-slate-100 aria-readonly:pointer-events-none aria-invalid:border-red-500 aria-invalid:checked:bg-red-500 aria-invalid:checked:border-red-500 forced-colors:appearance-auto']) }}
        />

        @if ($label)
            <x-form-label required="{{ $required }}" for="{{ $id() }}">{{ $label }}</x-form-label>
        @endif
    </div>

    @if ($showError())
        <x-form-error name="{{ $name }}" />
    @endif
</div>
