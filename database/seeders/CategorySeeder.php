<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // 🧹 تصفير الفئات القديمة قبل الزرع
        Category::query()->delete();

        $categories = [
            [
                'name_ar' => 'سيارات',
                'name_en' => 'Cars',
                'icon'    => 'heroicon-o-truck',
                'children' => [
                    ['name_ar' => 'سيارات للبيع',        'name_en' => 'Cars for Sale'],
                    ['name_ar' => 'قطع غيار واكسسوارات', 'name_en' => 'Parts & Accessories'],
                    ['name_ar' => 'تأجير سيارات',        'name_en' => 'Car Rental'],
                    ['name_ar' => 'دراجات نارية',        'name_en' => 'Motorcycles'],
                    ['name_ar' => 'شاحنات ومركبات ثقيلة', 'name_en' => 'Trucks & Heavy Vehicles'],
                ],
            ],
            [
                'name_ar' => 'عقارات',
                'name_en' => 'Real Estate',
                'icon'    => 'heroicon-o-home',
                'children' => [
                    ['name_ar' => 'شقق للبيع',        'name_en' => 'Apartments for Sale'],
                    ['name_ar' => 'شقق للإيجار',      'name_en' => 'Apartments for Rent'],
                    ['name_ar' => 'فلل للبيع',        'name_en' => 'Villas for Sale'],
                    ['name_ar' => 'فلل للإيجار',      'name_en' => 'Villas for Rent'],
                    ['name_ar' => 'أراضي',            'name_en' => 'Land'],
                    ['name_ar' => 'عقارات تجارية',    'name_en' => 'Commercial Properties'],
                    ['name_ar' => 'استراحات ومزارع',  'name_en' => 'Resorts & Farms'],
                ],
            ],
            [
                'name_ar' => 'إلكترونيات',
                'name_en' => 'Electronics',
                'icon'    => 'heroicon-o-device-phone-mobile',
                'children' => [
                    ['name_ar' => 'هواتف وتابلت',        'name_en' => 'Phones & Tablets'],
                    ['name_ar' => 'أجهزة كمبيوتر',       'name_en' => 'Computers'],
                    ['name_ar' => 'أجهزة منزلية',        'name_en' => 'Home Appliances'],
                    ['name_ar' => 'كاميرات',             'name_en' => 'Cameras'],
                    ['name_ar' => 'ألعاب فيديو وأجهزة',   'name_en' => 'Video Games & Consoles'],
                ],
            ],
            [
                'name_ar' => 'أثاث ومستلزمات المنزل',
                'name_en' => 'Furniture & Home',
                'icon'    => 'heroicon-o-cube',
                'children' => [
                    ['name_ar' => 'أثاث',              'name_en' => 'Furniture'],
                    ['name_ar' => 'ديكور منزلي',       'name_en' => 'Home Decor'],
                    ['name_ar' => 'أدوات مطبخ',        'name_en' => 'Kitchen Appliances'],
                    ['name_ar' => 'حدائق ومستلزماتها', 'name_en' => 'Garden Supplies'],
                ],
            ],
            [
                'name_ar' => 'وظائف',
                'name_en' => 'Jobs',
                'icon'    => 'heroicon-o-briefcase',
                'children' => [
                    ['name_ar' => 'وظائف شاغرة', 'name_en' => 'Job Openings'],
                    ['name_ar' => 'باحثون عن عمل', 'name_en' => 'Job Seekers'],
                    ['name_ar' => 'دوام جزئي',    'name_en' => 'Part-Time'],
                ],
            ],
            [
                'name_ar' => 'خدمات',
                'name_en' => 'Services',
                'icon'    => 'heroicon-o-wrench-screwdriver',
                'children' => [
                    ['name_ar' => 'خدمات صيانة',   'name_en' => 'Maintenance Services'],
                    ['name_ar' => 'خدمات نقل',     'name_en' => 'Moving Services'],
                    ['name_ar' => 'خدمات تعليمية', 'name_en' => 'Educational Services'],
                    ['name_ar' => 'خدمات تجميل وصحة', 'name_en' => 'Beauty & Health Services'],
                ],
            ],
            [
                'name_ar' => 'أزياء وإكسسوارات',
                'name_en' => 'Fashion & Accessories',
                'icon'    => 'heroicon-o-sparkles',
                'children' => [
                    ['name_ar' => 'ملابس رجالية', 'name_en' => "Men's Clothing"],
                    ['name_ar' => 'ملابس نسائية', 'name_en' => "Women's Clothing"],
                    ['name_ar' => 'ساعات ومجوهرات', 'name_en' => 'Watches & Jewelry'],
                    ['name_ar' => 'حقائب وأحذية', 'name_en' => 'Bags & Shoes'],
                ],
            ],
            [
                'name_ar' => 'حيوانات أليفة',
                'name_en' => 'Pets',
                'icon'    => 'heroicon-o-heart',
                'children' => [
                    ['name_ar' => 'قطط',                 'name_en' => 'Cats'],
                    ['name_ar' => 'كلاب',                'name_en' => 'Dogs'],
                    ['name_ar' => 'طيور',                'name_en' => 'Birds'],
                    ['name_ar' => 'مستلزمات الحيوانات', 'name_en' => 'Pet Supplies'],
                ],
            ],
            [
                'name_ar' => 'رياضة وهوايات',
                'name_en' => 'Sports & Hobbies',
                'icon'    => 'heroicon-o-trophy',
                'children' => [
                    ['name_ar' => 'معدات رياضية', 'name_en' => 'Sports Equipment'],
                    ['name_ar' => 'دراجات هوائية', 'name_en' => 'Bicycles'],
                    ['name_ar' => 'كتب وهوايات',  'name_en' => 'Books & Hobbies'],
                ],
            ],
            [
                'name_ar' => 'أعمال وتجارة',
                'name_en' => 'Business & Industrial',
                'icon'    => 'heroicon-o-building-office',
                'children' => [
                    ['name_ar' => 'معدات تجارية',   'name_en' => 'Commercial Equipment'],
                    ['name_ar' => 'مستلزمات مكتبية', 'name_en' => 'Office Supplies'],
                    ['name_ar' => 'مشاريع للبيع',    'name_en' => 'Businesses for Sale'],
                ],
            ],
        ];

        $sortOrder = 1;

        foreach ($categories as $cat) {
            $parent = Category::create([
                'name_ar'    => $cat['name_ar'],
                'name_en'    => $cat['name_en'],
                'icon'       => $cat['icon'],
                'slug'       => Str::slug($cat['name_en']),
                'sort_order' => $sortOrder++,
                'is_active'  => true,
            ]);

            $childSort = 1;
            foreach ($cat['children'] as $child) {
                Category::create([
                    'parent_id'  => $parent->id,
                    'name_ar'    => $child['name_ar'],
                    'name_en'    => $child['name_en'],
                    'icon'       => null,
                    'slug'       => Str::slug($cat['name_en'] . '-' . $child['name_en']),
                    'sort_order' => $childSort++,
                    'is_active'  => true,
                ]);
            }
        }

        $total = Category::count();
        $this->command->info("✅ تم زرع {$total} فئة (رئيسية وفرعية) بنجاح.");
    }
}
