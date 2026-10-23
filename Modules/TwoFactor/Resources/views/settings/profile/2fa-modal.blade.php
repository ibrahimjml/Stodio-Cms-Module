<x-core::ui.modal
    @open-2fa-modal.window="open = true"
    @close-2fa-modal.window="open = false"
    :isOpen="false"
    class="max-w-[700px] p-6 lg:p-11"
>
    <div x-data="twoFactorWizard({
        endpoint: @js(route('twofactor.profile.qrcode')),
        totalSteps: 3,
        errorMessage: @js(__('Unable to load the QR code. Please try again.')),
        enable: {
            endpoint: @js(route('twofactor.profile.enable')),
            errorMessage: @js(__('Unable to enable two-factor authentication. Please try again.')),
            successMessage: @js(__('Two-factor authentication enabled successfully.')),
        },
    })"
        @open-2fa-modal.window="start()" class="px-1">

        <div class="mb-8 text-center sm:text-start">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                {{ __('Set up two-factor authentication') }}
            </h2>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                {{ __('Protect your account with a one-time code from an authenticator app.') }}
            </p>
        </div>
         <!-- steps list title-->
        @include('twofactor::settings.profile.partials.steps-list')

        <div x-show="step === 1" x-cloak x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                <h3 class="text-sm font-semibold text-gray-900 dark:text-white">
                    {{ __('Before you begin') }}
                </h3>

                <ol class="mt-4 space-y-4">
                    <li class="flex gap-3">
                        <span
                            class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-white text-xs font-semibold text-gray-600 ring-1 ring-inset ring-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:ring-gray-700">
                            1
                        </span>
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ __('Install an authenticator app') }}
                            </p>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('Use Google Authenticator, Microsoft Authenticator, Authy, or 1Password on your phone.') }}
                            </p>
                        </div>
                    </li>

                    <li class="flex gap-3">
                        <span
                            class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-white text-xs font-semibold text-gray-600 ring-1 ring-inset ring-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:ring-gray-700">
                            2
                        </span>
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ __('Scan the QR code') }}
                            </p>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('In the next step, scan the code with your authenticator app or enter the setup key manually.') }}
                            </p>
                        </div>
                    </li>

                    <li class="flex gap-3">
                        <span
                            class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-white text-xs font-semibold text-gray-600 ring-1 ring-inset ring-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:ring-gray-700">
                            3
                        </span>
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ __('Keep the code safe') }}
                            </p>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('Store your recovery codes in a safe place. You will need them if you lose access to your phone.') }}
                            </p>
                        </div>
                    </li>
                </ol>
            </div>

            <div class="mt-8 flex justify-end">
                <x-core::ui.button type="button" @click="nextStep()">
                    {{ __('Continue') }}
                    <span class="flex items-center">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 12H19M19 12L13 6M19 12L13 18" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                </x-core::ui.button>
            </div>
        </div>

        <div x-show="step === 2" x-cloak x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
            <div class="flex flex-col items-center">
                <div
                    class="relative flex min-h-[260px] w-full max-w-[300px] items-center justify-center rounded-2xl border border-dashed border-gray-300 bg-white p-5 dark:border-gray-700 dark:bg-gray-900">
                    <template x-if="loading">
                        <div role="status" class="flex flex-col items-center gap-3">
                            <x-core::ui.spinner class="h-8 w-8 animate-spin text-gray-200 fill-brand-500" />
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ __('Generating your QR code...') }}
                            </p>
                        </div>
                    </template>

                    <template x-if="!loading && error">
                        <div class="flex flex-col items-center gap-3 text-center">
                            <span
                                class="flex h-10 w-10 items-center justify-center rounded-full bg-red-50 text-red-500 dark:bg-red-500/10">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 9V13M12 17H12.01M10.29 3.86L1.82 18A2 2 0 003.53 21H20.47A2 2 0 0022.18 18L13.71 3.86A2 2 0 0010.29 3.86Z"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </span>
                            <p class="text-sm text-gray-500 dark:text-gray-400" x-text="error"></p>
                            <x-core::ui.button type="button" size="sm" @click="loadQrCode()">
                                {{ __('Retry') }}
                            </x-core::ui.button>
                        </div>
                    </template>

                    <template x-if="!loading && !error && qrCode">
                        <img :src="qrCode" alt="{{ __('Two-factor authentication QR code') }}"
                            class="h-[220px] w-[220px] rounded-xl bg-white" />
                    </template>
                </div>

                <p class="mt-4 text-center text-sm text-gray-500 dark:text-gray-400">
                    {{ __('Scan this code with your authenticator app to add your account.') }}
                </p>

                <div x-show="!loading && !error && secret"
                    class="mt-4 w-full rounded-xl border border-gray-200 bg-gray-50 p-4 dark:border-gray-800 dark:bg-white/[0.03]">
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400">
                        {{ __('Can not scan the code? Enter this setup key manually:') }}
                    </p>
                    <code x-text="secret"
                        class="mt-2 block break-all rounded-lg bg-white px-3 py-2 font-mono text-sm text-gray-900 ring-1 ring-inset ring-gray-200 dark:bg-gray-900 dark:text-gray-100 dark:ring-gray-700"></code>
                </div>
            </div>

            <div class="mt-8 flex items-center justify-between gap-3">
                <x-core::ui.button type="button" variant="outline" @click="previousStep()">
                    <span class="flex items-center">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19 12H5M5 12L11 6M5 12L11 18" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                    {{ __('Back') }}
                </x-core::ui.button>

                <x-core::ui.button type="button" variant="outline" @click="nextStep()">
                    {{ __('Next') }}
                </x-core::ui.button>
            </div>
        </div>

        <div x-show="step === 3" x-cloak x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
            <div
                class="rounded-2xl border border-gray-200 bg-gray-50 p-6 text-center dark:border-gray-800 dark:bg-white/[0.03]">
                <div
                    class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-brand-50 text-brand-500 dark:bg-brand-500/10 dark:text-brand-400">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 12.75L11.25 15L15 9.75M12 3L4.5 6V12C4.5 16.5 7.5 20.25 12 21C16.5 20.25 19.5 16.5 19.5 12V6L12 3Z"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>

                <h3 class="mt-4 text-base font-semibold text-gray-900 dark:text-white">
                    {{ __('Confirm your code') }}
                </h3>
                <p class="mx-auto mt-2 max-w-md text-sm text-gray-500 dark:text-gray-400">
                    {{ __('Enter the 6-digit code shown in your authenticator app to finish enabling two-factor authentication.') }}
                </p>

                <div class="mt-6">
                    <label for="two-factor-code" class="sr-only">{{ __('Authentication code') }}</label>
                    <input id="two-factor-code" type="text" inputmode="numeric" autocomplete="one-time-code"
                        maxlength="6" x-model="code" @input="sanitizeCode($event)"
                        :disabled="confirming || success"
                        :class="confirmError
                            ?
                            'border-red-300 focus:border-red-400 focus:ring-red-500/20 dark:border-red-500/50' :
                            'border-gray-300 focus:border-brand-500 focus:ring-brand-500/20 dark:border-gray-700'"
                        class="mx-auto block w-full max-w-[220px] rounded-xl border bg-white px-4 py-3 text-center text-2xl font-semibold tracking-[0.5em] text-gray-900 outline-none transition focus:ring-2 disabled:cursor-not-allowed disabled:opacity-60 dark:bg-gray-900 dark:text-white"
                        placeholder="000000" />
                    <p x-show="confirmError" x-text="confirmError" class="mt-3 text-sm text-red-500"></p>
                    <p x-show="success" class="mt-3 text-sm font-medium text-green-500">
                        {{ __('Two-factor authentication enabled successfully.') }}
                    </p>
                </div>
            </div>

            <div class="mt-8 flex items-center justify-between gap-3">
                <x-core::ui.button type="button" variant="outline" @click="previousStep()"
                    x-bind:disabled="confirming || success">
                    <span class="flex items-center">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19 12H5M5 12L11 6M5 12L11 18" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                    {{ __('Back') }}
                </x-core::ui.button>

                <x-core::ui.button type="button" @click="confirm()" x-bind:disabled="!canConfirm"
                    x-bind:class="{ 'cursor-not-allowed opacity-50': !canConfirm }">
                    <template x-if="confirming">
                        <x-core::ui.spinner class="h-5 w-5 animate-spin text-white/40 fill-white" />
                    </template>
                    <span x-show="!confirming">{{ __('Confirm') }}</span>
                </x-core::ui.button>
            </div>
        </div>
    </div>
</x-core::ui.modal>
