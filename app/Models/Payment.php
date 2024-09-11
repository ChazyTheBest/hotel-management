<?php declare(strict_types=1);

namespace App\Models;

use App\Traits\StaticTableName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Payment
 *
 * @property int $id
 * @property int $booking_id
 * @property \App\Enums\PaymentStatus $status
 * @property array|null $response_data
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 *
 * @property-read \App\Models\Booking $booking
 * @property-read \App\Models\BillingInfo $billingInfo
 * @property-read \App\Models\Invoice|null $invoice
 */
class Payment extends Model
{
    use HasFactory;
    use SoftDeletes;
    use StaticTableName;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'payment';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'booking_id',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => \App\Enums\PaymentStatus::class,
            'response_data' => 'array',
        ];
    }

    /**
     * Get the booking associated with the payment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Get the payment billing information.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function billingInfo(): HasOne
    {
        return $this->hasOne(BillingInfo::class);
    }

    /**
     * Store or append response data.
     *
     * @param array $response
     * @return void
     */
    public function handleResponseData(array $response): void
    {
        $responses = $this->response_data ?? [];
        $responses[] = $response;
        $this->response_data = $responses;
    }

    /**
     * Get the invoice associated with the payment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class);
    }
}
