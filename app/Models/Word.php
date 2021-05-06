<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
 */
class Word extends Model
{
    use HasFactory;
}
