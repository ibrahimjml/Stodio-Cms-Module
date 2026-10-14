@extends('admin::layouts.admin')

@section('title', __('User profile'))

@php
    $initialTab = old('section', request()->query('tab', 'profile'));
    $showRolesTab = ($canManageSupers ?? false) && auth()->user()?->isSuperUser();
    if ($initialTab === 'roles' && ! $showRolesTab) {
        $initialTab = 'profile';
    }
@endphp

@section('content')
    <div class="mx-auto max-w-4xl" x-data="{ tab: @js($initialTab) }">
        <div class="mb-6 flex items-center gap-4">
            <img src="{{ $user->image_url }}" alt="{{ $user->name }}"
                class="h-16 w-16 rounded-2xl border border-gray-200 object-cover dark:border-gray-700">
            <div>
                <h1 class="text-xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }} · {{ '@'.$user->username }}</p>
            </div>
            <a href="{{ route('admin.acl.users.index') }}"
                class="ms-auto rounded-xl border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-white/5">
                {{ __('Back') }}
            </a>
        </div>
         <!-- Tabs -->
         @include('acl::admin.users.profile.tabs')

         <!-- Profile tab -->
         @include('acl::admin.users.profile.profile')
         <!-- Password tab -->
         @include('acl::admin.users.profile.password')
         <!-- Avatar tab -->
         @include('acl::admin.users.profile.avatar')
         <!-- Roles tab -->
         @include('acl::admin.users.profile.roles')
@endsection
