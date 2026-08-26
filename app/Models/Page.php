<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['slug','title_ar','title_fr','title_en','content_ar','content_fr','content_en','is_active'])]
class Page extends Model
{
    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }
}