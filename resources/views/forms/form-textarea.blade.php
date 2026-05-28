<div>
    @if ($label)
        <x-form-label required="{{ $required }}" for="{{ $id() }}">{{ $label }}</x-form-label>
    @endif

    <div class="mt-2">
        <textarea
            id="{{ $id() }}"
            name="{{ $name }}"
            @if ($placeholder !== null) placeholder="{{ $placeholder }}" @endif
            @if ($required) required aria-required="true" @endif
            @if ($disabled) disabled aria-disabled="true" @endif
            @if ($readonly) readonly aria-readonly="true" @endif
            @if ($hasError()) aria-invalid="true" @endif
            {{ $attributes->merge(['class' => 'block w-full rounded-md bg-slate-50/20 border border-slate-300 px-3 py-2 text-sm text-slate-600 transition duration-300 placeholder:text-slate-300 read-only:cursor-default read-only:border-dashed hover:ring-2 hover:ring-slate-100 hover:border-slate-400 read-only:hover:ring-0 read-only:hover:border-slate-300 focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-slate-100 focus:border-slate-400 read-only:focus:ring-0 read-only:focus:border-slate-300 disabled:cursor-not-allowed disabled:bg-slate-100 disabled:opacity-50 disabled:border-slate-200 disabled:hover:ring-0 disabled:focus:ring-0 aria-invalid:border-red-400 aria-invalid:hover:border-red-400 aria-invalid:hover:ring-red-100 aria-invalid:focus:border-red-500 aria-invalid:focus:ring-red-100']) }}
        >{!! $value !!}</textarea>
    </div>

    @if ($showError())
        <x-form-error name="{{ $name }}" />
    @endif
</div>
