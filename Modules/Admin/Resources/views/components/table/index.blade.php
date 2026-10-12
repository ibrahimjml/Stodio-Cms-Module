@props([
    'title' => null,
    'columns' => [],
    'items' => null,
    'paginator' => null,
    'empty' => null,
])

<div {{ $attributes->class(['rounded-2xl border border-gray-200 bg-white pt-4 dark:border-gray-800 dark:bg-white/[0.03]']) }}>
    @if ($title || isset($header))
        <div class="flex flex-col gap-2 px-5 mb-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
            @if ($title)
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">{{ $title }}</h3>
            @endif

            @isset($header)
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                    {{ $header }}
                </div>
            @endisset
        </div>
    @endif

    <div class="overflow-hidden">
        <div class="max-w-full px-5 overflow-x-auto">
            <table class="w-full min-w-full">
                <thead>
                    <tr class="border-gray-200 border-y dark:border-gray-700">
                        @foreach ($columns as $column)
                            @php
                                $label = is_array($column) ? ($column['label'] ?? '') : $column;
                                $columnClasses = is_array($column) ? ($column['class'] ?? '') : '';
                            @endphp

                            <th scope="col" class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400 {{ $columnClasses }}">
                                @if ($loop->first && isset($selection))
                                    {{ $selection }}
                                @else
                                    {{ $label }}
                                @endif
                            </th>
                        @endforeach
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @if ($items && $items->isEmpty())
                        <tr>
                            <td colspan="{{ count($columns) }}" class="px-4 py-10 text-center text-sm text-gray-500 dark:text-gray-400">
                                {{ $empty ?? __('No records found.') }}
                            </td>
                        </tr>
                    @else
                        {{ $rows }}
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    @if ($paginator)
        <x-admin::table.pagination :paginator="$paginator" />
    @endif
</div>
