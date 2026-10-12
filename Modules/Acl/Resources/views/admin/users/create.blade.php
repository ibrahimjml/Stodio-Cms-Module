@extends('admin::layouts.admin')

@section('title', __('Create user'))

@section('content')
    <x-core::form.card :title="__('Create user')">
        <x-core::form :action="route('admin.acl.users.store')" method="POST" class="space-y-5 p-6 sm:p-8">
            <x-core::form.field name="first_name" :label="__('First name')" :placeholder="__('John')" required />
            <x-core::form.field name="last_name" :label="__('Last name')" :placeholder="__('Doe')" required />
            <x-core::form.field name="username" :label="__('Username')" :placeholder="__('johndoe')" required />
            <x-core::form.field name="email" type="email" :label="__('Email')" :placeholder="__('john@example.com')" required />
            <x-core::form.field name="password" type="password" :label="__('Password')" required />

            <div class="space-y-5 border-t border-gray-200 pt-5 dark:border-gray-800">
                <x-core::form.toggle id="toggle_super_user" name="super_user" :label="__('Super user')" :checked="false" />

                @if ($roles->isNotEmpty())
                    <x-core::form.multi-select
                        name="roles[]"
                        :label="__('Roles')"
                        :options="$roles->map(fn ($role) => ['id' => $role->getKey(), 'name' => $role->name])->values()->all()"
                        :selected="old('roles', [])"
                        :placeholder="__('Select roles...')"
                    />
                @endif
            </div>

            <div class="border-t border-gray-200 pt-5 dark:border-gray-800">
                <x-core::form.submit>{{ __('Save') }}</x-core::form.submit>
            </div>
        </x-core::form>
    </x-core::form.card>
@endsection
