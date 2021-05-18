<?php
declare(strict_types=1);

namespace App\View\Components\Brain;

use App\Models\BrainConfigSetting;
use Illuminate\View\Component;
use Illuminate\View\View;
use JsonException;

/**
 * Class Setting
 * @package App\View\Components\Brain
 */
class Setting extends Component
{
    public BrainConfigSetting $setting;

    /**
     * Create a new component instance.
     *
     * @param string $setting
     * @throws JsonException
     */
    public function __construct(string $setting)
    {
        $setting = json_decode($setting, true, 512, JSON_THROW_ON_ERROR);
        $settingModel = new BrainConfigSetting($setting);

        $this->setting = $settingModel;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('components.brain.setting');
    }
}
