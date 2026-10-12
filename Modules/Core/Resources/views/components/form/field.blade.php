@props([
    'name' => null,
    'label' => null,
    'type' => 'text',
    'value' => null,
    'placeholder' => null,
    'autocomplete' => null,
    'autofocus' => false,
    'required' => true,
])

@php
    $label = $label ?? ucwords(str_replace(['-', '_'], ' ', (string) $name));
    $displayValue = $type === 'password' ? null : old($name, $value);
@endphp

<div class="flex flex-wrap">
    <label for="{{ $name }}" class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-300 sm:mb-3">
        {{ $label }}
    </label>

    <input id="{{ $name }}" type="{{ $type }}" name="{{ $name }}" value="{{ $displayValue }}"
        @if ($placeholder) placeholder="{{ $placeholder }}" @endif
        @if ($autocomplete) autocomplete="{{ $autocomplete }}" @endif
        @if ($autofocus) autofocus @endif
        @required($required)
        {{ $attributes->class([
            'w-full rounded-xl border border-gray-300 bg-white p-3 text-gray-900 transition placeholder:text-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none dark:border-gray-700 dark:bg-gray-950 dark:text-white dark:placeholder:text-gray-500 dark:focus:border-blue-400 dark:focus:ring-blue-500/20',
            'border-red-500 bg-white dark:border-red-500 dark:bg-gray-950' => $name && $errors->has($name),
        ]) }}>

    <small data-error-for="{{ $name }}"
        class="mt-2 h-4 w-full truncate text-xs italic leading-4 text-red-500 dark:text-red-400"></small>
</div>
