<?php declare(strict_types=1);

namespace App\Models;

use App\Traits\StaticTableName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Task
 *
 * @property int $id
 * @property int $task_type_id
 * @property int|null $room_id
 * @property int|null $user_id
 * @property string $details
 * @property \App\Enums\TaskPriority $priority
 * @property \App\Enums\TaskStatus $status
 * @property \Illuminate\Support\Carbon|null $assigned_at
 * @property \Illuminate\Support\Carbon|null $due_at
 * @property \Illuminate\Support\Carbon|null $started_at
 * @property \Illuminate\Support\Carbon|null $completed_at
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 *
 * @property-read \App\Models\TaskType $task_type
 * @property-read \App\Models\Room $room
 * @property-read \App\Models\User $user
 */
class Task extends Model
{
    use HasFactory;
    use SoftDeletes;
    use StaticTableName;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'task';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'task_type_id',
        'room_id',
        'user_id',
        'details',
        'priority',
        'status'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, mixed>
     */
    protected function casts(): array
    {
        return [
            'priority' => \App\Enums\TaskPriority::class,
            'status' => \App\Enums\TaskStatus::class
        ];
    }

    /**
     * Get the task type of the task.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function taskType(): BelongsTo
    {
        return $this->belongsTo(TaskType::class);
    }

    /**
     * Get the room associated with the task.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Get the user assigned to the task.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
