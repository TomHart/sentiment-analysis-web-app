<div class="mt-10 sm:mt-0">
    <x-jet-form-section submit="useBrain">
        <x-slot name="title">
            {{ __('Use') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Try the brain out') }}
        </x-slot>

        <x-slot name="form">
            <!-- Brain Name -->
            <div class="col-span-6">
                <x-jet-label for="name" value="{{ __('Sentence') }}"/>
                <x-jet-input
                    id="sentence"
                    type="text"
                    class="mt-1 block w-full"
                    wire:model.defer="sentence"
                    wire:keydown.enter="useBrain"
                    autofocus/>
                <x-jet-input-error for="sentence" class="mt-2"/>

                @if($this->result)
                    <div wire:dirty.class="hidden" wire:target="sentence">
                        <x-analysis-result :result="$this->result"/>
                    </div>
                @endif
            </div>
        </x-slot>


        <x-slot name="actions">
            <x-jet-button>
                {{ __('Test') }}
            </x-jet-button>
        </x-slot>
    </x-jet-form-section>
</div>
