<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use App\Models\Categories;
use App\Models\Priorities;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Tasks extends Model
{
    use HasFactory;
    // Eloquent Relationship for Tasks Belongs To Categories
    public function categories(): BelongsTo
    {
        return $this->belongsTo(Categories::class, 'category_id', 'id');
    }

    // Eloquent Relationship for Tasks Belongs To Priorities
    public function priorities(): BelongsTo
    {
        return $this->belongsTo(Priorities::class , 'priority_id', 'id');
    }

    // Eloquent Relationship for Tasks Belongs To User
    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class , 'user_id', 'id');
    }

    protected $table = 'tasks';
    protected $fillable = [
        'title',
        'description',
        'deadline',
        'status',
        'category_id',
        'priority_id',
        'user_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'deadline' => 'datetime', // <-- TAMBAHKAN BARIS INI
    ];

        protected static function boot()
    {
        parent::boot();

        static::creating(function ($tasks) {
            if (!$tasks->user_id) {
                $tasks->user_id = Auth::id(); // Only set user_id if it's not already set
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Categories::class);
    }

    public function priority()
    {
        return $this->belongsTo(Priorities::class);
    }

}
