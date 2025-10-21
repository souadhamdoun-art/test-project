<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;


    protected $casts = [
        'learnings' => 'array',
        'released_at' => 'datetime',
    ];
    protected $fillable = ['title', 'slug', 'description', 'released_at', 'tagline', 'image_name', 'learnings'];

    public function scopeReleased($query)
    {
        return $query->whereNotNull('released_at');
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }
}
