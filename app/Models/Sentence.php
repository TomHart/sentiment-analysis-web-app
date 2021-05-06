<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Sentence
 *
 * @property int $id
 * @property string $sentence
 * @property string $sentiment
 * @property int $brain_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Sentence newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sentence newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sentence query()
 * @method static \Illuminate\Database\Eloquent\Builder|Sentence whereBrainId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sentence whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sentence whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sentence whereSentence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sentence whereSentiment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sentence whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Sentence extends Model
{
    use HasFactory;
}
