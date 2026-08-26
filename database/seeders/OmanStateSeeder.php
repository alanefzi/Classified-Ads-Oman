<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\State;
use Illuminate\Database\Seeder;

class OmanStateSeeder extends Seeder
{
    /**
     * يزرع 11 محافظة عُمانية رسمية (عربي/إنجليزي فقط).
     */
    public function run(): void
    {
        // كل الأعمدة الإجبارية بجدول countries: code, name_ar, name_en, currency, phone_code
        $oman = Country::firstOrCreate(
            ['name_en' => 'Oman'],
            [
                'name_ar'    => 'عُمان',
                'code'       => 'OM',
                'currency'   => 'OMR',
                'phone_code' => '+968',
            ]
        );

        $governorates = [
            ['name_ar' => 'مسقط',            'name_en' => 'Muscat'],
            ['name_ar' => 'ظفار',            'name_en' => 'Dhofar'],
            ['name_ar' => 'مسندم',           'name_en' => 'Musandam'],
            ['name_ar' => 'البريمي',         'name_en' => 'Al Buraimi'],
            ['name_ar' => 'الداخلية',        'name_en' => 'Ad Dakhiliyah'],
            ['name_ar' => 'شمال الباطنة',    'name_en' => 'North Al Batinah'],
            ['name_ar' => 'جنوب الباطنة',    'name_en' => 'South Al Batinah'],
            ['name_ar' => 'شمال الشرقية',    'name_en' => 'North Ash Sharqiyah'],
            ['name_ar' => 'جنوب الشرقية',    'name_en' => 'South Ash Sharqiyah'],
            ['name_ar' => 'الظاهرة',         'name_en' => 'Ad Dhahirah'],
            ['name_ar' => 'الوسطى',          'name_en' => 'Al Wusta'],
        ];

        foreach ($governorates as $gov) {
            State::updateOrCreate(
                ['name_en' => $gov['name_en'], 'country_id' => $oman->id],
                [
                    'name_ar'    => $gov['name_ar'],
                    'country_id' => $oman->id,
                ]
            );
        }

        $this->command->info('✅ تم زرع 11 محافظة عُمانية بنجاح.');
    }
}
