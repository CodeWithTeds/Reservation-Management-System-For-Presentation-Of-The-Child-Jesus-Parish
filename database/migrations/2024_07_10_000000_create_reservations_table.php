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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id('reservation_id');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('service_id')->constrained('services', 'service_id');
            $table->date('date_reserved');
            $table->time('time_start');
            $table->time('time_end');
            $table->enum('status', ['Pending', 'Approved', 'Cancelled'])->default('Pending');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};