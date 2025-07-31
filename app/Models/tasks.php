<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tasks extends Model
{
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
}
