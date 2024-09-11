<?php

use App\Models\BedDefinition;
use App\Models\MattressType;
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
        Schema::create(BedDefinition::getTableName(), function (Blueprint $table) {
            $table->tinyId();
            $table->foreignTinyId('mattress_type_id')->constrained(MattressType::getTableName());
            $table->string('name');
            $table->string('size');
            $table->text('description')->nullable();
            $table->boolean('is_adjustable')->default(false);
            $table->integer('capacity')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(BedDefinition::getTableName());
    }
};
