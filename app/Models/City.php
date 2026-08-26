<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'state_id', 'name_ar', 'name_en', 'latitude', 'longitude',
])]
class City extends Model
{
    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function listings()
    {
        return $this->hasMany(Listing::class);
    }
}