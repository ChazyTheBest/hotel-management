<?php

use App\Models\Room;
use App\Models\RoomView;
use App\Models\ViewDefinition;
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
        Schema::create(RoomView::getTableName(), function (Blueprint $table) {
            $table->foreignId(Room::getFK())->constrained(Room::getTableName());
            $table->foreignTinyId(ViewDefinition::getFK())->constrained(ViewDefinition::getTableName());
            $table->timestamps();

            $table->primary([Room::getFK(), ViewDefinition::getFK()]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(RoomView::getTableName());
    }
};
