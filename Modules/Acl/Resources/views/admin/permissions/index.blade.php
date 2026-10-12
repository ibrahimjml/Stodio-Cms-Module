@extends('admin::layouts.admin')

@section('title', __('Permissions'))

@section('content')
    <x-admin::table.index
        :title="__('Permissions')"
        :columns="[
            ['label' => __('Name')],
            ['label' => __('Module')],
            ['label' => __('Roles')],
            ['label' => __('Description')],
            ['label' => '', 'class' => 'relative capitalize'],
        ]"
        :items="$permissions"
        :paginator="$permissions"
    >
        <x-slot:header>
            <a href="{{ route('admin.acl.permissions.create') }}" class="rounded-2xl bg-gray-700 px-4 py-2 text-sm font-bold text-white hover:bg-gray-500">
                {{ __('Create permission') }}
            </a>
        </x-slot:header>
        <x-slot:rows>
            @foreach ($permissions as $permission)
                <tr>
                    <td class="px-4 py-4 whitespace-nowrap">
                        <a href="{{ route('admin.acl.permissions.show', $permission) }}" class="text-sm font-medium text-gray-900 dark:text-white hover:underline">{{ $permission->name }}</a>
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $permission->module }}</div>
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $permission->roles_count }}</div>
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $permission->description ?? '—' }}</div>
                    </td>
                    <td class="px-4 py-4 text-sm font-medium text-right whitespace-nowrap">
                        <div class="flex justify-center relative">
                            <x-admin::table.dropdown-actions>
                                <x-slot name="button">
                                    <button type="button" aria-haspopup="true" aria-expanded="false" class="text-gray-500 dark:text-gray-400">
                                        <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M5.99902 10.245C6.96552 10.245 7.74902 11.0285 7.74902 11.995V12.005C7.74902 12.9715 6.96552 13.755 5.99902 13.755C5.03253 13.755 4.24902 12.9715 4.24902 12.005V11.995C4.24902 11.0285 5.03253 10.245 5.99902 10.245ZM17.999 10.245C18.9655 10.245 19.749 11.0285 19.749 11.995V12.005C19.749 12.9715 18.9655 13.755 17.999 13.755C17.0325 13.755 16.249 12.9715 16.249 12.005V11.995C16.249 11.0285 17.0325 10.245 17.999 10.245ZM13.749 11.995C13.749 11.0285 12.9655 10.245 11.999 10.245C11.0325 10.245 10.249 11.0285 10.249 11.995V12.005C10.249 12.9715 11.0325 13.755 11.999 13.755C12.9655 13.755 13.749 12.9715 13.749 12.005V11.995Z" fill="currentColor"/>
                                        </svg>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <a href="{{ route('admin.acl.permissions.edit', $permission) }}" class="flex w-full px-3 py-2 font-medium text-start rounded-lg text-theme-xs hover:bg-gray-50 dark:hover:bg-white/5">
                                        {{ __('Edit') }}
                                    </a>
                                    <form method="POST" action="{{ route('admin.acl.permissions.destroy', $permission) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" role="menuitem" class="flex w-full px-3 py-2 font-medium text-start text-red-600 rounded-lg text-theme-xs hover:bg-red-50 hover:text-red-700 dark:text-red-500 dark:hover:bg-red-500/10 dark:hover:text-red-400">
                                            {{ __('Delete') }}
                                        </button>
                                    </form>
                                </x-slot>
                            </x-admin::table.dropdown-actions>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-slot:rows>
    </x-admin::table.index>
@endsection
