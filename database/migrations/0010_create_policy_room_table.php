<?php

use App\Models\PolicyDefinition;
use App\Models\PolicyRoom;
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
        Schema::create(PolicyRoom::getTableName(), function (Blueprint $table) {
            $table->foreignId(Room::getFK())->constrained(Room::getTableName());
            $table->foreignTinyId(PolicyDefinition::getFK())->constrained(PolicyDefinition::getTableName());
            $table->boolean('is_allowed')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->primary([Room::getFK(), PolicyDefinition::getFK()]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(PolicyRoom::getTableName());
    }
};
