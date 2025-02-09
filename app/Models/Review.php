<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Review extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'book_id',
        'review',
        'rating',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(related: User::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(related: Book::class);
    }

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('D m, Y'),
        );
    }

    public static function isReviewExists($user_id, $book_id)
    {
        return self::where('user_id', $user_id)->where('book_id', $book_id)->exists();
    }
}
