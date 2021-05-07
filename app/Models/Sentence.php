<?php
declare(strict_types=1);

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Sentence
 *
 * @property int $id
 * @property string $sentence
 * @property string $sentiment
 * @property int $brain_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Sentence newModelQuery()
 * @method static Builder|Sentence newQuery()
 * @method static Builder|Sentence query()
 * @method static Builder|Sentence whereBrainId($value)
 * @method static Builder|Sentence whereCreatedAt($value)
 * @method static Builder|Sentence whereId($value)
 * @method static Builder|Sentence whereSentence($value)
 * @method static Builder|Sentence whereSentiment($value)
 * @method static Builder|Sentence whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read Brain $brain
 */
class Sentence extends Model
{
    use HasFactory;

    protected $hidden = ['created_at', 'updated_at'];

    public function brain(): BelongsTo
    {
        return $this->belongsTo(Brain::class);
    }
}
