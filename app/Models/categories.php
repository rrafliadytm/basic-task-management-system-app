<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class categories extends Model
{
    protected $table = 'categories';
    protected $fillable = [
        'name',
        'slug',
    ];
     protected static function boot()
    {
        parent::boot();

        // Event ini akan berjalan SEBELUM data baru disimpan ke database
        static::creating(function ($category) {
            // Mengubah isi kolom 'name' menjadi format slug
            // dan menyimpannya ke kolom 'slug'
            $category->slug = Str::slug($category->name);
        });
    }
}
