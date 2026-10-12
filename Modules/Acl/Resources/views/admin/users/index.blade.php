@extends('admin::layouts.admin')

@section('title', __('Users'))

@section('content')
    <x-admin::table.index
        :title="__('Users')"
        :columns="[
            ['label' => __('User')],
            ['label' => __('Roles')],
            ['label' => __('Super')],
            ['label' => __('Created')],
            ['label' => '', 'class' => 'relative capitalize'],
        ]"
        :items="$users"
        :paginator="$users"
    >
        <x-slot:header>
            <a href="{{ route('admin.acl.users.create') }}" class="rounded-2xl bg-gray-700 px-4 py-2 text-sm font-bold text-white hover:bg-gray-500">
                {{ __('Create user') }}
            </a>
        </x-slot:header>
        <x-slot:rows>
            @foreach ($users as $user)
                <tr>
                    <td class="px-4 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="shrink-0 w-8 h-8">
                                <img class="w-8 h-8 rounded-full" src="{{ $user->image_url }}" alt="{{ $user->name }}">
                            </div>
                            <div class="ltr:ml-4 rtl:mr-4">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->name }}</div>
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>

                    <td class="px-4 py-4 whitespace-nowrap">
                        @if ($user->roles->isNotEmpty())
                            <div class="flex flex-wrap gap-1">
                                @foreach ($user->roles as $role)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-50 text-blue-600 dark:bg-blue-500/15 dark:text-blue-500">{{ $role->name }}</span>
                                @endforeach
                            </div>
                        @else
                            <div class="text-sm text-gray-400 dark:text-gray-500">{{ __('Not assigned') }}</div>
                        @endif
                    </td>

                    <td class="px-4 py-4 whitespace-nowrap">
                        @if ($user->super_user)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-50 text-green-600 dark:bg-green-500/15 dark:text-green-500">{{ __('Yes') }}</span>
                        @else
                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ __('No') }}</div>
                        @endif
                    </td>

                    <td class="px-4 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $user->created_at?->diffForHumans() }}</div>
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
                                    @can('update', $user)
                                    <a href="{{ route('admin.acl.users.edit', $user) }}" class="flex w-full px-3 py-2 font-medium text-start rounded-lg text-theme-xs hover:bg-gray-50 dark:hover:bg-white/5">
                                        {{ __('Edit') }}
                                    </a>
                                    @endcan
                                    @can('toggleSuper', $user)
                                    <form method="POST" action="{{ route('admin.acl.users.toggle-super', $user) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" role="menuitem" class="flex w-full px-3 py-2 font-medium text-start rounded-lg text-theme-xs hover:bg-gray-50 dark:hover:bg-white/5">
                                            {{ $user->super_user ? __('Remove super') : __('Make super') }}
                                        </button>
                                    </form>
                                    @endcan
                                    @can('delete', $user)
                                    <form method="POST" action="{{ route('admin.acl.users.destroy', $user) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" role="menuitem" class="flex w-full px-3 py-2 font-medium text-start text-red-600 rounded-lg text-theme-xs hover:bg-red-50 hover:text-red-700 dark:text-red-500 dark:hover:bg-red-500/10 dark:hover:text-red-400">
                                            {{ __('Delete') }}
                                        </button>
                                    </form>
                                    @endcan
                                </x-slot>
                            </x-admin::table.dropdown-actions>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-slot:rows>
    </x-admin::table.index>
@endsection
