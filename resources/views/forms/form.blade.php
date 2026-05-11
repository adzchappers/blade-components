<form method="{{ $spoofed ? 'POST' : $method }}" {!! $hasFiles ? 'enctype="multipart/form-data"' : '' !!} {!! $attributes->merge() !!}>
    @unless(in_array($method, ['HEAD', 'GET', 'OPTIONS']))
        @csrf
    @endunless

    @if ($spoofed)
        @method($method)
    @endif

    {!! $slot !!}

</form>
