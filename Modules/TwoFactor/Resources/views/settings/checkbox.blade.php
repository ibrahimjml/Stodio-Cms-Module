<x-core::form :action="route('twofactor.settings.update')" method="PUT" class="space-y-5 p-6 sm:p-8">
<x-core::form.checkbox
    name="twofactor_enabled"
    value="1"
    :label="__('Enable two factor authentication for users')"
    :checked="(bool) old('twofactor_enabled', setting('twofactor.enabled', false))"
/>
 <x-core::ui.button type="submit">{{ __('Update') }}</x-core::ui.button>
</x-core::form>