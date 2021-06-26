<div>
    <x-jet-input
        id="sentence"
        type="text"
        class="mt-1 block w-full"
        wire:model="sentence"
        wire:keydown.enter="useBrain"
        />

    <x-jet-input-error for="sentence" class="mt-2"/>

    @if($this->result)
        <div wire:dirty.class="hidden" wire:target="sentence">
            <x-analysis-result :result="$this->result"/>
        </div>
    @endif
</div>
