<?php

namespace Modules\Reviews\Models;

use App\Models\User;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return \Modules\Reviews\database\factories\ReviewFactory::new();
    }

    protected $fillable = [
        'rating',
        'comment',
        'user_id',
        'course_id',
        'status',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function reject()
    {
        $this->status = 'rejected';
        $this->save();
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }
    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}

