<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Support\Carbon;
use Inertia\Inertia;
use App\Http\Requests\CheckBookingRequest;

class RoomController extends Controller
{
    public function index(): \Inertia\Response
    {
        return Inertia::render('Room/Index', [
            'rooms' => Room::all()
        ]);
    }

    public function show(Room $room): \Inertia\Response
    {
        $bookingMinDates = $this->getBookingMinDates();

        return Inertia::render('Room/Show', [
            'room' => $room,
            'checkInDateMin' => $bookingMinDates[0],
            'checkOutDateMin' => $bookingMinDates[1],
            'unAvailableDates' => $room->getUnavailableDates()
        ]);
    }

    public function check(CheckBookingRequest $request, Room $room): \Illuminate\Http\RedirectResponse
    {
        // Store check-in and check-out dates in session
        $request->session()->put('booking.dates', [
            'checkInDate' => $request->input('check_in_date'),
            'checkOutDate' => $request->input('check_out_date'),
        ]);

        return redirect()->route('booking.create', ['room' => $room]);
    }

    private function getBookingMinDates(): array
    {
        $now = Carbon::now();
        $today = $now->toDateString();

        $tomorrow = $now->copy()->addDay()->toDateString();
        $dayAfterTomorrow = $now->copy()->addDays(2)->toDateString();

        $request = new CheckBookingRequest;
        $rules = $request->rules();

        $checkInDateMin = null;
        $checkOutDateMin = $dayAfterTomorrow;

        if (in_array('after_or_equal:today', $rules['check_in_date'])) {
            $checkInDateMin = $today;
        } elseif (in_array('after:today', $rules['check_in_date'])) {
            $checkInDateMin = $tomorrow;
        }

        return [$checkInDateMin, $checkOutDateMin];
    }
}
