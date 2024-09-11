<?php

use App\Models\Booking;
use App\Models\Payment;
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
        Schema::create(Payment::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->foreignId(Booking::getFK())->constrained(Booking::getTableName());
            $table->tinyInteger('status')->default(\App\Enums\PaymentStatus::PENDING);
            $table->json('response_data')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(Payment::getTableName());
    }
};
