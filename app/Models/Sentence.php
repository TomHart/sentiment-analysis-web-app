<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
 */
class Sentence extends Model
{
    use HasFactory;
}
