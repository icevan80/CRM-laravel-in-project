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
        Schema::create('preferences', function (Blueprint $table) {
            $table->id();
            $table->boolean('manage_appointment')->default(false);
            $table->boolean('create_appointment')->default(false);
            $table->boolean('edit_appointment')->default(false);
            $table->boolean('edit_date_appointment')->default(false);
            $table->boolean('delete_appointment')->default(false);
            $table->boolean('edit_other_appointment')->default(false);
            $table->boolean('edit_translations')->default(false);
            $table->boolean('manage_users')->default(false);
            $table->boolean('manage_locations')->default(false);
            $table->boolean('manage_services')->default(false);
            $table->boolean('manage_categories')->default(false);
            $table->boolean('manage_deals')->default(false);
            $table->boolean('edit_preferences')->default(false);
            $table->boolean('edit_users')->default(false);
            $table->boolean('edit_locations')->default(false);
            $table->boolean('edit_services')->default(false);
            $table->boolean('edit_categories')->default(false);
            $table->boolean('edit_deals')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preferences');
    }
};
