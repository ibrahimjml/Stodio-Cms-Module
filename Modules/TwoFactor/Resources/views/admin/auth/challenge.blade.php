@extends('core::layouts.guest')

@push('vite')
    @moduleVite('TwoFactor')
@endpush

@section('content')
    <main class="w-full mx-auto max-w-md sm:max-w-lg px-4 mt-5 mb-20 sm:mt-10">

        <x-core::form.card :title="__('Two-Factor Verification')">

            <div class="px-5 py-8 sm:px-8 sm:py-10">
                <div class="flex flex-col items-center text-center">
                    <div
                        class="flex h-14 w-14 items-center justify-center rounded-full bg-brand-50 text-brand-500 dark:bg-brand-500/10 dark:text-brand-400">
                        <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 3L4.5 6V12C4.5 16.5 7.5 20.25 12 21C16.5 20.25 19.5 16.5 19.5 12V6L12 3Z"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M9 12.5L11 14.5L15.5 10" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>

                    <h1 class="mt-5 text-xl font-semibold text-gray-900 dark:text-white">
                        {{ __('Enter your authentication code') }}
                    </h1>
                    <p class="mt-2 max-w-sm text-sm text-gray-500 dark:text-gray-400">
                        {{ __('Open your authenticator app and enter the 6-digit code for your account.') }}
                    </p>
                </div>

                <div x-data="twoFactorChallenge({
                    endpoint: @js(route('twofactor.challenge.check')),
                    errorMessage: @js(__('Unable to verify the authentication code. Please try again.')),
                    successMessage: @js(__('Logged in successfully.')),
                })">
                    <x-core::form :action="route('twofactor.challenge.check')" method="POST"
                        @submit.prevent="confirm()" class="mt-8 space-y-5">
                        <div class="w-full text-center">
                            <label for="code" class="sr-only">{{ __('Authentication code') }}</label>
                            <input id="code" name="code" type="text" inputmode="numeric" autocomplete="one-time-code"
                                maxlength="6" x-model="code" @input="sanitizeCode($event)" :disabled="confirming"
                                :class="error
                                    ?
                                    'border-red-300 focus:border-red-400 focus:ring-red-500/20 dark:border-red-500/50' :
                                    'border-gray-300 focus:border-brand-500 focus:ring-brand-500/20 dark:border-gray-700'"
                                class="mx-auto block w-full rounded-xl border bg-white px-4 py-3 text-center text-2xl font-semibold tracking-[0.5em] text-gray-900 outline-none transition focus:ring-2 disabled:cursor-not-allowed disabled:opacity-60 dark:bg-gray-900 dark:text-white"
                                placeholder="000000" autofocus />

                            <p x-show="error" x-text="error" x-cloak class="mt-3 text-sm text-red-500"></p>
                        </div>

                        <x-core::ui.button type="submit" variant="black" class="w-full"
                            x-bind:disabled="!canConfirm"
                            x-bind:class="{ 'cursor-not-allowed opacity-50': !canConfirm }">
                            <template x-if="confirming">
                                <x-core::ui.spinner class="h-5 w-5 animate-spin text-white/40 fill-white" />
                            </template>
                            <span x-show="!confirming">{{ __('Verify') }}</span>
                        </x-core::ui.button>

                        <details
                            class="rounded-xl border border-gray-200 bg-gray-50 p-4 dark:border-gray-800 dark:bg-white/[0.03]">
                            <summary class="cursor-pointer text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Lost access to your authenticator app?') }}
                            </summary>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('Enter one of the recovery codes you saved when you enabled two-factor authentication.') }}
                            </p>

                            <div class="mt-3">
                                <x-core::form.field name="recovery_code" :label="__('Recovery code')" :required="false"
                                    x-model.trim="recoveryCode" x-bind:disabled="confirming"
                                    @keydown.enter.prevent="confirm()" />
                            </div>
                        </details>
                    </x-core::form>
                </div>

                <p class="mt-6 text-center text-sm text-gray-500 dark:text-gray-400">
                    <a href="{{ route('admin.login') }}"
                        class="font-medium text-brand-500 transition hover:text-brand-600 dark:text-brand-400">
                        {{ __('Back to login') }}
                    </a>
                </p>
            </div>

        </x-core::form.card>
    </main>
@endsection
