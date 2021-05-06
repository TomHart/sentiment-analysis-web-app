<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AnalysisResult
 *
 * @property int $id
 * @property string $sentence
 * @property int $user_id
 * @property string $result
 * @property float $accuracy
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|AnalysisResult newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AnalysisResult newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AnalysisResult query()
 * @method static \Illuminate\Database\Eloquent\Builder|AnalysisResult whereAccuracy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnalysisResult whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnalysisResult whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnalysisResult whereResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnalysisResult whereSentence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnalysisResult whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnalysisResult whereUserId($value)
 * @mixin \Eloquent
 */
class AnalysisResult extends Model
{
    use HasFactory;
}
