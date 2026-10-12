@extends('admin::layouts.admin')

@section('title', $role->name)

@section('content')
    <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_18rem]">
        <section class="space-y-5">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $role->name }}</h1>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('Permissions grouped by module') }}</p>
                </div>
                <span class="rounded-full bg-blue-50 px-3 py-1 text-sm font-medium text-blue-700 dark:bg-blue-500/10 dark:text-blue-300">
                    {{ trans_choice(':count permission|:count permissions', $role->permissions->count(), ['count' => $role->permissions->count()]) }}
                </span>
            </div>

            @forelse ($role->permissions->sortBy(fn ($permission) => [strtolower($permission->module ?? ''), strtolower($permission->name)])->groupBy(fn ($permission) => $permission->module ?: __('Other')) as $module => $permissions)
                <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
                    <div class="flex items-center justify-between border-b border-gray-200 px-5 py-4 dark:border-gray-800">
                        <h2 class="font-semibold text-gray-900 dark:text-white">{{ $module }}</h2>
                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ $permissions->count() }}</span>
                    </div>
                    <ul class="divide-y divide-gray-100 dark:divide-gray-800">
                        @foreach ($permissions as $permission)
                            <li class="px-5 py-3 text-sm text-gray-700 dark:text-gray-300">{{ $permission->name }}</li>
                        @endforeach
                    </ul>
                </section>
            @empty
                <div class="rounded-2xl border border-dashed border-gray-300 bg-white px-5 py-10 text-center text-sm text-gray-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-400">
                    {{ __('No permissions assigned.') }}
                </div>
            @endforelse
            <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
                    <div class="flex items-center justify-between border-b border-gray-200 px-5 py-4 dark:border-gray-800">
                        <h2 class="font-semibold text-gray-900 dark:text-white">Users with this Role</h2>
                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ $role->users->count() }}</span>
                    </div>
                    <ul class="divide-y divide-gray-100 dark:divide-gray-800">
                        @foreach ($role->users as $user)
                            <li class="px-5 py-3 text-sm text-gray-700 dark:text-gray-300">
                              <div class="flex items-center gap-3 p-2 rounded-lg border border-gray-200 my-2">
                                      <span class="mr-3 overflow-hidden rounded-full h-11 w-11 rtl:mr-0 rtl:ml-3">
                                     <img class="h-full w-full object-cover" src="{{ $user->image_url }}" alt="{{ $user->name }}" />
                                   </span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $user->name }}</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $user->email }}</span>
                              </div>
                            </li>
                        @endforeach
                    </ul>
                </section>
        </section>

        <aside class="h-fit rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900">
            <h2 class="text-base font-semibold text-gray-900 dark:text-white">{{ __('Role details') }}</h2>
            <dl class="mt-5 space-y-4 text-sm">
                <div>
                    <dt class="text-gray-500 dark:text-gray-400">{{ __('Slug') }}</dt>
                    <dd class="mt-1 break-all font-medium text-gray-900 dark:text-white">{{ $role->slug }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500 dark:text-gray-400">{{ __('Default') }}</dt>
                    <dd class="mt-1 font-medium text-gray-900 dark:text-white">{{ $role->is_default ? __('Yes') : __('No') }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500 dark:text-gray-400">{{ __('Users') }}</dt>
                    <dd class="mt-1 font-medium text-gray-900 dark:text-white">{{ $role->users->count() }}</dd>
                </div>
            </dl>
        </aside>
    </div>
@endsection
