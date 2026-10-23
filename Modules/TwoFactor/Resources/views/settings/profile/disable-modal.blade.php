<x-core::ui.modal
    @open-disable-modal.window="open = true"
    @close-disable-modal.window="open = false"
    :isOpen="false"
    class="max-w-[700px] p-6 lg:p-11"
>
    <div x-data="twoFactorDisable({
        endpoint: @js(route('twofactor.profile.disable')),
        errorMessage: @js(__('Unable to disable two-factor authentication. Please try again.')),
        successMessage: @js(__('Two-factor authentication disabled successfully.')),
    })"
        @open-disable-modal.window="resetDisable()">
        <div class="mb-8 text-center sm:text-start">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                {{ __('Disable two-factor authentication') }}
            </h2>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                {{ __('Confirm your identity before turning off two-factor authentication for this account.') }}
            </p>
        </div>

        <div
            class="rounded-2xl border border-gray-200 bg-gray-50 p-6 text-center dark:border-gray-800 dark:bg-white/[0.03]">
            <div
                class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-red-50 text-red-500 dark:bg-red-500/10 dark:text-red-400">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 3L4.5 6V12C4.5 16.5 7.5 20.25 12 21C16.5 20.25 19.5 16.5 19.5 12V6L12 3Z"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M9.5 9.5L14.5 14.5M14.5 9.5L9.5 14.5" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>

            <h3 class="mt-4 text-base font-semibold text-gray-900 dark:text-white">
                {{ __('Confirm your code') }}
            </h3>
            <p class="mx-auto mt-2 max-w-md text-sm text-gray-500 dark:text-gray-400">
                {{ __('Enter the 6-digit code shown in your authenticator app to turn off two-factor authentication.') }}
            </p>

            <div class="mt-6">
                <label for="two-factor-disable-code" class="sr-only">{{ __('Authentication code') }}</label>
                <input id="two-factor-disable-code" type="text" inputmode="numeric" autocomplete="one-time-code"
                    maxlength="6" x-model="code" @input="sanitizeCode($event)" :disabled="loading || success"
                    :class="error
                        ?
                        'border-red-300 focus:border-red-400 focus:ring-red-500/20 dark:border-red-500/50' :
                        'border-gray-300 focus:border-brand-500 focus:ring-brand-500/20 dark:border-gray-700'"
                    class="mx-auto block w-full max-w-[220px] rounded-xl border bg-white px-4 py-3 text-center text-2xl font-semibold tracking-[0.5em] text-gray-900 outline-none transition focus:ring-2 disabled:cursor-not-allowed disabled:opacity-60 dark:bg-gray-900 dark:text-white"
                    placeholder="000000" />
                <p x-show="error" x-text="error" class="mt-3 text-sm text-red-500"></p>
                <p x-show="success" class="mt-3 text-sm font-medium text-green-500">
                    {{ __('Two-factor authentication disabled successfully.') }}
                </p>
            </div>
        </div>

        <div class="mt-8 flex items-center justify-between gap-3">
            <x-core::ui.button type="button" variant="outline" @click="$dispatch('close-disable-modal')"
                x-bind:disabled="loading || success">
                {{ __('Cancel') }}
            </x-core::ui.button>

            <x-core::ui.button type="button" @click="disable()" x-bind:disabled="!canDisable"
                x-bind:class="{ 'cursor-not-allowed opacity-50': !canDisable }">
                <template x-if="loading">
                    <x-core::ui.spinner class="h-5 w-5 animate-spin text-white/40 fill-white" />
                </template>
                <span x-show="!loading">{{ __('Turn Off') }}</span>
            </x-core::ui.button>
        </div>
    </div>
</x-core::ui.modal>
