<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;

class ListCategoryNames extends Command
{
    protected $signature = 'categories:list';
    protected $description = 'عرض كل أسماء الفئات الرئيسية كما هي مخزنة بالضبط';

    public function handle()
    {
        Category::whereNull('parent_id')->orderBy('sort_order')->get(['id', 'name_ar'])->each(function ($c) {
            $this->line($c->id . ' | [' . $c->name_ar . ']');
        });
    }
}