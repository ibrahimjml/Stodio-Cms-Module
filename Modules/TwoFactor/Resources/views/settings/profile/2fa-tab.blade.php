 @push('head-scripts')
 @moduleVite('TwoFactor')
 @endpush

 <div x-show="tab === '2fa'" x-cloak>

 @if(! \Modules\TwoFactor\Models\TwoFactor::userEnabled(auth()->user()))
 	<x-core::ui.button 
        type="button" 
        @click="$dispatch('open-2fa-modal')" 
        :startIcon="@svg('o-lock')"
        class="font-bold text-lg"
        variant="outline"
     >
   {{ __('Enable Two Factor') }}
</x-core::ui.button>

<!-- enable modal-->
@include('twofactor::settings.profile.2fa-modal')

 @else 
 <x-core::ui.button 
     type="button" 
     @click="$dispatch('open-disable-modal')" 
     :startIcon="@svg('o-unlock')"
     class="font-bold "
     variant="outline"
     >
   {{ __('Disable Two Factor') }}
 </x-core::ui.button>
 @if(! \Modules\TwoFactor\Models\TwoFactor::hasDownloadedRecovery(auth()->user()))
 <x-core::ui.button 
     :href="route('twofactor.profile.recovery.download')"
     :startIcon="@svg('o-download')"
     class="font-bold "
     variant="outline"
     >
   {{ __('Download Recovery') }}
 </x-core::ui.button>
 @endif

 <!-- disable modal-->
 @include('twofactor::settings.profile.disable-modal')
 @endif

</div>