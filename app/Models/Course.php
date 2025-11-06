<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Reviews\Models\Review;
use Illuminate\Database\Eloquent\Collection;

/**
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property string|null $tagline
 * @property string|null $image_name
 * @property array $learnings
 * @property float|null $price
 * @property bool $is_published
 * @property string $difficulty
 * @property \Carbon\Carbon|null $released_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 */
class Course extends Model
{
    use HasFactory;


    protected $casts = [
        'learnings' => 'array',
        'released_at' => 'datetime',
    ];
    protected $fillable = ['title', 'slug', 'description', 'released_at',
     'tagline', 'image_name', 'learnings', 'price', 'is_published', 'difficulty', 'discount_percentage'];

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
        return $this->reviews()->where('status', 'approved')->avg('rating') ?? 0.0;
    }

    public function getApprovedReviewsAttribute(): Collection
    {
        return $this->reviews()->where('status', 'approved')->get();
    }

    public function isFree(): bool
    {
        return $this->price == 0 || $this->price === null;
    }

    public function getMinimumRatingForDifficulty(): int
    {
        $minimumRatings = [
            'beginner' => 1,
            'intermediate' => 3,
            'advanced' => 4,
            'expert' => 5
        ];

        return $minimumRatings[$this->difficulty] ?? 1;
    }

    public function getFinalPrice(): float
    {
        return round($this->price - ($this->price * $this->discount_percentage / 100), 2);
    }

    public function hasDiscount(): bool
    {
        return $this->discount_percentage > 0;
    }

    public function getSavingsAmount(): float
    {
        return round($this->price - $this->getFinalPrice(),2);
    }

    public function isValidConfiguration(): bool
    {
        if ($this->isFree() && $this->difficulty === 'expert') {
            return false;
        }
        if ($this->price > 100 && $this->difficulty === 'beginner') {
            return false;
        }
        return true;
    }

    public function isPriceAppropriateForLevel(): bool
    {
        // Un cours cher (> 100) ne devrait PAS être pour débutants
        if ($this->price > 100 && $this->difficulty === 'beginner') {
            return false;
        }
        
        // Autres cas considérés comme appropriés
        return true;
    }

}
