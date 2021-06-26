<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\AnalysisResult
 *
 * @property int $id
 * @property string $sentence
 * @property string $result
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
 * @property int $brain_id
 * @property float $positive_accuracy
 * @property float $negative_accuracy
 * @method static Builder|AnalysisResult whereBrainId($value)
 * @method static Builder|AnalysisResult whereNegativeAccuracy($value)
 * @method static Builder|AnalysisResult wherePositiveAccuracy($value)
 * @property-read Brain $brain
 * @property array $workings
 * @method static Builder|AnalysisResult whereWorkings($value)
 */
class AnalysisResult extends Model
{
    use HasFactory;

    protected $casts = [
        'workings' => 'array'
    ];

    protected $fillable = [
        'sentence',
        'brain_id',
        'result',
        'positive_accuracy',
        'negative_accuracy',
        'workings'
    ];

    /**
     * @return BelongsTo
     */
    public function brain(): BelongsTo
    {
        return $this->belongsTo(Brain::class);
    }
}
