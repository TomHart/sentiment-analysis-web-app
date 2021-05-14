@if ($this->brains->isNotEmpty())

    <x-jet-section-border/>

    <div class="mt-10 sm:mt-0">
        <x-jet-action-section>
            <x-slot name="title">
                {{ __('Manage Brains') }}
            </x-slot>

            <x-slot name="description">
                {{ __('You may manage any of your brains.') }}
            </x-slot>

            <!-- Brain List -->
            <x-slot name="content">
                <div class="space-y-6">
                    @foreach ($this->brains as $brain)
                        <div class="flex items-center justify-between">
                            <div>
                                {{ $brain->name }}
                            </div>

                            <div class="flex items-center">
                                <a href="{{route('brains.show', $brain)}}"
                                   class="cursor-pointer ml-6 underline text-blue-600">
                                    {{ __('Manage') }}
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </x-slot>
        </x-jet-action-section>
    </div>
@endif
