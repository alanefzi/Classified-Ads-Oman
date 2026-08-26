<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ListingSeeder extends Seeder
{
    public function run(): void
    {
        $countryId = DB::table('countries')->where('code', 'OM')->value('id');

        if (!$countryId) {
            $this->command->error('عُمان (OM) مش موجودة countries. شغّل CountrySeeder أول.');
            return;
        }

        $cityIds = DB::table('cities')->pluck('id')->toArray();
        if (empty($cityIds)) {
            $this->command->error('جدول cities فارغ. شغّل OmanCitySeeder أول.');
            return;
        }

        $userIds = $this->ensureDemoUsers();

        $subCategories = DB::table('categories')
            ->whereNotNull('parent_id')
            ->get(['id', 'slug', 'name_ar']);

        if ($subCategories->isEmpty()) {
            $this->command->error('جدول categories ماعندوش فئات فرعية. شغّل CategorySeeder أول.');
            return;
        }

        $templates = $this->listingTemplates();

        $statuses = ['active', 'active', 'active', 'pending', 'sold'];
        $conditions = ['new', 'used'];
        $now = now();
        $rows = [];

        foreach ($subCategories as $category) {
            $matched = $this->matchTemplate($category->slug, $templates);
            if (!$matched) {
                continue;
            }

            $count = rand(2, 4);

            for ($i = 0; $i < $count; $i++) {
                $item = $matched['items'][array_rand($matched['items'])];

                $rows[] = [
                    'user_id' => $userIds[array_rand($userIds)],
                    'category_id' => $category->id,
                    'country_id' => $countryId,
                    'city_id' => $cityIds[array_rand($cityIds)],
                    'title' => $item['title'],
                    'description' => $item['description'],
                    'price' => $item['price'],
                    'currency' => 'OMR',
                    'is_negotiable' => (bool) rand(0, 1),
                    'condition' => $conditions[array_rand($conditions)],
                    'attributes' => json_encode($item['attributes'] ?? new \stdClass(), JSON_UNESCAPED_UNICODE),
                    'status' => $statuses[array_rand($statuses)],
                    'views_count' => rand(0, 300),
                    'is_featured' => rand(0, 9) === 0,
                    'expires_at' => $now->copy()->addDays(30),
                    'created_at' => $now->copy()->subDays(rand(0, 20)),
                    'updated_at' => $now,
                ];
            }
        }

        foreach (array_chunk($rows, 50) as $chunk) {
            DB::table('listings')->insert($chunk);
        }

        $this->command->info(count($rows) . ' إعلان وهمي تم إدراجه بنجاح.');
    }

    private function ensureDemoUsers(): array
    {
        $demoUsers = [
            ['name' => 'Ahmed Al Balushi', 'phone' => '+96891111222'],
            ['name' => 'Maryam Al Habsi', 'phone' => '+96892222444'],
            ['name' => 'Yousuf Al Rawahi', 'phone' => '+96893333666'],
            ['name' => 'Noor Al Farsi', 'phone' => '+96894444888'],
        ];

        $ids = [];
        foreach ($demoUsers as $u) {
            $id = DB::table('users')->where('phone', $u['phone'])->value('id');
            if (!$id) {
                $id = DB::table('users')->insertGetId([
                    'name' => $u['name'],
                    'phone' => $u['phone'],
                    'password' => Hash::make('password123'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            $ids[] = $id;
        }

        return $ids;
    }

    private function matchTemplate(string $slug, array $templates): ?array
    {
        foreach ($templates as $key => $template) {
            if (str_contains($slug, $key)) {
                return $template;
            }
        }
        return null;
    }

    private function listingTemplates(): array
    {
        return [
            'cars-for-sale' => ['items' => [
                [
                    'title' => 'تويوتا كامري موديل 2019 حالة ممتازة',
                    'description' => 'سيارة نظيفة، صيانة دورية عند الوكالة، بلا حوادث، جاهزة للاستعمال مباشرة.',
                    'price' => 6500,
                    'attributes' => ['brand' => 'Toyota', 'model' => 'Camry', 'year' => 2019, 'mileage_km' => 65000, 'fuel' => 'petrol'],
                ],
                [
                    'title' => 'نيسان باترول 2017 فل كامل',
                    'description' => 'دفع رباعي، صيانة دورية، وثائق سليمة، فحص فني حديث.',
                    'price' => 12500,
                    'attributes' => ['brand' => 'Nissan', 'model' => 'Patrol', 'year' => 2017, 'mileage_km' => 98000, 'fuel' => 'petrol'],
                ],
                [
                    'title' => 'هيونداي أكسنت موديل 2015 للبيع',
                    'description' => 'سيارة اقتصادية، صالحة للاستعمال اليومي، سعر قابل للتفاوض.',
                    'price' => 2800,
                    'attributes' => ['brand' => 'Hyundai', 'model' => 'Accent', 'year' => 2015, 'mileage_km' => 140000, 'fuel' => 'petrol'],
                ],
            ]],
            'motorcycles' => ['items' => [
                [
                    'title' => 'دراجة نارية Honda 125cc موديل 2020',
                    'description' => 'حالة جيدة جداً، استعمال شخصي، وثائق متوفرة.',
                    'price' => 650,
                    'attributes' => ['brand' => 'Honda', 'engine_cc' => 125, 'year' => 2020],
                ],
                [
                    'title' => 'دراجة Yamaha رياضية للبيع',
                    'description' => 'محرك بحالة ممتازة، صيانة دورية، مناسبة للاستخدام اليومي.',
                    'price' => 950,
                    'attributes' => ['brand' => 'Yamaha', 'engine_cc' => 150, 'year' => 2019],
                ],
            ]],
            'parts-and-accessories' => ['items' => [
                [
                    'title' => 'طقم إطارات مستعملة مقاس 17',
                    'description' => 'حالة جيدة، استعمال قليل، مناسبة لأغلب سيارات الدفع الرباعي.',
                    'price' => 45,
                    'attributes' => ['size' => '17"', 'quantity' => 4],
                ],
            ]],
            'apartments-for-sale' => ['items' => [
                [
                    'title' => 'شقة غرفتين للبيع بحي سكني هادئ',
                    'description' => 'شقة طابق أول، مطبخ مجهز، قريبة من المدارس والمواصلات.',
                    'price' => 45000,
                    'attributes' => ['rooms' => 2, 'surface_m2' => 95, 'floor' => 1],
                ],
                [
                    'title' => 'شقة غرفة وصالة جديدة قريبة من وسط المدينة',
                    'description' => 'بناية حديثة، مصعد، موقف سيارات، جاهزة للسكن مباشرة.',
                    'price' => 32000,
                    'attributes' => ['rooms' => 1, 'surface_m2' => 65, 'floor' => 3],
                ],
            ]],
            'apartments-for-rent' => ['items' => [
                [
                    'title' => 'شقة للإيجار السنوي غرفتين مفروشة جزئياً',
                    'description' => 'قريبة من المواصلات العمومية والمحلات التجارية، إطلالة جيدة.',
                    'price' => 220,
                    'attributes' => ['rooms' => 2, 'surface_m2' => 90, 'furnished' => 'partial'],
                ],
            ]],
            'land' => ['items' => [
                [
                    'title' => 'أرض سكنية للبيع مساحة 600 متر',
                    'description' => 'أرض بيضاء، سند ملكية، قريبة من الطريق الرئيسية.',
                    'price' => 18000,
                    'attributes' => ['surface_m2' => 600, 'type' => 'residential'],
                ],
            ]],
            'commercial-spaces' => ['items' => [
                [
                    'title' => 'محل تجاري للإيجار بموقع حيوي',
                    'description' => 'واجهة زجاجية، مساحة تخزين، مناسب لعدة أنشطة تجارية.',
                    'price' => 350,
                    'attributes' => ['surface_m2' => 45],
                ],
            ]],
            'job-offers' => ['items' => [
                [
                    'title' => 'مطلوب مطور تطبيقات موبايل (Flutter)',
                    'description' => 'شركة ناشئة تبحث عن مطور بخبرة سنتين على الأقل، دوام كامل.',
                    'price' => null,
                    'attributes' => ['contract_type' => 'full_time', 'experience_years' => 2],
                ],
                [
                    'title' => 'مطلوب محاسب/ة بخبرة',
                    'description' => 'شركة تجارية تبحث عن محاسب بخبرة في البرمجيات المحاسبية.',
                    'price' => null,
                    'attributes' => ['contract_type' => 'full_time'],
                ],
            ]],
            'job-seekers' => ['items' => [
                [
                    'title' => 'أبحث عن عمل في مجال التسويق الرقمي',
                    'description' => 'خبرة 3 سنوات في إدارة صفحات التواصل الاجتماعي والإعلانات الممولة.',
                    'price' => null,
                    'attributes' => ['field' => 'marketing', 'experience_years' => 3],
                ],
            ]],
            'phones-and-tablets' => ['items' => [
                [
                    'title' => 'iPhone 12 128GB بحالة ممتازة',
                    'description' => 'بطارية 89%، بلا خدوش، مع العلبة الأصلية والشاحن.',
                    'price' => 165,
                    'attributes' => ['brand' => 'Apple', 'model' => 'iPhone 12', 'storage_gb' => 128],
                ],
                [
                    'title' => 'Samsung Galaxy A54 جديد بالكرتونة',
                    'description' => 'لم يستعمل، مع الضمان، تحويل ألوان متوفر.',
                    'price' => 120,
                    'attributes' => ['brand' => 'Samsung', 'model' => 'Galaxy A54', 'storage_gb' => 128],
                ],
            ]],
            'computers-and-laptops' => ['items' => [
                [
                    'title' => 'Laptop HP Core i5 جيل 10 للبيع',
                    'description' => 'رام 8GB، تخزين SSD 256GB، مناسب للدراسة والعمل المكتبي.',
                    'price' => 145,
                    'attributes' => ['brand' => 'HP', 'cpu' => 'Core i5', 'ram_gb' => 8, 'storage_gb' => 256],
                ],
            ]],
            'home-appliances' => ['items' => [
                [
                    'title' => 'ثلاجة LG بحالة جيدة جداً',
                    'description' => 'استعمال سنتين، تبريد ممتاز، بلا أي أعطال.',
                    'price' => 95,
                    'attributes' => ['brand' => 'LG', 'type' => 'refrigerator'],
                ],
            ]],
            'tv-and-audio' => ['items' => [
                [
                    'title' => 'تلفاز Samsung Smart TV 55 بوصة',
                    'description' => 'حالة ممتازة، شاشة بلا أي خدوش، مع الريموت الأصلي.',
                    'price' => 135,
                    'attributes' => ['brand' => 'Samsung', 'size_inch' => 55, 'smart' => true],
                ],
            ]],
            'furniture' => ['items' => [
                [
                    'title' => 'طقم صالون 7 مقاعد بحالة جيدة',
                    'description' => 'قماش متين، بلا تمزقات، مناسب لصالون متوسط الحجم.',
                    'price' => 180,
                    'attributes' => ['seats' => 7, 'material' => 'fabric'],
                ],
            ]],
            'home-decor' => ['items' => [
                [
                    'title' => 'مجموعة لوحات ديكور جدارية',
                    'description' => 'تصميم عصري، مناسبة لغرفة الجلوس أو المكتب.',
                    'price' => 12,
                    'attributes' => [],
                ],
            ]],
            'mens-clothing' => ['items' => [
                [
                    'title' => 'دشداشة رجالية قماش صيفي مقاس L',
                    'description' => 'استعمال قليل، حالة ممتازة، لون أبيض كلاسيكي.',
                    'price' => 15,
                    'attributes' => ['size' => 'L', 'color' => 'white'],
                ],
            ]],
            'womens-clothing' => ['items' => [
                [
                    'title' => 'عباية تطريز فاخرة مقاس M',
                    'description' => 'لبس مرة واحدة فقط، حالة كالجديدة.',
                    'price' => 25,
                    'attributes' => ['size' => 'M'],
                ],
            ]],
            'watches-and-jewelry' => ['items' => [
                [
                    'title' => 'ساعة يد رجالية كلاسيكية',
                    'description' => 'حزام جلدي أصلي، آلية دقيقة، بحالة جيدة جداً.',
                    'price' => 32,
                    'attributes' => ['type' => 'watch'],
                ],
            ]],
            'home-services' => ['items' => [
                [
                    'title' => 'خدمات سباكة وتصليح تسربات المياه',
                    'description' => 'تدخل سريع، أسعار معقولة، خبرة أكثر من 10 سنوات.',
                    'price' => null,
                    'attributes' => ['service_type' => 'plumbing'],
                ],
            ]],
            'private-lessons' => ['items' => [
                [
                    'title' => 'دروس خصوصية في الرياضيات لتلاميذ الثانوي',
                    'description' => 'أستاذ بخبرة 8 سنوات، تحضير للامتحانات، حصص فردية أو جماعية.',
                    'price' => 8,
                    'attributes' => ['subject' => 'math', 'level' => 'high_school'],
                ],
            ]],
            'business-services' => ['items' => [
                [
                    'title' => 'خدمات تصميم مواقع وتطبيقات',
                    'description' => 'تصميم احترافي، أسعار تنافسية، متابعة بعد التسليم.',
                    'price' => null,
                    'attributes' => ['service_type' => 'web_design'],
                ],
            ]],
            'pets' => ['items' => [
                [
                    'title' => 'قطط شيرازي للبيع',
                    'description' => 'عمر شهرين، تطعيمات كاملة، تربية منزلية.',
                    'price' => 30,
                    'attributes' => ['species' => 'cat', 'breed' => 'Persian', 'age_months' => 2],
                ],
            ]],
            'pet-supplies' => ['items' => [
                [
                    'title' => 'قفص حيوانات أليفة متوسط الحجم',
                    'description' => 'استعمال قليل، نظيف، مناسب للقطط أو الكلاب الصغيرة.',
                    'price' => 9,
                    'attributes' => [],
                ],
            ]],
        ];
    }
}