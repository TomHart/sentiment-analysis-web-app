<div class="mt-10 sm:mt-0">
    <x-jet-action-section>
        <x-slot name="title">
            {{ __('Delete') }}
        </x-slot>

        <x-slot name="description">
            {{ __('You may delete any of your existing brains if they are no longer needed.') }}
        </x-slot>

        <x-slot name="content">
            <div class="space-y-6">
                <a wire:click="confirmBrainDeletion({{$this->brain->id}})"
                   class="cursor-pointer ml-6 text-sm text-red-600">
                    {{ __('Delete') }}
                </a>
            </div>
        </x-slot>
    </x-jet-action-section>



    <!-- Delete Brain Confirmation Modal -->
    <x-jet-confirmation-modal wire:model="confirmingBrainDeletion">
        <x-slot name="title">
            {{ __('Delete Brain') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you would like to delete this brain? This is irreversible') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmingBrainDeletion')"
                                    wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="deleteBrain" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
</div>
