<fieldset
    @if ($disabled) disabled aria-disabled="true" @endif
    {{ $attributes->merge(['class' => 'border border-gray-300 rounded-md p-4']) }}
>
    @if ($legend)
        <legend class="px-2 text-sm font-medium text-gray-700">{{ $legend }}</legend>
    @endif

    {!! $slot !!}
</fieldset>
