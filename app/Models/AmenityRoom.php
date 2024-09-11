<?php declare(strict_types=1);

namespace App\Models;

use App\Traits\StaticTableName;
use App\Traits\WithCompositeKey;
use Illuminate\Database\Eloquent\Relations\Pivot;

class AmenityRoom extends Pivot
{
    use StaticTableName;
    use WithCompositeKey;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'amenity_room';

    protected $primaryKey = ['room_id', 'amenity_definition_id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'room_id',
        'amenity_definition_id'
    ];
}
