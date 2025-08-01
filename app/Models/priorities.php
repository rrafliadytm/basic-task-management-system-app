<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use App\Models\Categories;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Priorities extends Model
{
    use HasFactory;
    // Eloquent Relationship for Priorities Has Many Tasks
    public function categories(): HasMany
    {
        return $this->hasMany(Categories::class);
    }


    protected $table = 'priorities';
    protected $fillable = [
        'name',
        'level',
    ];
}
