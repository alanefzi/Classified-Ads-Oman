<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;

class SortCategories extends Command
{
    protected $signature = 'categories:sort';
    protected $description = 'تحديث ترتيب الفئات الرئيسية دفعة واحدة';

    public function handle()
    {
        $order = [
            'سيارات' => 1,
            'عقارات' => 2,
            'موبايل وتابلت' => 3,
            'إلكترونيات' => 4,
            'لابتوب وكمبيوتر' => 5,
            'ألعاب وألعاب الفيديو' => 6,
            'دراجات نارية' => 7,
            'خدمات' => 9,
            'طعام وغذاء' => 11,
            'رياضة وهوايات' => 12,
            'حيوانات أليفة' => 13,
            'ترفيه وكتب ومقتنيات' => 14,
            'أزياء وإكسسوارات' => 15,
            'موضة وأطفال' => 16,
            'أثاث ومستلزمات المنزل' => 18,
            'وظائف' => 19,
            'باحثين عن عمل' => 20,
            'أجهزة منزلية' => 22,
            'منزل وحديقة' => 23,
            'تجهيزات ومعدات الشركات' => 24,
            'أعمال وتجارة' => 25,
        ];

        foreach ($order as $name => $ord) {
            $cat = Category::where('name_ar', $name)->first();
            if ($cat) {
                $cat->update(['sort_order' => $ord]);
                $this->info("OK: {$name} -> {$ord}");
            } else {
                $this->error("NOT FOUND: {$name}");
            }
        }

        // الأربعة الجديدة - بالـ ID مباشرة لتفادي مشاكل النص
        $byId = [
            69 => 8,   // مقاولات
            70 => 10,  // تخييم
            71 => 17,  // هدايا
            72 => 21,  // تعليم
        ];

        foreach ($byId as $id => $ord) {
            $cat = Category::find($id);
            if ($cat) {
                $cat->update(['sort_order' => $ord]);
                $this->info("OK (by id): {$cat->name_ar} (id={$id}) -> {$ord}");
            } else {
                $this->error("ID NOT FOUND: {$id}");
            }
        }

        $this->info('تم الانتهاء.');
    }
}