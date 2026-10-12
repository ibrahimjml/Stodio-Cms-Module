<div class="overflow-hidden my-4 rounded-2xl border border-gray-200 bg-white px-4 pb-3 pt-4 dark:border-gray-800 dark:bg-white/[0.03] sm:px-6">
    <div class="flex flex-col gap-2 mb-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Recent Activity</h3>
        </div>

            <a href="{{ route('auditlog.index') }}" class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">
                See all
            </a>
        </div>
          @php
        $typeBadgeClasses = [
            'created' => 'bg-green-50 text-green-600 dark:bg-green-500/15 dark:text-green-500',
            'updated' => 'bg-blue-50 text-blue-600 dark:bg-blue-500/15 dark:text-blue-500',
            'deleted' => 'bg-red-50 text-red-600 dark:bg-red-500/15 dark:text-red-500',
            'default' => 'bg-yellow-50 text-yellow-600 dark:bg-yellow-500/15 dark:text-orange-400',
        ];
    @endphp
    <x-admin::table.index
        :columns="[
            ['label' => __('User')],
            ['label' => __('Module')],
            ['label' => __('Action')],
            ['label' => __('Type')],
            ['label' => __('Reference')],
            ['label' => __('IP Address')],
            ['label' => __('Date')],
            ['label' => '', 'class' => 'relative capitalize'],
        ]"
        :items="$auditLogs"
    >
        <x-slot:rows>
            @foreach ($auditLogs as $auditLog)
                <tr>
                    <td class="px-4 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="shrink-0 w-8 h-8">
                                <img class="w-8 h-8 rounded-full" src="{{ $auditLog->user->image_url }}" alt="{{ $auditLog->user->name }}">
                            </div>
                            <div class="ltr:ml-4 rtl:mr-4">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $auditLog->user->name }}</div>
                            </div>
                        </div>
                    </td>

                    <td class="px-4 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $auditLog->module }}</div>
                    </td>

                    <td class="px-4 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $auditLog->action }}</div>
                    </td>

                    <td class="px-4 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $typeBadgeClasses[$auditLog->type] ?? $typeBadgeClasses['default'] }}">{{ $auditLog->type }}</span>
                    </td>

                    <td class="px-4 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $auditLog->reference_name }} #{{ $auditLog->reference_id }}
                        </div>
                    </td>

                    <td class="px-4 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $auditLog->ip_address ?? '—' }}</div>
                    </td>

                    <td class="px-4 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $auditLog->created_at->diffForHumans() }}</div>
                    </td>

                    
                </tr>
            @endforeach
        </x-slot:rows>
    </x-admin::table.index>
    </div>  