<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
        Schema::table('services', function (Blueprint $table) {
            $table->foreignId('category_id')->constrained();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
