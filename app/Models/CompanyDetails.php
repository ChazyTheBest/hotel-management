<?php declare(strict_types=1);

namespace App\Models;

use App\Traits\StaticTableName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyDetails extends Model
{
    use HasFactory;
    use StaticTableName;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'company_details';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'address',
        'city',
        'state',
        'postal_code',
        'country',
        'vat_number',
    ];
}
