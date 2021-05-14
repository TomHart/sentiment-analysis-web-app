<div class="mt-10 sm:mt-0">
    <x-jet-action-section>
        <x-slot name="title">
            {{ __('Usage') }}
        </x-slot>

        <x-slot name="description">
            {{ __('View this brains usage.') }}
        </x-slot>

        <x-slot name="content">
            <div class="space-y-6">
                Total Usage: {{$this->brain->results->count()}}
                <br/>

                @foreach($this->monthlyUsage as $month => $count)
                    Usage for {{$month}}: {{$count}}<br />
                @endforeach
            </div>
        </x-slot>
    </x-jet-action-section>
</div>
