<?php declare(strict_types=1);

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Room;

class RoomAvailability implements DataAwareRule, ValidationRule
{
    /**
     * All the data under validation.
     *
     * @var array<string, mixed>
     */
    protected array $data = [];

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->data || !$this->data['check_in_date'] || !$this->data['check_out_date']) {
            return;
        }

        // Retrieve the room by ID
        $room = Room::find($value);

        if ($room->doesntExist()) {
            $fail('Unknown error. Please, try again later.');
            return;
        }

        // Check room availability for the given dates
        if (!$room->isAvailable($this->data['check_in_date'], $this->data['check_out_date'])) {
            $fail('The room is not available for the selected dates.');
        }
    }

    /**
     * Set the data under validation.
     *
     * @param  array<string, mixed>  $data
     */
    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }
}
