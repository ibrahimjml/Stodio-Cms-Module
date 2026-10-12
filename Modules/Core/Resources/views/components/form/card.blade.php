@props([
    'title' => null,
])

<section {{ $attributes->class(['flex flex-col break-words rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900']) }}>
    @if ($title)
        <header class="rounded-t-2xl border-b border-gray-200 bg-gray-50 px-6 py-5 text-center font-bold text-gray-900 dark:border-gray-800 dark:bg-gray-800 dark:text-white sm:px-8 sm:py-6">
            {{ $title }}
        </header>
    @endif

    {{ $slot }}
</section>
