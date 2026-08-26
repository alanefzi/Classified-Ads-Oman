<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // نستخدم SQL مباشر (بدل ->nullable()->change()) لتجنب الاعتماد على حزمة doctrine/dbal
        if (Schema::hasColumn('pages', 'title_fr')) {
            DB::statement('ALTER TABLE pages ALTER COLUMN title_fr DROP NOT NULL');
        }
        if (Schema::hasColumn('pages', 'content_fr')) {
            DB::statement('ALTER TABLE pages ALTER COLUMN content_fr DROP NOT NULL');
        }
    }

    public function down(): void
    {
        // نتركها Nullable حتى بالتراجع — إرجاعها NOT NULL قد يفشل لو فيه صفوف فاضية أصلاً
    }
};
