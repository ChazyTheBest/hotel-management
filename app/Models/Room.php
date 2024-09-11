<?php declare(strict_types=1);

namespace App\Models;

use App\Enums\BookingStatus;
use App\Traits\StaticTableName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

/**
 * Class Room
 *
 * @package App\Models
 *
 * @property int $id
 * @property int $type_id
 * @property int $floor
 * @property int $number
 * @property string $name
 * @property string $description
 * @property \App\Enums\RoomStatus $status
 * @property float $base_price
 * @property float $dynamic_price_factor
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 *
 * @property-read \App\Models\RoomType $type
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BedDefinition> $beds
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AmenityDefinition> $amenities
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ViewDefinition> $views
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PolicyDefinition> $policies
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Booking> $bookings
 * @property-read bool $isAvailable
 * @property-read array<int, string> $getUnavailableDates
 */
class Room extends Model
{
    use HasFactory;
    use SoftDeletes;
    use StaticTableName;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'room';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type_id',
        'status',
        'number',
        'capacity',
        'beds',
        'floor',
        'name',
        'description',
        'base_price',
        'dynamic_price_factor',
    ];

    /**
     * Get the type of room.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(RoomType::class);
    }

    /**
     * Get the beds associated with the room.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function beds(): BelongsToMany
    {
        return $this->belongsToMany(BedDefinition::class, 'bed_room');
    }

    /**
     * Get the amenities associated with the room.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function amenities(): BelongsToMany
    {
        return $this->belongsToMany(AmenityDefinition::class, 'amenity_room');
    }

    /**
     * Get the views associated with the room.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function view(): BelongsTo
    {
        return $this->belongsToMany(ViewDefinition::class, 'room_view');
    }

    /**
     * Get the policies associated with the room.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function policies(): HasMany
    {
        return $this->hasMany(PolicyDefinition::class, 'policy_room');
    }

    /**
     * Get the bookings for the room.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Whether the room is available or not.
     *
     * @param string $checkInDate The booking check in date.
     * @param string $checkOutDate The booking check out date.
     * @return bool True if the room is available, false otherwise.
     */
    public function isAvailable(string $checkInDate, string $checkOutDate): bool
    {
        $today = Carbon::today()->toDateString();

        // Check if the booking starts after or equal to today
        if ($checkInDate <= $today || $checkOutDate < $today) {
            return false; // Booking cannot start in the past
        }

        return !$this->bookings()->where('status', BookingStatus::CONFIRMED)
            ->where('check_in_date', '>=', $today)
            ->where(function($query) use ($checkInDate, $checkOutDate) {
                $query->whereBetween('check_in_date', [$checkInDate, $checkOutDate])
                    ->orWhereBetween('check_out_date', [$checkInDate, $checkOutDate])
                    ->orWhere(function($query) use ($checkInDate, $checkOutDate) {
                        $query->where('check_in_date', '<', $checkInDate)
                            ->where('check_out_date', '>', $checkOutDate);
                    });
            })
            ->exists();
    }

    /**
     * Get the room's unavailable dates.
     *
     * @return array<string, string>
     */
    public function getUnavailableDates(): array
    {
        // Fetch overlapping dates for all confirmed bookings
        return $this->bookings()
            ->where('room_id', $this->id)
            ->where('status', BookingStatus::CONFIRMED)
            ->where('check_out_date', '>=', Carbon::today()->toDateString())
            ->get(['check_in_date', 'check_out_date'])
            ->toArray();

/*        // Map bookings to the desired date range format
        return $bookings->map(function ($booking) {
            return [
                'startDate' => Carbon::parse($booking->check_in_date)->toDateString(),
                'endDate' => Carbon::parse($booking->check_out_date)->toDateString(),
            ];
        })->toArray();*/
    }
}
