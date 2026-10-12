@props([
    'action' => '',
    'method' => 'POST',
])

@php
    // Browsers only support GET/POST on forms. Spoofed verbs (PUT/PATCH/DELETE)
    // must still render method="POST" with a hidden _method field.
    $htmlMethod = in_array(strtoupper($method), ['GET', 'POST']) ? strtoupper($method) : 'POST';
@endphp

<form {{ $attributes->merge(['action' => $action, 'method' => $htmlMethod]) }}>
    @csrf

    @if ($htmlMethod !== strtoupper($method))
        @method($method)
    @endif

    {{ $slot }}
</form>
