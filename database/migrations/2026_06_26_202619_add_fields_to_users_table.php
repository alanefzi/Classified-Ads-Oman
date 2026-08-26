<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('country_id')->nullable()->after('id')->constrained();
            $table->foreignId('city_id')->nullable()->after('country_id')->constrained();
            $table->string('phone', 20)->nullable()->unique()->after('email');
            $table->timestamp('phone_verified_at')->nullable()->after('phone');
            $table->string('avatar')->nullable()->after('phone_verified_at');
            $table->boolean('is_business')->default(false)->after('avatar');
            $table->string('status', 20)->default('active')->after('is_business');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['country_id']);
            $table->dropForeign(['city_id']);
            $table->dropColumn([
                'country_id', 'city_id', 'phone', 'phone_verified_at',
                'avatar', 'is_business', 'status',
            ]);
        });
    }
};