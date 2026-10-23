@if ($canShowTwoFactorTab)
    <button type="button" @click="tab = '2fa'"
        :class="tab === '2fa' ? 'bg-gray-900 text-white dark:bg-white dark:text-gray-900' :
            'text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/5'"
        class="rounded-xl px-4 py-2 text-sm font-semibold transition">
        {{ __('Two factor authentication') }}
    </button>
@endif
