<?php
declare(strict_types=1);

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Word
 *
 * @property int $id
 * @property string $word
 * @property string $sentiment
 * @property int $sentence_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Word newModelQuery()
 * @method static Builder|Word newQuery()
 * @method static Builder|Word query()
 * @method static Builder|Word whereCreatedAt($value)
 * @method static Builder|Word whereId($value)
 * @method static Builder|Word whereSentenceId($value)
 * @method static Builder|Word whereSentiment($value)
 * @method static Builder|Word whereUpdatedAt($value)
 * @method static Builder|Word whereWord($value)
 * @mixin Eloquent
 * @property-read Collection|Brain[] $brains
 * @property-read int|null $brains_count
 * @property-read Sentence $sentence
 */
class Word extends Model
{
    use HasFactory;

    public function sentence(): BelongsTo
    {
        return $this->belongsTo(Sentence::class);
    }

    /**
     * The brains this words belongs to.
     * @return BelongsToMany
     */
    public function brains(): BelongsToMany
    {
        return $this->belongsToMany(Brain::class);
    }
}
