<div x-show="tab === 'password'" x-cloak>
            <x-core::form.card :title="__('Change password')">
                <x-core::form :action="route('admin.acl.users.update', $user)" method="PUT" class="space-y-5 p-6 sm:p-8">
                    <input type="hidden" name="section" value="password">
                    <x-core::form.field name="current_password" type="password" :label="__('Current password')" autocomplete="current-password" required />
                    @error('current_password')
                        <p class="text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <x-core::form.field name="password" type="password" :label="__('New password')" autocomplete="new-password" required />
                    @error('password')
                        <p class="text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <x-core::form.field name="password_confirmation" type="password" :label="__('Confirm new password')" autocomplete="new-password" required />
                    <div class="border-t border-gray-200 pt-5 dark:border-gray-800">
                        <x-core::form.submit>{{ __('Update password') }}</x-core::form.submit>
                    </div>
                </x-core::form>
            </x-core::form.card>
        </div>