<fieldset
    @if ($disabled) disabled aria-disabled="true" @endif
    {{ $attributes->merge(['class' => 'rounded-md border border-slate-300 p-4']) }}
>
    @if ($legend)
        <legend class="px-2 text-sm font-medium text-slate-700">{{ $legend }}</legend>
    @endif

    {!! $slot !!}
</fieldset>
