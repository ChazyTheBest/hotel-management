<?php

use App\Models\AmenityDefinition;
use App\Models\AmenityRoom;
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
        Schema::create(AmenityRoom::getTableName(), function (Blueprint $table) {
            $table->foreignId(Room::getFK())->constrained(Room::getTableName());
            $table->foreignTinyId(AmenityDefinition::getFK())->constrained(AmenityDefinition::getTableName());
            $table->timestamps();

            $table->primary([Room::getFK(), AmenityDefinition::getFK()]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(AmenityRoom::getTableName());
    }
};
