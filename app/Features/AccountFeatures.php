<?php declare(strict_types=1);

namespace App\Features;

class AccountFeatures
{
    /**
     * Determine if the given feature is enabled.
     *
     * @param  string  $feature
     * @return bool
     */
    public static function enabled(string $feature): bool
    {
        return in_array($feature, config('features.account', []));
    }

    /**
     * Determine if the application can update a user's account information.
     *
     * @return bool
     */
    public static function hasAccountDeletionFeatures(): bool
    {
        return static::enabled(static::accountDeletionFeatures());
    }

    /**
     * Check if the account photo management is enabled.
     *
     * @return bool
     */
    public static function managesAccountPhotos(): bool
    {
        return static::enabled(static::accountPhotos());
    }

    /**
     * Enable the account deletion feature.
     *
     * @return string
     */
    public static function accountDeletionFeatures(): string
    {
        return 'account-deletion-features';
    }

    /**
     * Enable the account photo feature.
     *
     * @param array $options
     * @return string
     */
    public static function accountPhotos(array $options = []): string
    {
        if (! empty($options)) {
            config(['features-options.account-photos' => $options]);
        }

        return 'account-photos';
    }
}
