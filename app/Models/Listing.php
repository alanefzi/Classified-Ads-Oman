<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'user_id', 'category_id', 'country_id', 'city_id',
    'title', 'description', 'price', 'currency',
    'is_negotiable', 'condition', 'attributes',
    'status', 'expires_at',
])]
class Listing extends Model
{
    protected function casts(): array
    {
        return [
            'attributes' => 'array',
            'is_negotiable' => 'boolean',
            'is_featured' => 'boolean',
            'price' => 'decimal:2',
            'expires_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function images()
    {
        return $this->hasMany(ListingImage::class);
    }
}