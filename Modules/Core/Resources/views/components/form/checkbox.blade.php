@props([
    'name' => null,
    'label' => null,
    'checked' => false,
])

<div class="flex items-center gap-2">
    <input id="{{ $name }}" type="checkbox" name="{{ $name }}"
        @checked(old($name, $checked))
        {{ $attributes->class(['h-4 w-4 rounded text-blue-600 border-gray-300 focus:ring-blue-500']) }}>

    <label for="{{ $name }}" class="text-sm text-gray-700">
        {{ $label }}
    </label>

    @error($name)
        <p class="text-red-500 text-xs italic mt-4">
            {{ $message }}
        </p>
    @enderror
</div>
