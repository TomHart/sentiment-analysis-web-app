<x-jet-form-section submit="train">
    <x-slot name="title">
        {{ __('Train Brain') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Train a brain') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label class="mb-2" for="sentiment_type" value="{{ __('Sentiment Type') }}"></x-jet-label>

            <select class="mb-2 border-gray-300 rounded-md" id="sentiment_type" name="sentiment_type"
                    wire:model.defer="sentimentType">
                @foreach(\TomHart\SentimentAnalysis\Analyser\Analyser::VALID_TYPES as $type)
                    <option value="{{$type}}">
                        {{ucwords($type)}}
                    </option>
                @endforeach
            </select>
            <x-jet-input-error for="sentimentType" class="mt-2"/>

            <x-jet-label for="file" value="{{ __('Training File') }}"/>
            <x-jet-input
                id="name"
                type="file"
                class="mt-1 block w-full"
                wire:model.defer="file"
                autofocus/>
            <x-jet-input-error for="file" class="mt-2"/>

        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="cleaning-scheduled">
            {{ __('Stop Word update scheduled. Please check your notifications for progress') }}
        </x-jet-action-message>

        <x-jet-action-message class="mr-3" on="scheduled">
            {{ __('Training scheduled. Please check your notifications for progress') }}
        </x-jet-action-message>

        <div class="text-sm text-gray-600 mx-2" wire:loading wire:target="file">
            Checking File
        </div>

        <div class="text-sm text-gray-600 mx-2" wire:loading wire:target="train">
            Starting Training
        </div>

        <x-jet-button wire:loading.attr="disabled" class="mx-2" type="button" wire:click="removeStopWords">
            {{ __('Update Stop Words') }}
        </x-jet-button>

        <x-jet-button wire:loading.attr="disabled">
            {{ __('Train') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
