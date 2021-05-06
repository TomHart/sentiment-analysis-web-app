<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\AnalysisResult
 *
 * @property int $id
 * @property string $sentence
 * @property int $user_id
 * @property string $result
 * @property float $accuracy
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|AnalysisResult newModelQuery()
 * @method static Builder|AnalysisResult newQuery()
 * @method static Builder|AnalysisResult query()
 * @method static Builder|AnalysisResult whereAccuracy($value)
 * @method static Builder|AnalysisResult whereCreatedAt($value)
 * @method static Builder|AnalysisResult whereId($value)
 * @method static Builder|AnalysisResult whereResult($value)
 * @method static Builder|AnalysisResult whereSentence($value)
 * @method static Builder|AnalysisResult whereUpdatedAt($value)
 * @method static Builder|AnalysisResult whereUserId($value)
 * @mixin Eloquent
 */
class AnalysisResult extends Model
{
    use HasFactory;
}
