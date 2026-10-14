 <div x-show="tab === 'avatar'" x-cloak>
            <x-core::form.card :title="__('Avatar')">
                <x-core::form :action="route('admin.acl.users.update', $user)" method="PUT" enctype="multipart/form-data" class="space-y-5 p-6 sm:p-8">
                    <input type="hidden" name="section" value="avatar">
                    <div class="flex items-center gap-4">
                        <div class="relative">
                            <img src="{{ $user->image_url }}" alt="{{ $user->name }}"
                                class="h-20 w-20 rounded-2xl border border-gray-200 object-cover dark:border-gray-700">
                             <!-- trash icon button referenced form id=avatarform -->   
                            @if ($user->avatar !== \Modules\Core\Enums\UserImage::AVATAR->value)
                                    <button form="avatarform" type="submit" title="{{ __('Delete avatar') }}"
                                        class="absolute -top-2 -right-2 h-7 w-7 text-xs items-center justify-center rounded-full border border-red-200 bg-white text-red-600 shadow-sm transition hover:bg-red-50 hover:text-red-700 dark:border-red-500/30 dark:bg-gray-900 dark:text-red-400 dark:hover:bg-red-500/10">
                                        @svg('o-trash')
                                    </button>
                                
                            @endif
                        </div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            {{ __('Allowed jpg, jpeg, png, webp.') }}
                        </div>
                    </div>
                    <div>
                        <label for="avatar" class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            {{ __('New avatar') }}
                        </label>
                        <input id="avatar" type="file" name="avatar" accept="image/jpeg,image/png,image/webp"
                            class="w-full rounded-xl border border-gray-300 bg-white p-3 text-sm text-gray-900 file:me-3 file:rounded-lg file:border-0 file:bg-gray-900 file:px-3 file:py-2 file:text-sm file:font-semibold file:text-white dark:border-gray-700 dark:bg-gray-950 dark:text-white">
                        @error('avatar')
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="border-t border-gray-200 pt-5 dark:border-gray-800">
                        <x-core::form.submit>{{ __('Upload avatar') }}</x-core::form.submit>
                    </div>
                </x-core::form>
                <!-- start::avatar form -->
                <x-core::form id="avatarform" method="DELETE" :action="route('admin.acl.users.avatar.destroy', $user)"
                        class="absolute -top-2 -right-2"
                            onsubmit="return confirm(@js(__('Delete this avatar?')))">
                </x-core::form><!-- end::avatar form -->
            </x-core::form.card>
        </div>