@extends('admin::layouts.admin')

@section('title', __('Edit permission'))

@section('content')
    <x-core::form.card :title="__('Edit permission :name', ['name' => $permission->name])">
        <x-core::form :action="route('admin.acl.permissions.update', $permission)" method="PUT" class="space-y-4 p-6">
            <x-core::form.field name="name" :label="__('Name')" :value="$permission->name" required />
            <x-core::form.field name="module" :label="__('Module')" :value="$permission->module" required />
            <x-core::form.field name="description" :label="__('Description')" :value="$permission->description" :required="false" />

            <x-core::form.submit>{{ __('Update') }}</x-core::form.submit>
        </x-core::form>
    </x-core::form.card>
@endsection
