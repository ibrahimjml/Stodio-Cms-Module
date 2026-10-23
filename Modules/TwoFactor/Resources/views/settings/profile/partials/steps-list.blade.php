        <ol class="mb-8 flex w-full items-center">
            <li class="flex items-center gap-3">
                <span
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full border-2 text-sm font-semibold transition-colors duration-200"
                    :class="step === 1
                        ? 'border-brand-500 bg-brand-500 text-white'
                        : (step > 1
                            ? 'border-brand-500 bg-brand-50 text-brand-500 dark:bg-brand-500/10 dark:text-brand-400'
                            : 'border-gray-200 bg-white text-gray-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-400')">
                    1
                </span>
                <span class="text-xs font-medium transition-colors duration-200 sm:text-sm"
                    :class="step === 1 ? 'text-gray-900 dark:text-white' : 'text-gray-500 dark:text-gray-400'">
                    {{ __('Instructions') }}
                </span>
            </li>

            <li class="mx-3 flex-1 border-t-2 border-dotted transition-colors duration-200"
                :class="step >= 2 ? 'border-brand-500' : 'border-gray-300 dark:border-gray-700'"
                aria-hidden="true"></li>

            <li class="flex items-center gap-3">
                <span
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full border-2 text-sm font-semibold transition-colors duration-200"
                    :class="step === 2
                        ? 'border-brand-500 bg-brand-500 text-white'
                        : (step > 2
                            ? 'border-brand-500 bg-brand-50 text-brand-500 dark:bg-brand-500/10 dark:text-brand-400'
                            : 'border-gray-200 bg-white text-gray-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-400')">
                    2
                </span>
                <span class="text-xs font-medium transition-colors duration-200 sm:text-sm"
                    :class="step === 2 ? 'text-gray-900 dark:text-white' : 'text-gray-500 dark:text-gray-400'">
                    {{ __('Scan QR code') }}
                </span>
            </li>

            <li class="mx-3 flex-1 border-t-2 border-dotted transition-colors duration-200"
                :class="step >= 3 ? 'border-brand-500' : 'border-gray-300 dark:border-gray-700'"
                aria-hidden="true"></li>

            <li class="flex items-center gap-3">
                <span
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full border-2 text-sm font-semibold transition-colors duration-200"
                    :class="step === 3
                        ? 'border-brand-500 bg-brand-500 text-white'
                        : 'border-gray-200 bg-white text-gray-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-400'">
                    3
                </span>
                <span class="text-xs font-medium transition-colors duration-200 sm:text-sm"
                    :class="step === 3 ? 'text-gray-900 dark:text-white' : 'text-gray-500 dark:text-gray-400'">
                    {{ __('Confirmation') }}
                </span>
            </li>
        </ol>