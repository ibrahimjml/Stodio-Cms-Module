@extends('core::layouts.guest')
@push('vite')
  @vite('Modules/Acl/Resources/assets/js/login.js')
@endpush
@section('content')
  <main class="w-full mx-auto max-w-md sm:max-w-lg px-4 mt-5 mb-20 sm:mt-10">

    <x-core::form.card title="Admin Login">

      <x-core::form id="recaptcha" 
                    :action="route('admin.login.post')" 
                    x-data="adminLoginForm" 
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

        </div>
      </x-core::form>

    </x-core::form.card>
  </main>

@endsection