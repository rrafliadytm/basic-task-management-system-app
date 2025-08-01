<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;


class tasks extends Model
{
    // Eloquent Relationship for Tasks Belongs To Categories
    public function categories(): BelongsTo
    {
        return $this->belongsTo(categories::class, 'category_id', 'id');
    }

    // Eloquent Relationship for Tasks Belongs To Priorities
    public function priorities(): BelongsTo
    {
        return $this->belongsTo(priorities::class , 'priority_id', 'id');
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

        protected static function boot()
    {
        parent::boot();

        static::creating(function ($tasks) {
            $tasks->user_id = Auth::id(); // It will set the user_id to the currently authenticated user's ID
        });
    }

}
