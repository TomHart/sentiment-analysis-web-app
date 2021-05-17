<x-jet-form-section submit="create">
    <x-slot name="title">
        {{ __('Create Brain') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Created brains will be linked to your account. You can later create an API Token linked to the brain') }}
    </x-slot>

    <x-slot name="form">
        <!-- Brain Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="name" value="{{ __('Brain Name') }}"/>
            <x-jet-input
                id="name"
                type="text"
                class="mt-1 block w-full"
                wire:model.defer="name"
                autofocus/>
            <x-jet-input-error for="name" class="mt-2"/>
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="created">
            {{ __('Created.') }}
        </x-jet-action-message>

        <x-jet-button>
            {{ __('Create') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
