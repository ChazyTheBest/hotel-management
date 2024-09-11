<?php

use App\Models\Room;
use App\Models\Task;
use App\Models\TaskType;
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
        Schema::create(Task::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->foreignTinyId(TaskType::getFK())->constrained(TaskType::getTableName());
            $table->foreignId(Room::getFK())->nullable()->constrained(Room::getTableName());
            $table->foreignId(User::getFK())->nullable()->constrained(User::getTableName());
            $table->text('details');
            $table->tinyInteger('priority')->default(\App\Enums\TaskPriority::LOW);
            $table->tinyInteger('status')->default(\App\Enums\TaskStatus::PENDING);
            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('due_at')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(Task::getTableName());
    }
};
