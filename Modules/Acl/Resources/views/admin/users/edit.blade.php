@extends('admin::layouts.admin')

@section('title', __('Edit user'))

@section('content')
    <x-core::form.card :title="__('Edit user :name', ['name' => $user->name])">
        <x-core::form :action="route('admin.acl.users.update', $user)" method="PUT" class="space-y-5 p-6 sm:p-8">
            <x-core::form.field name="first_name" :label="__('First name')" :value="$user->first_name" required />
            <x-core::form.field name="last_name" :label="__('Last name')" :value="$user->last_name" required />
            <x-core::form.field name="username" :label="__('Username')" :value="$user->username" required />
            <x-core::form.field name="email" type="email" :label="__('Email')" :value="$user->email" required />
            <x-core::form.field name="password" type="password" :label="__('Password')" :placeholder="__('password')" :required="false" />

            @can('update', $user)
                <div class="space-y-5 border-t border-gray-200 pt-5 dark:border-gray-800">
                    <x-core::form.toggle id="toggle_super_user" name="super_user" :label="__('Super user')" :checked="$user->super_user" />

                    @if ($roles->isNotEmpty())
                        <x-core::form.multi-select
                            name="roles[]"
                            :label="__('Roles')"
                            :options="$roles->map(fn ($role) => ['id' => $role->getKey(), 'name' => $role->name])->values()->all()"
                            :selected="old('roles', $user->roles->modelKeys())"
                            :placeholder="__('Select roles...')"
                        />
                    @endif
                </div>

                <div class="border-t border-gray-200 pt-5 dark:border-gray-800">
                    <x-core::form.submit>{{ __('Update') }}</x-core::form.submit>
                </div>
            @endcan
        </x-core::form>
    </x-core::form.card>
@endsection
