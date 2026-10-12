@props([
    'paginator' => null,
])

@if ($paginator && $paginator->hasPages())
    @php
        $previousIcon = <<<'SVG'
            <svg class="rtl:rotate-180" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M2.58301 9.99868C2.58272 10.1909 2.65588 10.3833 2.80249 10.53L7.79915 15.5301C8.09194 15.8231 8.56682 15.8233 8.85981 15.5305C9.15281 15.2377 9.15297 14.7629 8.86018 14.4699L5.14009 10.7472L16.6675 10.7472C17.0817 10.7472 17.4175 10.4114 17.4175 9.99715C17.4175 9.58294 17.0817 9.24715 16.6675 9.24715L5.14554 9.24715L8.86017 5.53016C9.15297 5.23717 9.15282 4.7623 8.85983 4.4695C8.56684 4.1767 8.09197 4.17685 7.79917 4.46984L2.84167 9.43049C2.68321 9.568 2.58301 9.77087 2.58301 9.99715C2.58301 9.99766 2.58301 9.99817 2.58301 9.99868Z" fill="currentColor"/>
            </svg>
            SVG;

        $nextIcon = <<<'SVG'
            <svg class="rtl:rotate-180" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M17.4175 9.9986C17.4178 10.1909 17.3446 10.3832 17.198 10.53L12.2013 15.5301C11.9085 15.8231 11.4337 15.8233 11.1407 15.5305C10.8477 15.2377 10.8475 14.7629 11.1403 14.4699L14.8604 10.7472L3.33301 10.7472C2.91879 10.7472 2.58301 10.4114 2.58301 9.99715C2.58301 9.58294 2.91879 9.24715 3.33301 9.24715L14.8549 9.24715L11.1403 5.53016C10.8475 5.23717 10.8477 4.7623 11.1407 4.4695C11.4336 4.1767 11.9085 4.17685 12.2013 4.46984L17.1588 9.43049C17.3173 9.568 17.4175 9.77087 17.4175 9.99715C17.4175 9.99763 17.4175 9.99812 17.4175 9.9986Z" fill="currentColor"/>
            </svg>
            SVG;

        $buttonClasses = 'flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-3 py-3 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200 sm:px-3.5';

        $currentPage = $paginator->currentPage();
        $lastPage = $paginator->lastPage();
        $onEachSide = 1;

        $visiblePages = collect(range(1, $lastPage))
            ->filter(fn (int $page) => $page === 1 || $page === $lastPage || abs($page - $currentPage) <= $onEachSide)
            ->values();

        $pages = collect();
        $previousPage = 0;

        foreach ($visiblePages as $page) {
            if ($previousPage && $page - $previousPage > 1) {
                $pages->push('...');
            }

            $pages->push($page);
            $previousPage = $page;
        }
    @endphp

    <div {{ $attributes->class(['px-6 py-4 border-t border-gray-200 dark:border-white/[0.05]']) }}>
        <div class="flex items-center justify-between">
            @if ($paginator->onFirstPage())
                <span class="{{ $buttonClasses }} opacity-50 cursor-not-allowed" aria-disabled="true">
                    {!! $previousIcon !!}
                    <span class="hidden sm:inline">{{ __('Previous') }}</span>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="{{ $buttonClasses }}">
                    {!! $previousIcon !!}
                    <span class="hidden sm:inline">{{ __('Previous') }}</span>
                </a>
            @endif

            <span class="block text-sm font-medium text-gray-700 dark:text-gray-400 sm:hidden">
                {{ __('Page') }} <span>{{ $currentPage }}</span> {{ __('of') }} <span>{{ $lastPage }}</span>
            </span>

            <ul class="hidden items-center gap-0.5 sm:flex">
                @foreach ($pages as $page)
                    @if ($page === '...')
                        <li>
                            <span class="flex h-10 w-10 items-center justify-center text-gray-500 dark:text-gray-400">&hellip;</span>
                        </li>
                    @elseif ($page === $currentPage)
                        <li>
                            <span aria-current="page" class="flex h-10 w-10 items-center justify-center rounded-lg text-theme-sm font-medium bg-blue-500 text-white">{{ $page }}</span>
                        </li>
                    @else
                        <li>
                            <a href="{{ $paginator->url($page) }}" class="flex h-10 w-10 items-center justify-center rounded-lg text-theme-sm font-medium text-gray-700 hover:bg-blue-500/[0.08] hover:text-blue-500 dark:text-gray-400 dark:hover:text-blue-500">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            </ul>

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="{{ $buttonClasses }}">
                    <span class="hidden sm:inline">{{ __('Next') }}</span>
                    {!! $nextIcon !!}
                </a>
            @else
                <span class="{{ $buttonClasses }} opacity-50 cursor-not-allowed" aria-disabled="true">
                    <span class="hidden sm:inline">{{ __('Next') }}</span>
                    {!! $nextIcon !!}
                </span>
            @endif
        </div>
    </div>
@endif