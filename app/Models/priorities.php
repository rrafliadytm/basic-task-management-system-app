<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class priorities extends Model
{
    protected $table = 'priorities';
    protected $fillable = [
        'name',
        'level',
    ];
}
