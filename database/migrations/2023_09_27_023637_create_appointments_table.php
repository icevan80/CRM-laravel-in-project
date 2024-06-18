<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('appointment_code')->unique();
            $table->foreignId('creator_id')->constrained('users');
            //TODO: поменять на зависиммость от таблицы master
            $table->foreignId('implementer_id')->constrained('users');
            $table->string('receiving_name');
            $table->string('receiving_description')->default('');
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->foreignId('location_id')->constrained();
            $table->foreignId('service_id')->constrained();
            $table->double('total', 10, 2)->default(0);
            $table->boolean('referral')->default(false);
            $table->boolean('complete')->default(false);
            $table->enum('progress', array('waiting', 'arrive', 'not_arrive', 'complete'))->default('waiting');
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
