<?php
declare(strict_types=1);

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\BrainConfigSetting
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $type
 * @property mixed|null $config
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|BrainConfigSetting newModelQuery()
 * @method static Builder|BrainConfigSetting newQuery()
 * @method static Builder|BrainConfigSetting query()
 * @method static Builder|BrainConfigSetting whereConfig($value)
 * @method static Builder|BrainConfigSetting whereCreatedAt($value)
 * @method static Builder|BrainConfigSetting whereDescription($value)
 * @method static Builder|BrainConfigSetting whereId($value)
 * @method static Builder|BrainConfigSetting whereName($value)
 * @method static Builder|BrainConfigSetting whereType($value)
 * @method static Builder|BrainConfigSetting whereUpdatedAt($value)
 * @mixin Eloquent
 * @property string $default
 * @method static Builder|BrainConfigSetting whereDefault($value)
 */
class BrainConfigSetting extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'config' => 'array'
    ];
}
