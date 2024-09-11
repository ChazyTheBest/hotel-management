<?php declare(strict_types=1);

namespace App\Models;

use App\Enums\Role;
use App\Traits\HasAccountPhoto;
use App\Traits\StaticTableName;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;

/**
 * Class User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property \Illuminate\Support\Carbon|null $two_factor_confirmed_at
 * @property string|null $remember_token
 * @property string|null $photo_path
 * @property string|null $photo_url
 * @property \App\Enums\Role $role
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Profile[] $profiles
 * @property-read bool $ownsProfile
 * @property-read bool $hasRole
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Booking[] $bookings
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SpecialRate[] $specialRates
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Task[] $tasks
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory;
    use HasAccountPhoto;
    use Notifiable;
    use SoftDeletes;
    use StaticTableName;
    use TwoFactorAuthenticatable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'photo_url'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, mixed>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => Role::class
        ];
    }

    /**
     * Check if the user has a specific role.
     *
     * @param \App\Enums\Role $role The role to check.
     * @return bool
     */
    public function hasRole(Role $role): bool
    {
        return $this->role === $role;
    }

    /**
     * Check if the user has a specific role or higher.
     *
     * @param \App\Enums\Role $role The role to check.
     * @return bool
     */
    public function hasRoleOrHigher(Role $role): bool
    {
        return $this->role->value >= $role->value;
    }

    /**
     * Get the profiles associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function profiles(): HasMany
    {
        return $this->hasMany(Profile::class);
    }

    /**
     * Check if the user owns a profile with the given profile ID.
     *
     * @param mixed $profileId The ID of the profile.
     * @return bool True if the user owns the profile, false otherwise.
     */
    public function ownsProfile(mixed $profileId): bool
    {
        return $this->profiles()->where('id', $profileId)->exists();
    }

    /**
     * Get the bookings associated with the user through profiles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function bookings(): HasManyThrough
    {
        return $this->hasManyThrough(Booking::class, Profile::class);
    }

    /**
     * Get the special rates created by the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function specialRates(): HasMany
    {
        return $this->hasMany(SpecialRate::class);
    }

    /**
     * Get the tasks assigned to the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
