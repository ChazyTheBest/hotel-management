<?php

use App\Models\Room;
use App\Models\RoomType;
use App\Models\SpecialRate;
use App\Models\User;
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
        Schema::create(SpecialRate::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->foreignId(Room::getFK())->nullable()->constrained(Room::getTableName());
            $table->foreignTinyId(RoomType::getFK())->nullable()->constrained(RoomType::getTableName());
            $table->foreignId(User::getFK())->nullable()->constrained(User::getTableName());
            $table->decimal('discount_factor', 5, 2);
            $table->string('code');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(SpecialRate::getTableName());
    }
};
