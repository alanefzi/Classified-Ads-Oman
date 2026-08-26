<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone'); // للاتصال (مثال: +96890000000)
            $table->string('whatsapp')->nullable(); // لو فاضي، نستخدم رقم الهاتف نفسه للواتساب
            $table->string('city')->nullable(); // اختياري: المنطقة اللي يغطيها المندوب
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agents');
    }
};
