<div>
    <!-- Generate Brain -->
    <x-jet-form-section submit="createBrain">
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
                    wire:model.defer="createBrainForm.name"
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

    @if ($this->user->brains->isNotEmpty())
        <x-jet-section-border/>

        <!-- Manage Brains -->
        <div class="mt-10 sm:mt-0">
            <x-jet-action-section>
                <x-slot name="title">
                    {{ __('Brains') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('You may delete any of your existing brains if they are no longer needed.') }}
                </x-slot>

                <!-- Brain List -->
                <x-slot name="content">
                    <div class="space-y-6">
                        @foreach ($this->user->brains->sortBy('name') as $brain)
                            <div class="flex items-center justify-between">
                                <div>
                                    {{ $brain->name }}
                                </div>

                                <div class="flex items-center">
                                    <div>
                                        Usage: {{$brain->results->count()}}
                                    </div>

                                    <button
                                        class="cursor-pointer ml-6 text-sm text-red-500"
                                        wire:click="confirmBrainDeletion({{ $brain->id }})">
                                        {{ __('Delete') }}
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </x-slot>
            </x-jet-action-section>
        </div>
    @endif
    <x-jet-section-border/>

    @livewire('brain-training-form')

    <!-- Delete Brain Confirmation Modal -->
    <x-jet-confirmation-modal wire:model="confirmingBrainDeletion">
        <x-slot name="title">
            {{ __('Delete Brain') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you would like to delete this brain? This is irreversible') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmingBrainDeletion')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="deleteBrain" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
</div>
