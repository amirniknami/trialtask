<?php

namespace App\Models;

use App\Traits\Filterable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 *
 */
class Shift extends Model
{

    /**
     *
     */
    public const START = "start";
    /**
     *
     */
    public const END = "end";
    /**
     *
     */
    public const CHARGE = "charge";
    /**
     *
     */
    public const RATE = "rate";
    /**
     *
     */
    public const AREA = "area";

    /**
     *
     */
    public const TYPE = "type";



    /**
     * @var string[]
     */
    protected $fillable = [
        'type', 'start', 'end', 'charge', 'rate', 'area', 'user_id', 'location_id'
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param $date
     */
    public function setStartAttribute($date){
        $this->attributes[static::START] = Carbon::parse($date)->format('Y-m-d H:m:s');
    }

    /**
     * @return string
     */
    public function getStartAttribute(): string
    {
        return Carbon::parse($this->attributes[static::START])->toIso8601String();
    }

    /**
     * @param $date
     */
    public function setEndAttribute($date){
        $this->attributes[static::END] = Carbon::parse($date)->format('Y-m-d H:m:s');
    }

    /**
     * @return string
     */
    public function getEndAttribute(): string
    {
        return Carbon::parse($this->attributes[static::END])->toIso8601String();
    }

    /**
     * @return BelongsTo
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * @return BelongsTo
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * @return BelongsToMany
     */
    public function departments(): BelongsToMany
    {
        return $this->belongsToMany(Department::class);
    }

}
