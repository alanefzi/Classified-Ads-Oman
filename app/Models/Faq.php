<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['question_ar','question_fr','question_en','answer_ar','answer_fr','answer_en','sort_order','is_active'])]
class Faq extends Model
{
    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }
}