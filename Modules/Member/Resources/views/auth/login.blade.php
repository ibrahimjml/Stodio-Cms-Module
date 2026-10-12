@extends('core::layouts.guest')
@push('vite')
  @vite(['Modules/Member/Resources/assets/js/login.js'])
@endpush
@section('content')
  <main class="w-full mx-auto max-w-md sm:max-w-lg px-4 mt-5 mb-20 sm:mt-10">



    <x-core::form.card title="Login">

      <x-core::form id="recaptcha" 
                    :action="route('auth.login.post')" 
                    x-data="loginForm" 
                    @submit.prevent="submit"
                    class="w-full border border-transparent px-4 py-6 space-y-6 sm:px-10 sm:space-y-5"
                    >
        <x-core::form.field name="login" label="Username or Email" />

        <x-core::form.field name="password" label="Password:" type="password" />

        <x-core::form.checkbox name="remember" label="Remember Me" />

        <div class="flex flex-col gap-4">
          <x-core::form.submit x-bind:disabled="loading">
            
            <template x-if="!loading">
              <span>Login</span>
            </template>

            <template x-if="loading">
              <div role="status" class="flex items-center justify-center w-5 h-6 mx-auto">
                <x-core::ui.spinner class="w-5 h-5 text-gray-200 animate-spin fill-blue-600" />
              </div>
            </template>

          </x-core::form.submit>
          {{-- <a class="text-gray-500 hover:text-blue-700 no-underline hover:underline"
            href="{{ route('forgot.password') }}">
            Forgot your password?
          </a> --}}

          <p class="w-full text-xs text-center text-gray-700 my-6 sm:text-sm sm:my-8">
            {{ __('Dont have an account?') }}
            <a class="text-gray-500 hover:text-blue-700 no-underline hover:underline"
              href="{{ route('auth.register.index') }}">
              Register
            </a>
          </p>
        </div>
      </x-core::form>

    </x-core::form.card>


    @if(config('member.user.enabled'))
      <div class="mt-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4" role="alert">
        <p class="font-bold">Admin Credentials</p>
        <p>Username: <span class="font-mono">{{ config('member.user.admin.username') }}</span></p>
        <p>Pass: <span class="font-mono">{{ config('member.user.admin.password') }}</span></p>
      </div>
      <div class="mt-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4" role="alert">
        <p class="font-bold">User Credentials</p>
        <p>Username: <span class="font-mono">{{ config('member.user.user.username') }}</span></p>
        <p>Pass: <span class="font-mono">{{ config('member.user.user.password') }}</span></p>
      </div>

    @endif
  </main>

@endsection