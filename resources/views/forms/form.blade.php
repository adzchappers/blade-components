<form method="{{ $spoofed ? 'POST' : $method }}" {!! $hasFiles ? 'enctype="multipart/form-data"' : '' !!} {!! $attributes->merge() !!}>
    @if ($spoofed)
        @csrf
        @method($method)
    @endif

    {!! $slot !!}

</form>
