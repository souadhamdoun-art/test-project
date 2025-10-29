<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Reviews\Models\Review;
use Illuminate\Database\Eloquent\Collection;

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

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function getAverageRatingAttribute(): float
    {
        return $this->reviews()->avg('rating') ?? 0.0;
    }

    public function getApprovedReviewsAttribute(): Collection
    {
        return $this->reviews()->where('status', 'approved')->get();
    }
}
