<?php declare(strict_types=1);

namespace App\Models;

use App\Traits\StaticTableName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class BedDefinition
 *
 * @package App\Models
 *
 * @property int $id
 */
class BedDefinition extends Model
{
    use HasFactory;
    use SoftDeletes;
    use StaticTableName;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bed_definition';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * The rooms that have this bed.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function rooms(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Room::class, 'bed_room');
    }
}
