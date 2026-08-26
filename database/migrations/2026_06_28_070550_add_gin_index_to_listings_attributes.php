<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('CREATE INDEX idx_listings_attributes ON listings USING GIN (attributes)');
    }

    public function down(): void
    {
        DB::statement('DROP INDEX IF EXISTS idx_listings_attributes');
    }
};