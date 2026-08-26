<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['code', 'name_ar', 'name_en', 'currency', 'phone_code', 'is_active'])]
class Country extends Model
{
    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function states()
    {
        return $this->hasMany(State::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function listings()
    {
        return $this->hasMany(Listing::class);
    }
}