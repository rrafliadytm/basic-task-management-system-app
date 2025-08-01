<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use App\Models\Categories;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 * schema="Priority",
 * required={"id", "name", "level"},
 * @OA\Property(property="id", type="integer", readOnly=true, example=1),
 * @OA\Property(property="name", type="string", example="High"),
 * @OA\Property(property="level", type="integer", description="The priority level, higher is more important", example=3)
 * )
 */
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
