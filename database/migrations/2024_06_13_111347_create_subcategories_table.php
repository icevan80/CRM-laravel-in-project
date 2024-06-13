<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subcategories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('presentation_name')->nullable();
            $table->string('full_name');
            $table->foreignId('category_id')->constrained();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
        Schema::table('services', function (Blueprint $table) {
            $table->foreignId('subcategory_id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subcategories');
    }
};
