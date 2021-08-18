<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 *
 */
class Department extends Model
{
    use HasFactory;

     public const NAME_FILED = "title";

     protected $fillable = [
          'title'
     ];
    /**
     * @return BelongsToMany
     */
    public function shifts(): BelongsToMany
    {
        return $this->belongsToMany(Shift::class);
    }
}
