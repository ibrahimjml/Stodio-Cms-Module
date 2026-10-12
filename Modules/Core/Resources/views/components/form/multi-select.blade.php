@props([
    'name',
    'label',
    'options' => [],
    'selected' => [],
    'placeholder' => __('Select options...'),
])

<div>
    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
        {{ $label }}
    </label>

    <div
        x-data="{
            open: false,
            options: @js($options),
            selected: @js(array_values($selected)).map(Number),
            toggleOption(id) {
                id = Number(id);

                if (this.selected.includes(id)) {
                    this.selected = this.selected.filter(selectedId => selectedId !== id);
                } else {
                    this.selected.push(id);
                }
            },
            isSelected(id) {
                return this.selected.includes(Number(id));
            },
            optionName(id) {
                return this.options.find(option => Number(option.id) === Number(id))?.name ?? '';
            }
        }"
        class="relative"
        @click.outside="open = false"
        @keydown.escape.window="open = false"
    >
        <template x-for="id in selected" :key="id">
            <input type="hidden" name="{{ $name }}" :value="id">
        </template>

        <button
            type="button"
            @click="open = !open"
            :aria-expanded="open.toString()"
            class="shadow-theme-xs flex min-h-11 w-full items-center gap-2 rounded-lg border border-gray-300 bg-white px-3 py-2 text-left transition dark:border-gray-700 dark:bg-gray-900"
        >
            <span class="flex flex-1 flex-wrap items-center gap-2">
                <template x-for="id in selected" :key="id">
                    <span class="group flex items-center gap-1 rounded-full border border-gray-200 bg-gray-100 py-1 pr-2 pl-2.5 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-white/90">
                        <span x-text="optionName(id)"></span>
                        <span
                            role="button"
                            tabindex="0"
                            @click.stop="toggleOption(id)"
                            @keydown.enter.stop.prevent="toggleOption(id)"
                            @keydown.space.stop.prevent="toggleOption(id)"
                            class="cursor-pointer text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300"
                            aria-label="{{ __('Remove selected option') }}"
                        >
                            <svg class="h-3.5 w-3.5 fill-current" aria-hidden="true" viewBox="0 0 14 14">
                                <path d="M3.407 4.469a.75.75 0 0 1 1.061-1.061L7 5.94l2.531-2.532a.75.75 0 0 1 1.061 1.061L8.061 7l2.531 2.532a.75.75 0 0 1-1.061 1.06L7 8.061l-2.532 2.53a.75.75 0 0 1-1.06-1.06L5.939 7 3.407 4.469Z" />
                            </svg>
                        </span>
                    </span>
                </template>
                <span x-show="selected.length === 0" class="text-sm text-gray-500 dark:text-gray-400">
                    {{ $placeholder }}
                </span>
            </span>

            <svg class="h-5 w-5 shrink-0 text-gray-500 transition-transform dark:text-gray-400" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7" />
            </svg>
        </button>

        <div
            x-cloak
            x-show="open"
            x-transition
            class="absolute z-50 mt-1 max-h-64 w-full overflow-y-auto rounded-lg border border-gray-200 bg-white shadow-lg dark:border-gray-700 dark:bg-gray-900"
        >
            <template x-for="option in options" :key="option.id">
                <button
                    type="button"
                    @click="toggleOption(option.id)"
                    class="flex w-full items-center justify-between border-b border-gray-100 px-4 py-3 text-left text-sm text-gray-800 transition last:border-b-0 hover:bg-gray-50 dark:border-gray-800 dark:text-white/90 dark:hover:bg-white/5"
                >
                    <span x-text="option.name"></span>
                    <span x-show="isSelected(option.id)" class="text-blue-600 dark:text-blue-400" aria-hidden="true">✓</span>
                </button>
            </template>
            <p x-show="options.length === 0" class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">
                {{ __('No options available.') }}
            </p>
        </div>
    </div>

    @error(str_replace('[]', '', $name))
        <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror
</div>
