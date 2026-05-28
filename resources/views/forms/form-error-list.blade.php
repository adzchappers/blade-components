@if ($errors->getBag($bag)->any())
    <div {{ $attributes->merge(['class' => 'rounded-md bg-red-50 border border-red-200 p-4', 'role' => 'alert']) }}>
        <ul class="list-disc list-inside text-sm text-red-600 space-y-1">
            @foreach ($errors->getBag($bag)->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
