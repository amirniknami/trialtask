<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    public const NAME_FIELD = "name";

    public const START_FIELD = "start";

    PUBLIC CONST END_FIELD = "end";

    protected $fillable = [
        'name' , 'start', 'end'
    ];

    /**
     * @param $date
     */
    public function setStartAttribute($date){
        $this->attributes[static::START_FIELD] = Carbon::parse($date)->format('Y-m-d H:m:s');
    }

    /**
     * @return string
     */
    public function getStartAttribute(): string
    {
        return Carbon::parse($this->attributes[static::START_FIELD])->toIso8601String();
    }

    /**
     * @param $date
     */
    public function setEndAttribute($date){
        $this->attributes[static::END_FIELD] = Carbon::parse($date)->format('Y-m-d H:m:s');
    }

    /**
     * @return string
     */
    public function getEndAttribute(): string
    {
        return Carbon::parse($this->attributes[static::END_FIELD])->toIso8601String();
    }


    /**
     * @return HasMany
     */
    public function shifts(): HasMany
    {
        return $this->hasMany(Shift::class);
    }
}
