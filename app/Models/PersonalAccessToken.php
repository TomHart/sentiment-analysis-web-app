<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Sanctum\PersonalAccessToken as BaseToken;

/**
 * Class Token
 * @package App\Models
 */
class PersonalAccessToken extends BaseToken
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'token',
        'abilities',
        'brain_id',
    ];

    /**
     * @return BelongsTo
     */
    public function brain(): BelongsTo
    {
        return $this->belongsTo(Brain::class);
    }
}
