<?php

use App\Models\Booking;
use App\Models\Profile;
use App\Models\Room;
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
        Schema::create(Booking::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->foreignId(Profile::getFK())->constrained(Profile::getTableName());
            $table->foreignId(Room::getFK())->constrained(Room::getTableName());
            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->tinyInteger('status')->default(\App\Enums\BookingStatus::PENDING);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(Booking::getTableName());
    }
};
