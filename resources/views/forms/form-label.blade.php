<label for="{{ $for }}" {{ $attributes->merge(['class' => 'block text-sm/6 font-medium text-slate-700']) }}>
    {!! $slot !!}@if ($required)<span class="text-red-500">*</span>@endif
</label>
