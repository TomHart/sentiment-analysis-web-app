<?php
declare(strict_types=1);

namespace App\Http\Livewire\Brain;

use App\Http\Livewire\BaseComponent;
use App\Models\Brain;
use App\Models\BrainConfig;
use App\Models\BrainConfigSetting;
use Illuminate\View\View;

/**
 * Class ConfigPanel
 * @package App\Http\Livewire\Brain
 */
class ConfigPanel extends BaseComponent
{
    public Brain $brain;
    public array $settings = [];
    public array $configs = [];

    /**
     * Build the data.
     */
    public function mount(): void
    {
        $settings = BrainConfigSetting::all()->keyBy('id');
        foreach ($settings as $setting) {

            $config = $this->brain->config()->where('setting_id', $setting['id'])->first();
            if (is_null($config)) {
                $config = new BrainConfig();
                $config->brain()->associate($this->brain);
                $config->setting()->associate($setting);
                $config->value = $setting['default'];
                $config->save();
            }

            $this->configs[] = $config->toArray();
        }

        $this->settings = $settings->toArray();
    }

    /**
     * Save the settings
     * @param int $configId
     * @param int $configIndex
     */
    public function save(int $configId, int $configIndex): void
    {
        $config = BrainConfig::findOrFail($configId);
        $config->value = $this->configs[$configIndex]['value'];
        $config->save();
        $this->configs[$configIndex] = $config->toArray();

        $this->emit('saved');
    }

    /**
     * @return View
     */
    public function render(): View
    {
        return view('livewire.brain.config-panel');
    }
}
