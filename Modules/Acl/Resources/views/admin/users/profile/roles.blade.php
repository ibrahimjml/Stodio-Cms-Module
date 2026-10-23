 @if ($showRolesTab)
            <div x-show="tab === 'roles'" x-cloak>
                <x-core::form.card :title="__('Roles & privileges')">
                    <x-core::form :action="route('admin.acl.users.update', $user)" method="PUT" class="space-y-5 p-6 sm:p-8">
                        <input type="hidden" name="section" value="roles">
                        <x-core::form.toggle id="toggle_super_user" name="super_user" :label="__('Super user')" :checked="$user->super_user" />
                        @error('super_user')
                            <p class="text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror

                        @if ($roles->isNotEmpty())
                            <x-core::form.multi-select
                                name="roles[]"
                                :label="__('Roles')"
                                :options="$roles->map(fn ($role) => ['id' => $role->getKey(), 'name' => $role->name])->values()->all()"
                                :selected="old('roles', $user->roles->modelKeys())"
                                :placeholder="__('Select roles...')"
                            />
                        @endif

                        <div class="border-t border-gray-200 pt-5 dark:border-gray-800">
                            <x-core::form.submit>{{ __('Save roles') }}</x-core::form.submit>
                        </div>
                    </x-core::form>
                </x-core::form.card>
            </div>
        @endif
