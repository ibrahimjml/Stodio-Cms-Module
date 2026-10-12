@extends('admin::layouts.admin')

@section('title', __('Modules'))

@section('content')
    @php
        $tabs = [
            'all' => ['label' => __('All'), 'count' => $activeCount + $inactiveCount],
            'active' => ['label' => __('Active'), 'count' => $activeCount],
            'inactive' => ['label' => __('Not Active'), 'count' => $inactiveCount],
        ];
    @endphp

    <x-admin::table.index
        :title="__('Modules')"
        :columns="[
            ['label' => __('Module')],
            ['label' => __('Version')],
            ['label' => __('Status')],
            ['label' => '', 'class' => 'relative capitalize'],
            ['label' => '', 'class' => 'relative'],
        ]"
        :items="$modules"
        :paginator="$modules"
        :empty="__('No modules found.')"
    >
        <x-slot:header>

            <div class="flex items-center gap-2 rounded-lg border border-gray-200 p-1 dark:border-gray-800">
                @foreach ($tabs as $key => $tab)
                    <a href="{{ route('admin.modules.index', $key === 'all' ? [] : ['status' => $key]) }}"
                        class="flex items-center gap-2 rounded-md px-3 py-2 text-sm font-medium transition-colors
                            {{ $status === $key
                                ? 'bg-brand-500 text-white'
                                : 'text-gray-500 hover:text-brand-500 dark:text-gray-400 dark:hover:text-brand-500' }}">
                        {{ $tab['label'] }}
                        <span class="text-xs">{{ $tab['count'] }}</span>
                    </a>
                @endforeach
            </div>


        </x-slot:header>

        <x-slot:rows>
            @foreach ($modules as $module)
                @php
                    $moduleIcon = svg('o-'.strtolower($module['name']));
                @endphp
                <tr>
                    <td class="px-4 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                                <div class="shrink-0 w-10 h-10 flex items-center justify-center rounded-lg bg-gray-100 text-gray-500 dark:bg-white/5 dark:text-gray-400">
                                    {!! $moduleIcon !== '' ? $moduleIcon : svg('o-system') !!}
                                </div>
                            <div class="ltr:ml-4 rtl:mr-4">
                                <div class="flex items-center gap-2 text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $module['name'] }}
                                    @if ($module['excluded'])
                                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-purple-50 text-purple-600 dark:bg-purple-500/15 dark:text-purple-400">
                                            {{ __('System') }}
                                        </span>
                                    @endif
                                </div>
                                @if ($module['description'])
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $module['description'] }}</div>
                                @endif
                              
                            </div>
                        </div>
                    </td>

                    <td class="px-4 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500 dark:text-gray-400">v{{ $module['version'] }}</div>
                    </td>

                    <td class="px-4 py-4 whitespace-nowrap">
                        @if ($module['active'])
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-50 text-green-600 dark:bg-green-500/15 dark:text-green-500">
                                {{ __('Active') }}
                            </span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-50 text-gray-600 dark:bg-gray-500/15 dark:text-gray-400">
                                {{ __('Not Active') }}
                            </span>
                        @endif
                    </td>

                    <td class="px-4 py-4 text-sm font-medium text-right whitespace-nowrap">
                        <div class="flex justify-end">
                            @if (! $module['active'])
                                <form method="POST" action="{{ route('admin.modules.activate', $module['name']) }}">
                                    @csrf
                                    <input type="hidden" name="status" value="{{ $status }}">

                                    <button type="submit"
                                        class="inline-flex items-center justify-center rounded-lg bg-brand-500 px-3 py-2 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600">
                                        {{ __('Activate') }}
                                    </button>
                                </form>
                            @elseif ($module['excluded'])
                                <span class="text-sm text-gray-400 dark:text-gray-500">{{ __('Always active') }}</span>
                            @else
                                <form method="POST" action="{{ route('admin.modules.deactivate', $module['name']) }}">
                                    @csrf
                                    <input type="hidden" name="status" value="{{ $status }}">

                                    <button type="submit"
                                        class="inline-flex items-center justify-center rounded-lg border border-gray-300 px-3 py-2 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">
                                        {{ __('Deactivate') }}
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>

                    <td class="px-4 py-4 text-sm font-medium text-right whitespace-nowrap">
                        <div class="flex justify-center relative">
                            <x-admin::table.dropdown-actions>
                                <x-slot name="button">
                                    <button type="button" aria-haspopup="true" aria-expanded="false" class="text-gray-500 dark:text-gray-400">
                                        <svg class="fill-current" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12 5.5C12.8284 5.5 13.5 6.17157 13.5 7C13.5 7.82843 12.8284 8.5 12 8.5C11.1716 8.5 10.5 7.82843 10.5 7C10.5 6.17157 11.1716 5.5 12 5.5ZM12 10.5C12.8284 10.5 13.5 11.1716 13.5 12C13.5 12.8284 12.8284 13.5 12 13.5C11.1716 13.5 10.5 12.8284 10.5 12C10.5 11.1716 11.1716 10.5 12 10.5ZM12 15.5C12.8284 15.5 13.5 16.1716 13.5 17C13.5 17.8284 12.8284 18.5 12 18.5C11.1716 18.5 10.5 17.8284 10.5 17C10.5 16.1716 11.1716 15.5 12 15.5Z" fill="currentColor"/>
                                        </svg>
                                    </button>
                                </x-slot>

                                <x-slot name="content">

                                    @if ($module['pendingMigrations'] > 0)
                                        <form method="POST" action="{{ route('admin.modules.migrate', $module['name']) }}">
                                            @csrf
                                            <button type="submit" role="menuitem"
                                                class="flex w-full px-3 py-2 font-medium text-gray-700 rounded-lg text-theme-xs hover:bg-gray-50 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-white/[0.03] dark:hover:text-white">
                                                {{ __('Run migrations') }} ({{ $module['pendingMigrations'] }})
                                            </button>
                                        </form>
                                    @endif

                                    @if (! $module['excluded'])
                                        <form method="POST" action="{{ route('admin.modules.destroy', $module['name']) }}"
                                            onsubmit="return confirm('{{ __('Remove ":module" and roll back its migrations?', ['module' => $module['name']]) }}');">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" role="menuitem"
                                                class="flex w-full px-3 py-2 font-medium text-start text-red-600 rounded-lg text-theme-xs hover:bg-red-50 hover:text-red-700 dark:text-red-500 dark:hover:bg-red-500/10 dark:hover:text-red-400">
                                                {{ __('Remove') }}
                                            </button>
                                        </form>
                                    @endif
                                </x-slot>
                            </x-admin::table.dropdown-actions>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-slot:rows>
    </x-admin::table.index>
@endsection