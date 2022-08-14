<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'publication_date',
    ];

    protected $casts = [
        'publication_date' => 'datetime:Y-m-d H:i:s',
    ];

    protected function publicationDateForFront(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->publication_date->format('d M Y, H:i')
        );
    }

    protected function isVisible(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->publication_date < now()
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
