<button type="{{ $type }}" {{ $attributes->merge(['class' => 'inline-flex items-center justify-center rounded-md bg-slate-700 px-4 py-2 text-sm font-semibold text-white shadow-xs transition duration-300 hover:bg-slate-800 focus:outline-none focus:ring-0 focus-visible:ring-2 focus-visible:ring-slate-700 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:bg-slate-200 disabled:opacity-50']) }}>
    {!! trim($slot) ?: __('Submit') !!}
</button>
