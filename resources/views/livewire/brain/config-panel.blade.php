<div class="mt-10 sm:mt-0">
    <x-jet-form-section submit="save">
        <x-slot name="title">
            {{ __('Config') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Set the brains config.') }}
        </x-slot>

        <x-slot name="form">
            <div class="col-span-6">
                @foreach($configs as $index => $config)
                    <div class="mb-4">
                        <p class="text-lg text-gray-600">{{$settings[$config['setting_id']]['name']}}</p>
                        <p class="text-sm text-gray-500 mb-2">{{$settings[$config['setting_id']]['description']}}</p>

                        @switch($settings[$config['setting_id']]['type'])
                            @case('toggle')
                            <div
                                class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                                <input type="checkbox"
                                       name="toggle"
                                       id="toggle"
                                       value="1"
                                       wire:change="save({{$config['id']}}, {{$index}})"
                                       wire:model="configs.{{$index}}.value"
                                       class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer"
                                />
                                <label for="toggle"
                                       class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"/>
                            </div>
                            <label for="toggle"
                                   class="text-xs text-gray-700">{{$settings[$config['setting_id']]['name']}}</label>
                            @break

                            @case('raw')
                            @switch($settings[$config['setting_id']]['config']['type'])
                                @case('list')

                                @foreach($config['value'] as $valueIndex => $value)
                                    <x-jet-input
                                        type="text"
                                        class="mt-1 block w-full"
                                        wire:blur="save({{$config['id']}}, {{$index}})"
                                        wire:model.defer="configs.{{$index}}.value.{{$valueIndex}}"
                                    />
                                @endforeach

                                <x-jet-input
                                    type="text"
                                    class="mt-1 block w-full"
                                    wire:blur="save({{$config['id']}}, {{$index}})"
                                    wire:model.defer="configs.{{$index}}.value.{{count($config['value'])}}"
                                />
                                @break
                            @endswitch
                            @break

                            @default

                            @break
                        @endswitch
                    </div>
                @endforeach
            </div>
        </x-slot>

        <x-slot name="actions">
            <div class="text-sm text-gray-600 mx-2" wire:loading>
                Saving...
            </div>

            <x-jet-action-message class="mr-3" on="saved">
                {{ __('Settings saved.') }}
            </x-jet-action-message>
        </x-slot>
    </x-jet-form-section>
</div>
