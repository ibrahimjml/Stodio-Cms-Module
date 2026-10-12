@extends('admin::layouts.admin')

@section('content')
    <!-- stats cards -->
    <div class="grid lg:grid-cols-4 gap-4 grid-cols-2 ">
      <x-admin::stats.metrics name="Users" :href="route('admin.acl.users.index')" :svg="@svg('o-users')" :count="$users" />
      <x-admin::stats.metrics name="Members" :href="route('admin.members.page')" :svg="@svg('o-members')" :count="$members" />
      <x-admin::stats.metrics name="Modules" :href="route('admin.modules.index')" :svg="@svg('o-authentication')" :count="$modules" />
      <x-admin::stats.metrics name="Roles" :href="route('admin.acl.roles.index')" :svg="@svg('o-acl')" :count="$roles" />
      <x-admin::stats.metrics name="Permissions" :href="route('admin.acl.permissions.index')" :svg="@svg('o-permission')" :count="$permissions" />
    </div>

    <!-- recent activity logs-->
    @can('auditlog.view')
    @if(module_enabled('Auditlog'))
        <x-admin::stats.recent-logs :auditLogs="$auditLogs" />
    @endif
    @endcan
@endsection
