<?php
declare(strict_types=1);

namespace App\Models\Casts;

use App\Models\BrainConfigSetting;
use Illuminate\Contracts\Database\Eloquent\Castable;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

/**
 * Class Value
 * @package App\Models\Casts
 */
class Value implements Castable
{
    /**
     * Get the caster class to use when casting from / to this cast target.
     *
     * @param array $arguments
     * @return CastsAttributes
     */
    public static function castUsing(array $arguments): CastsAttributes
    {
        return new class implements CastsAttributes {
            /**
             * @param $model
             * @param $key
             * @param $value
             * @param $attributes
             * @return mixed
             */
            public function get($model, $key, $value, $attributes): mixed
            {
                $setting = BrainConfigSetting::findOrFail($attributes['setting_id']);
                return match ($setting->type) {
                    'toggle' => (bool)$attributes[$key],
                    default => $attributes[$key],
                };
            }

            /**
             * @param $model
             * @param $key
             * @param $value
             * @param $attributes
             * @return bool[]
             */
            public function set($model, $key, $value, $attributes): array
            {
                $setting = BrainConfigSetting::findOrFail($attributes['setting_id']);
                return [$key => match ($setting->type) {
                    'toggle' => $value ? '1' : '0',
                    default => $value,
                }];
            }
        };
    }
}
