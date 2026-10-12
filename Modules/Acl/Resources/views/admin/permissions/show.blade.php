@extends('admin::layouts.admin')

@section('title', $permission->name)

@section('content')
    <x-core::form.card :title="$permission->name">
        <div class="space-y-2 p-6 text-sm text-gray-700">
            <p><strong>{{ __('Slug') }}:</strong> {{ $permission->slug }}</p>
            <p><strong>{{ __('Module') }}:</strong> {{ $permission->module }}</p>
            <p><strong>{{ __('Description') }}:</strong> {{ $permission->description ?? '—' }}</p>
            <div>
                <p class="font-bold">{{ __('Roles') }}</p>
                <ul class="list-disc ltr:ml-5 rtl:mr-5">
                    @forelse ($permission->roles as $role)
                        <li>{{ $role->name }}</li>
                    @empty
                        <li>{{ __('No roles assigned.') }}</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </x-core::form.card>
@endsection
