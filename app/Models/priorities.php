<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class priorities extends Model
{
    // Eloquent Relationship for Priorities Has Many Tasks
    public function categories(): HasMany
    {
        return $this->hasMany(categories::class);
    }


    protected $table = 'priorities';
    protected $fillable = [
        'name',
        'level',
    ];
}
