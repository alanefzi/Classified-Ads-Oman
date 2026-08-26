<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\State;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class OmanGeoDatabaseSeeder extends Seeder
{
    /**
     * ينضّف بيانات المعتمديات التونسية القديمة ثم يزرع بيانات عُمان الصحيحة.
     *
     * تشغيل:
     * php artisan db:seed --class=Database\\Seeders\\OmanGeoDatabaseSeeder
     *
     * ⚠️ لو عندك جداول ثانية مربوطة بـ cities (زي listings) بـ foreign key
     * بدون onDelete('cascade') أو onDelete('set null')، لازم تتأكد منها
     * قبل التصفير وإلا رح تطلعلك SQL error.
     */
    public function run(): void
    {
        $this->command->warn('🧹 جاري تصفير بيانات المعتمديات/الولايات التونسية القديمة...');

        Schema::disableForeignKeyConstraints();
        City::query()->delete();
        State::query()->delete();
        Schema::enableForeignKeyConstraints();

        $this->command->info('✅ تم التصفير. جاري زرع بيانات عُمان...');

        $this->call([
            OmanStateSeeder::class,
            OmanCitySeeder::class,
        ]);

        $this->command->info('🎉 تم بنجاح: 11 محافظة + 61 ولاية عُمانية جاهزة.');
    }
}
