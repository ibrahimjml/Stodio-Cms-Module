@extends('admin::layouts.admin')

@section('title', __('Auth & Security Rules'))

@section('content')

    <div class="space-y-6">

                @if (module_enabled('TwoFactor'))
                    <div class="space-y-3">
                        <p class="text-sm font-bold text-gray-700 dark:text-gray-300">{{ __('Two Factor Authentication') }}</p>

                        @include('twofactor::settings.checkbox')
                    </div>
                @endif
    </div>
@endsection
