@props([
    'action' => '',
    'method' => 'POST',
])

@php
    $htmlMethod = in_array(strtoupper($method), ['GET', 'POST']) ? strtoupper($method) : 'POST';
@endphp

<form {{ $attributes->merge(['action' => $action, 'method' => $htmlMethod]) }}>
    @csrf

    @if ($htmlMethod !== strtoupper($method))
        @method($method)
    @endif

    {{ $slot }}
</form>
