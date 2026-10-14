<div
    class="mb-6 flex flex-wrap gap-2 rounded-2xl border border-gray-200 bg-white p-2 dark:border-gray-800 dark:bg-gray-900">
    <button type="button" @click="tab = 'profile'"
        :class="tab === 'profile' ? 'bg-gray-900 text-white dark:bg-white dark:text-gray-900' :
            'text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/5'"
        class="rounded-xl px-4 py-2 text-sm font-semibold transition">
        {{ __('Profile') }}
    </button>
    <button type="button" @click="tab = 'password'"
        :class="tab === 'password' ? 'bg-gray-900 text-white dark:bg-white dark:text-gray-900' :
            'text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/5'"
        class="rounded-xl px-4 py-2 text-sm font-semibold transition">
        {{ __('Password') }}
    </button>
    <button type="button" @click="tab = 'avatar'"
        :class="tab === 'avatar' ? 'bg-gray-900 text-white dark:bg-white dark:text-gray-900' :
            'text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/5'"
        class="rounded-xl px-4 py-2 text-sm font-semibold transition">
        {{ __('Avatar') }}
    </button>
    @if ($showRolesTab)
        <button type="button" @click="tab = 'roles'"
            :class="tab === 'roles' ? 'bg-gray-900 text-white dark:bg-white dark:text-gray-900' :
                'text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/5'"
            class="rounded-xl px-4 py-2 text-sm font-semibold transition">
            {{ __('Roles') }}
        </button>
    @endif
</div>
