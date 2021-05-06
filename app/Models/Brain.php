<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * App\Models\Brain
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Brain[] $brains
 * @property-read int|null $brains_count
 * @method static Builder|Brain newModelQuery()
 * @method static Builder|Brain newQuery()
 * @method static Builder|Brain query()
 * @method static Builder|Brain whereCreatedAt($value)
 * @method static Builder|Brain whereId($value)
 * @method static Builder|Brain whereName($value)
 * @method static Builder|Brain whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Brain extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * The brains this user has.
     * @return HasMany
     */
    public function brains(): HasMany
    {
        return $this->hasMany(Brain::class);
    }
}
