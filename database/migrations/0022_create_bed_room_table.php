<?php

use App\Models\BedRoom;
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
        Schema::create(BedRoom::getTableName(), function (Blueprint $table) {
            $table->foreignTinyId(PolicyDefinition::getFK())->constrained(PolicyDefinition::getTableName());
            $table->foreignTinyId(PolicyDefinition::getFK())->constrained(PolicyDefinition::getTableName());
            $table->timestamps();

            $table->primary([Room::getFK(), PolicyDefinition::getFK()]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(BedRoom::getTableName());
    }
};
