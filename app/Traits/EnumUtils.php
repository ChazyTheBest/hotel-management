<?php declare(strict_types=1);

namespace App\Traits;

/**
 * Utility trait for PHP 8.1+ enums.
 *
 * This trait provides convenient methods to get enum values,
 * options (name-value pairs) and the normalized name from an enum.
 *
 * This trait is intended to be used within PHP enums.
 */
trait EnumUtils
{
    /**
     * Get an array of all enum values.
     *
     * @return array
     */
    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get an array of options with 'id' as the enum value and 'name' as the enum name.
     *
     * @return array
     */
    public static function getOptions(): array
    {
        return array_map(fn ($case) => [
            'id' => $case->value,
            'name' => $case->getNormalizedName()
        ], self::cases());
    }

    /**
     * Get the normalized name of the enum case.
     *
     * @return string
     */
    public function getNormalizedName(): string
    {
        return ucfirst(strtolower($this->name));
    }
}
