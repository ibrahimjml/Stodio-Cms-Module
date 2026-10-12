@extends('admin::layouts.admin')

@section('title', __('Create role'))

@section('content')
    <x-core::form.card :title="__('Create role')">
        <x-core::form :action="route('admin.acl.roles.store')" method="POST" class="space-y-4 p-6">
            <x-core::form.field name="name" :label="__('Name')" :placeholder="__('Editor')" required />

            <x-core::form.checkbox name="is_default" value="1" :label="__('Default role')" :checked="false" />

            @if ($permissions->isNotEmpty())
                <div class="space-y-4">
                    <p class="text-sm font-bold text-gray-700">{{ __('Permissions') }}</p>
                    @foreach ($permissions as $module => $modulePermissions)
                        <fieldset class="rounded-2xl border border-gray-200 p-4">
                            <legend class="px-2 text-sm font-bold text-gray-700">{{ $module }}</legend>
                            <div class="grid gap-2 sm:grid-cols-2">
                                @foreach ($modulePermissions as $permission)
                                    <label class="flex items-center gap-2 text-sm text-gray-700">
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->getKey() }}" @checked(in_array($permission->getKey(), old('permissions', []))) class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        {{ $permission->name }}
                                    </label>
                                @endforeach
                            </div>
                        </fieldset>
                    @endforeach
                </div>
            @endif

            <x-core::form.submit>{{ __('Save') }}</x-core::form.submit>
        </x-core::form>
    </x-core::form.card>
@endsection
