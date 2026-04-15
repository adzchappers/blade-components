<label
    for="{{ $for }}"
    {{ $attributes->merge(['class' => 'block text-sm font-medium text-gray-900']) }}
>
    {{ $slot }}@if ($required)<span>*</span>@endif
</label>
