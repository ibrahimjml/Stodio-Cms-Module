<div x-show="tab === 'profile'" x-cloak>
            <x-core::form.card :title="__('Profile information')">
                <x-core::form :action="route('admin.acl.users.update', $user)" method="PUT" class="space-y-5 p-6 sm:p-8">
                    <input type="hidden" name="section" value="profile">
                    <x-core::form.field name="first_name" :label="__('First name')" :value="$user->first_name" required />
                    @error('first_name')
                        <p class="text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <x-core::form.field name="last_name" :label="__('Last name')" :value="$user->last_name" required />
                    @error('last_name')
                        <p class="text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <x-core::form.field name="username" :label="__('Username')" :value="$user->username" required />
                    @error('username')
                        <p class="text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <x-core::form.field name="email" type="email" :label="__('Email')" :value="$user->email" required />
                    @error('email')
                        <p class="text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <div class="border-t border-gray-200 pt-5 dark:border-gray-800">
                        <x-core::form.submit>{{ __('Save profile') }}</x-core::form.submit>
                    </div>
                </x-core::form>
            </x-core::form.card>
        </div>