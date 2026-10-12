@extends('admin::layouts.admin')

@section('title', __('Create permission'))

@section('content')
    <x-core::form.card :title="__('Create permission')">
        <x-core::form :action="route('admin.acl.permissions.store')" method="POST" class="space-y-4 p-6">
            <x-core::form.field name="name" :label="__('Name')" :placeholder="__('acl.roles.view')" required />
            <x-core::form.field name="module" :label="__('Module')" :placeholder="__('Acl')" required />
            <x-core::form.field name="description" :label="__('Description')" :required="false" />

            <x-core::form.submit>{{ __('Save') }}</x-core::form.submit>
        </x-core::form>
    </x-core::form.card>
@endsection
