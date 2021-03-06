<?php
declare(strict_types=1);

namespace App\Models;

use App\SentimentAnalysis\DatabaseBrain;
use App\SentimentAnalysis\Memories\DatabaseLoader;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use TomHart\SentimentAnalysis\Brain\StopWords;

/**
 * App\Models\Brain
 *
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Brain[] $brains
 * @property-read int|null $brains_count
 * @property-read Collection|Word[] $words
 * @property-read int|null $words_count
 * @property-read Collection|Sentence[] $sentences
 * @property-read int|null $sentences_count
 * @method static Builder|Brain newModelQuery()
 * @method static Builder|Brain newQuery()
 * @method static Builder|Brain query()
 * @method static Builder|Brain whereCreatedAt($value)
 * @method static Builder|Brain whereId($value)
 * @method static Builder whereName($value)
 * @method static Builder|Brain whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read Collection|User[] $users
 * @property-read int|null $users_count
 * @property-read Collection|AnalysisResult[] $results
 * @property-read int|null $results_count
 * @property-read Collection|BrainConfigSetting[] $config
 * @property-read int|null $config_count
 * @property-read Collection|\App\Models\BrainConfigSetting[] $settings
 * @property-read int|null $settings_count
 */
class Brain extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * The users this brain belongs to.
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * The words this brain knows about.
     * @return BelongsToMany
     */
    public function words(): BelongsToMany
    {
        return $this->belongsToMany(Word::class);
    }

    /**
     * The sentences this brain knows about.
     * @return HasMany
     */
    public function sentences(): HasMany
    {
        return $this->hasMany(Sentence::class);
    }

    /**
     * @return HasMany
     */
    public function results(): HasMany
    {
        return $this->hasMany(AnalysisResult::class);
    }

    /**
     * @return BelongsToMany
     */
    public function settings(): BelongsToMany
    {
        return $this
            ->belongsToMany(
                BrainConfigSetting::class,
                BrainConfig::class,
                'brain_id',
                'setting_id',
            )
            ->withPivot(['value'])
            ->using(BrainConfig::class);
    }

    /**
     * @return DatabaseBrain
     */
    public function toBrain(): DatabaseBrain
    {
        $brain = new DatabaseBrain($this, new DatabaseLoader($this));
        $stopWords = [];

        $settings = $this->settings;

        foreach ($settings as $setting) {
            $stopWords = match ($setting->name) {
                'Use Default Stop Words' => array_merge($stopWords, StopWords::ENGLISH),
                'Custom Stop Words' => array_merge($stopWords, $setting->pivot->value),
            };
        }

        $brain->setStopWords($stopWords);
        return $brain;
    }

    /**
     * @return HasMany
     */
    public function config(): HasMany
    {
        return $this->hasMany(
            BrainConfig::class
        );
    }
}
