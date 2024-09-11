<?php

namespace App\Models;

use App\Traits\StaticTableName;
use App\Traits\WithCompositeKey;
use Illuminate\Database\Eloquent\Relations\Pivot;

class BedRoom extends Pivot
{
    use StaticTableName;
    use WithCompositeKey;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bed_room';

    protected $primaryKey = ['room_id', 'bed_definition_id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'room_id',
        'bed_definition_id'
    ];
}
