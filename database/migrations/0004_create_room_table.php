<?php

use App\Models\Room;
use App\Models\RoomType;
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
        Schema::create(Room::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->foreignTinyId(RoomType::getFK())->constrained(RoomType::getTableName());
            $table->tinyInteger('floor');
            $table->smallInteger('number')->unique();
            $table->string('name')->unique();
            $table->text('description');
            $table->tinyInteger('status')->default(\App\Enums\RoomStatus::OUT_OF_SERVICE);
            $table->decimal('base_price', 8, 2);
            $table->decimal('dynamic_price_factor', 5, 2);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(Room::getTableName());
    }
};
