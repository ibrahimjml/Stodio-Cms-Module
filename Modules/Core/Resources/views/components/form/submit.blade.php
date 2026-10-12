@props([
    'type' => 'submit',
])

<button type="{{ $type }}"
    {{ $attributes->class(['w-full cursor-pointer rounded-xl bg-gray-800 p-3 text-base font-semibold leading-normal text-white transition hover:bg-gray-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:outline-none dark:bg-blue-600 dark:hover:bg-blue-500 dark:focus:ring-offset-gray-900 sm:py-4']) }}>
    {{ $slot }}
</button>
