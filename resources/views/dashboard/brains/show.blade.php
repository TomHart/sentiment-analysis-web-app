<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $brain->name }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">

            <!-- Create Brain Form -->
            <livewire:brain.usage-panel :brain="$brain"/>

            <x-jet-section-border/>

            <!-- Delete -->
            <livewire:brain.delete-panel :brain="$brain"/>

            <x-jet-section-border/>

            <!-- Training -->
            <livewire:brain.training-panel :brain="$brain"/>
        </div>
    </div>
</x-app-layout>
