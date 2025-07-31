<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;


class categories extends Model
{
    // Eloquent Relationship for Categories Has Many Tasks
    public function priorities(): HasMany
    {
        return $this->hasMany(priorities::class);
    }


    protected $table = 'categories';
    protected $fillable = [
        'name',
        'slug',
    ];
     protected static function boot()
    {
        parent::boot();
        // This method is called when a new category is being created
        static::creating(function ($category) {
            // Change the content of the 'name' column to a slug format
            // and save it to the 'slug' column
            $category->slug = Str::slug($category->name);
        });
    }
}
