<span class="text-base tracking-tighter" wire:poll>
    <x-svg.bell
        class="{{$unreadNotifications->count() ? 'animate-swing' : ''}} h-5 align-text-top origin-top"/>
</span>
