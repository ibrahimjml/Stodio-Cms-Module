@props([
  'label' => __('Default'),
  'name' => null,
  'id' => 'toggle1',
  'checked' => false,

])

<div class="items-center gap-6 sm:gap-8">
  <div x-data="{ switcherToggle: @js((bool) old($name, $checked)) }">
    <label for="{{ $id }}"
      class="flex cursor-pointer items-center gap-3 text-sm font-medium text-gray-700 select-none dark:text-gray-300">
      <div class="relative">
        <input type="checkbox" id="{{ $id }}" name="{{ $name }}" value="1" class="sr-only" x-model="switcherToggle" />
        <div class="block h-6 w-11 rounded-full"
          :class="switcherToggle ? 'bg-brand-500 dark:bg-brand-500' : 'bg-gray-200 dark:bg-white/10'">
        </div>
        <div :class="switcherToggle ? 'ltr:translate-x-full rtl:-translate-x-full' : 'translate-x-0'"
          class="shadow-theme-sm absolute top-0.5 ltr:left-0.5 rtl:right-0.5 h-5 w-5 rounded-full bg-white duration-300 ease-linear">
        </div>
      </div>

      {{ $label }}
    </label>
  </div>
</div>
