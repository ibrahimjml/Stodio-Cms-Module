@extends('core::layouts.guest')

@section('content')
<main class="w-full mx-auto max-w-md sm:max-w-lg px-4 mt-5 mb-20 sm:mt-10">
  <div class="flex">
    <div class="w-full">

      <x-core::form.card title="Register">

        <x-core::form :action="route('auth.register.post')" id="registerForm"
          class="w-full px-4 py-6 space-y-6 sm:px-10 sm:space-y-5 h-fit">
          <x-core::form.field name="name" label="Name:" autocomplete="name" autofocus />

          <x-core::form.field name="username" label="Username:" autocomplete="username" autofocus />

          <x-core::form.field name="email" label="E-Mail Address:" type="email"
            placeholder="e.g. gmail.com, mail.ru" autocomplete="email" />

          <x-core::form.field name="phone" label="Phone:" type="tel" autocomplete="tel" />

          <x-core::form.field name="password" label="Password:" type="password" autocomplete="new-password" />

          <x-core::form.field name="password_confirmation" label="Confirm Password:" type="password"
            autocomplete="new-password" :required="true" />

          
          <div class="flex flex-wrap">
            <x-core::form.submit>
              Register
            </x-core::form.submit>

            <p class="w-full text-xs text-center text-gray-700 my-3 sm:text-sm sm:my-8">
              Already have an account?
              <a class="text-gray-500 hover:text-blue-700 no-underline hover:underline" href="{{ route('auth.login.index') }}">
                Login
              </a>
            </p>
          </div>
        </x-core::form>

      </x-core::form.card>
    </div>
  </div>
</main>
@endsection
