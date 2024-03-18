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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('status')->default(true);
            $table->boolean('edit_self')->default(false);
            $table->boolean('edit_other')->default(false);
            $table->boolean('edit_date_self')->default(false);
            $table->boolean('edit_date_other')->default(false);
            $table->boolean('create_appointment')->default(false);
            $table->boolean('delete_appointment')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
