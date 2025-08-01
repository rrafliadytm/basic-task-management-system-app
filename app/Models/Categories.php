<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use App\Models\Priorities;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 * schema="Category",
 * required={"id", "name", "slug"},
 * @OA\Property(property="id", type="integer", readOnly=true, example=1),
 * @OA\Property(property="name", type="string", example="Work Project"),
 * @OA\Property(property="slug", type="string", readOnly=true, example="work-project")
 * )
 */
class Categories extends Model
{
    use HasFactory;
    // Eloquent Relationship for Categories Has Many Tasks
    public function priorities(): HasMany
    {
        return $this->hasMany(Priorities::class);
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
