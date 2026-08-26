<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('faqs', 'question_fr')) {
            DB::statement('ALTER TABLE faqs ALTER COLUMN question_fr DROP NOT NULL');
        }
        if (Schema::hasColumn('faqs', 'answer_fr')) {
            DB::statement('ALTER TABLE faqs ALTER COLUMN answer_fr DROP NOT NULL');
        }
    }

    public function down(): void
    {
        // نتركها Nullable حتى بالتراجع
    }
};
