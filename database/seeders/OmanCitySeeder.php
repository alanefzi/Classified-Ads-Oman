<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\State;
use Illuminate\Database\Seeder;

class OmanCitySeeder extends Seeder
{
    /**
     * يزرع 61 ولاية عُمانية (عربي/إنجليزي فقط)، كل وحدة مربوطة بمحافظتها.
     * ⚠️ لازم يشتغل بعد OmanStateSeeder.
     */
    public function run(): void
    {
        $wilayatByGovernorate = [
            'Muscat' => [
                ['name_ar' => 'مسقط',     'name_en' => 'Muscat'],
                ['name_ar' => 'مطرح',     'name_en' => 'Mutrah'],
                ['name_ar' => 'بوشر',     'name_en' => 'Bausher'],
                ['name_ar' => 'السيب',    'name_en' => 'Seeb'],
                ['name_ar' => 'العامرات', 'name_en' => 'Al Amarat'],
                ['name_ar' => 'قريات',    'name_en' => 'Qurayyat'],
            ],
            'Dhofar' => [
                ['name_ar' => 'صلالة',   'name_en' => 'Salalah'],
                ['name_ar' => 'طاقة',    'name_en' => 'Taqah'],
                ['name_ar' => 'مرباط',   'name_en' => 'Mirbat'],
                ['name_ar' => 'رخيوت',   'name_en' => 'Rakhyut'],
                ['name_ar' => 'ضلكوت',   'name_en' => 'Dhalkut'],
                ['name_ar' => 'مقشن',    'name_en' => 'Muqshin'],
                ['name_ar' => 'شليم وجزر الحلانيات', 'name_en' => 'Shalim and the Hallaniyat Islands'],
                ['name_ar' => 'سدح',     'name_en' => 'Sadah'],
                ['name_ar' => 'ثمريت',   'name_en' => 'Thumrait'],
                ['name_ar' => 'المزيونة', 'name_en' => 'Al Mazyona'],
            ],
            'Musandam' => [
                ['name_ar' => 'خصب',        'name_en' => 'Khasab'],
                ['name_ar' => 'بخا',        'name_en' => 'Bukha'],
                ['name_ar' => 'دباء البيعة', 'name_en' => 'Daba Al-Bayah'],
                ['name_ar' => 'مدحاء',      'name_en' => 'Madha'],
            ],
            'Al Buraimi' => [
                ['name_ar' => 'البريمي',  'name_en' => 'Al Buraimi'],
                ['name_ar' => 'محضة',     'name_en' => 'Mahdah'],
                ['name_ar' => 'السنينة',  'name_en' => 'As-Sunaynah'],
            ],
            'Ad Dakhiliyah' => [
                ['name_ar' => 'نزوى',    'name_en' => 'Nizwa'],
                ['name_ar' => 'بهلاء',   'name_en' => 'Bahla'],
                ['name_ar' => 'منح',     'name_en' => 'Manah'],
                ['name_ar' => 'الحمراء', 'name_en' => 'Al-Hamra'],
                ['name_ar' => 'أدم',     'name_en' => 'Adam'],
                ['name_ar' => 'إزكي',    'name_en' => 'Izki'],
                ['name_ar' => 'سمائل',   'name_en' => 'Samail'],
                ['name_ar' => 'بدبد',    'name_en' => 'Bidbid'],
                ['name_ar' => 'الجبل الأخضر', 'name_en' => 'Jabal Akhdar'],
            ],
            'North Al Batinah' => [
                ['name_ar' => 'صحار',     'name_en' => 'Sohar'],
                ['name_ar' => 'شناص',     'name_en' => 'Shinas'],
                ['name_ar' => 'لوى',      'name_en' => 'Liwa'],
                ['name_ar' => 'صحم',      'name_en' => 'Saham'],
                ['name_ar' => 'الخابورة', 'name_en' => 'Al Khaburah'],
                ['name_ar' => 'السويق',   'name_en' => 'As Suwaiq'],
            ],
            'South Al Batinah' => [
                ['name_ar' => 'الرستاق',      'name_en' => 'Rustaq'],
                ['name_ar' => 'العوابي',      'name_en' => 'Al Awabi'],
                ['name_ar' => 'نخل',          'name_en' => 'Nakhal'],
                ['name_ar' => 'وادي المعاول', 'name_en' => "Wadi Al Ma'awil"],
                ['name_ar' => 'بركاء',        'name_en' => 'Barka'],
                ['name_ar' => 'المصنعة',      'name_en' => 'Al Musannah'],
            ],
            'North Ash Sharqiyah' => [
                ['name_ar' => 'إبراء',           'name_en' => 'Ibra'],
                ['name_ar' => 'القابل',          'name_en' => 'Al Qabil'],
                ['name_ar' => 'بدية',            'name_en' => 'Bidiyah'],
                ['name_ar' => 'وادي بني خالد',   'name_en' => 'Wadi Bani Khalid'],
                ['name_ar' => 'المضيبي',         'name_en' => 'Al Mudhaibi'],
                ['name_ar' => 'دماء والطائيين',  'name_en' => 'Dima Wa Al Tayeen'],
                ['name_ar' => 'سناو',            'name_en' => 'Sinaw'],
            ],
            'South Ash Sharqiyah' => [
                ['name_ar' => 'صور',              'name_en' => 'Sur'],
                ['name_ar' => 'الكامل والوافي',   'name_en' => 'Al Kamil Wal Wafi'],
                ['name_ar' => 'جعلان بني بو علي', 'name_en' => 'Jaalan Bani Bu Ali'],
                ['name_ar' => 'جعلان بني بو حسن', 'name_en' => 'Jaalan Bani Bu Hassan'],
                ['name_ar' => 'مصيرة',            'name_en' => 'Masirah'],
            ],
            'Ad Dhahirah' => [
                ['name_ar' => 'عبري',  'name_en' => 'Ibri'],
                ['name_ar' => 'ينقل',  'name_en' => 'Yanqul'],
                ['name_ar' => 'ضنك',   'name_en' => 'Dhank'],
            ],
            'Al Wusta' => [
                ['name_ar' => 'هيماء',  'name_en' => 'Haima'],
                ['name_ar' => 'الدقم',  'name_en' => 'Duqm'],
                ['name_ar' => 'محوت',   'name_en' => 'Mahout'],
                ['name_ar' => 'الجازر', 'name_en' => 'Al Jazir'],
            ],
        ];

        $totalInserted = 0;

        foreach ($wilayatByGovernorate as $governorateNameEn => $wilayats) {
            $state = State::where('name_en', $governorateNameEn)->first();

            if (! $state) {
                $this->command->warn("⚠️ المحافظة '{$governorateNameEn}' غير موجودة — شغّل OmanStateSeeder أولاً.");
                continue;
            }

            foreach ($wilayats as $wilaya) {
                City::updateOrCreate(
                    ['name_en' => $wilaya['name_en'], 'state_id' => $state->id],
                    [
                        'name_ar'  => $wilaya['name_ar'],
                        'state_id' => $state->id,
                    ]
                );
                $totalInserted++;
            }
        }

        $this->command->info("✅ تم زرع {$totalInserted} ولاية عُمانية موزعة على 11 محافظة (63 ولاية حسب آخر تحديث إداري).");
    }
}