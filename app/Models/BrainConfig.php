<?php

namespace App\Models;

use App\Models\Casts\Value;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\BrainConfig
 *
 * @method static Builder|BrainConfig newModelQuery()
 * @method static Builder|BrainConfig newQuery()
 * @method static Builder|BrainConfig query()
 * @mixin Eloquent
 * @property-read Brain $brain
 * @property-read BrainConfigSetting $setting
 * @property int $id
 * @property int $brain_id
 * @property int $setting_id
 * @property string $value
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|BrainConfig whereBrainId($value)
 * @method static Builder|BrainConfig whereCreatedAt($value)
 * @method static Builder|BrainConfig whereId($value)
 * @method static Builder|BrainConfig whereSettingId($value)
 * @method static Builder|BrainConfig whereUpdatedAt($value)
 * @method static Builder|BrainConfig whereValue($value)
 */
class BrainConfig extends Model
{
    use HasFactory;
    protected $table = 'brain_config';

    protected $guarded = [];

    protected $casts = [
        'value' => Value::class
    ];

    /**
     * @return BelongsTo
     */
    public function brain(): BelongsTo
    {
        return $this->belongsTo(Brain::class);
    }

    /**
     * @return BelongsTo
     */
    public function setting(): BelongsTo
    {
        return $this->belongsTo(BrainConfigSetting::class, 'setting_id');
    }
}
