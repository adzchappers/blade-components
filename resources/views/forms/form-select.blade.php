<div>
    @if ($label)
        <x-form-label required="{{ $required }}" for="{{ $id() }}">{{ $label }}</x-form-label>
    @endif

    @if ($label)
        <div class="mt-2">
    @endif
        <div class="relative">
            <select
                id="{{ $id() }}"
                name="{{ $name }}{{ $multiple ? '[]' : '' }}"
                @if ($multiple) multiple @endif
                @if ($required) required aria-required="true" @endif
                @if ($disabled) disabled aria-disabled="true" @endif
                @if ($readonly) tabindex="-1" aria-readonly="true" @endif
                @if ($hasError()) aria-invalid="true" @endif
                {{ $attributes->merge(['class' => 'block w-full bg-none appearance-none rounded-md bg-slate-50/20 border border-slate-300 pl-3 pr-10 py-2 text-sm text-slate-600 transition duration-300 hover:ring-2 hover:ring-slate-100 hover:border-slate-400 focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-slate-100 focus:border-slate-400 disabled:cursor-not-allowed disabled:bg-slate-100 disabled:opacity-50 disabled:border-slate-200 disabled:hover:ring-0 disabled:focus:ring-0 aria-readonly:pointer-events-none aria-readonly:bg-slate-100 aria-invalid:border-red-400 aria-invalid:hover:border-red-400 aria-invalid:hover:ring-red-100 aria-invalid:focus:border-red-500 aria-invalid:focus:ring-red-100']) }}
            >
                @foreach ($options as $k => $v)
                    <option value="{{ $k }}"{{ $isSelected($k) ? ' selected' : '' }}>{{ $v }}</option>
                @endforeach
            </select>

            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-400">
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" fill-rule="evenodd" />
                </svg>
            </div>
        </div>
    @if ($label)
        </div>
    @endif

    @if ($showError())
        <x-form-error name="{{ $name }}" />
    @endif
</div>
