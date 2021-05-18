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
             * @return array|bool
             */
            public function get($model, $key, $value, $attributes): array|bool
            {
                $setting = BrainConfigSetting::findOrFail($attributes['setting_id']);
                return match ($setting->type) {
                    'toggle' => (bool)$attributes[$key],
                    'raw' => match ($setting->config['type']) {
                        'list' => array_filter(json_decode($attributes[$key], true, 512, JSON_THROW_ON_ERROR)),
                        default => $attributes[$key]
                    },
                    default => $attributes[$key],
                };
            }

            /**
             * @param $model
             * @param $key
             * @param $value
             * @param $attributes
             * @return array
             */
            public function set($model, $key, $value, $attributes): array
            {
                $setting = BrainConfigSetting::findOrFail($attributes['setting_id']);
                return [$key => match ($setting->type) {
                    'toggle' => $value ? '1' : '0',
                    'raw' => match ($setting->config['type']) {
                        'list' => $value === '[]' ? $value : json_encode(array_values(array_filter($value)), JSON_THROW_ON_ERROR),
                        default => $attributes[$key]
                    },
                    default => $value,
                }];
            }
        };
    }
}
