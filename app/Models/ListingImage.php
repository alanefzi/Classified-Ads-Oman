<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['listing_id', 'path', 'sort_order'])]
class ListingImage extends Model
{
    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }

    // مفيد جداً: يرجع الرابط الكامل للصورة جاهز للاستخدام بـ Flutter
    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->path);
    }
}