<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Models\Profile;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use App\Http\Requests\StoreBillingInfoRequest;
use App\Http\Requests\StoreBookingRequest;

class BookingController extends Controller
{
    public function index(Request $request): \Inertia\Response
    {
        $user = $request->user();

        // Fetch the user's bookings with eager loading of profile and room
        $bookings = $user->bookings()->with('profile', 'room')->get();

        return Inertia::render('Booking/Index', compact('bookings'));
    }

    public function create(Request $request, Room $room): \Illuminate\Http\RedirectResponse|\Inertia\Response
    {
        $bookingDates = $request->session()->get('booking.dates');

        if (!$bookingDates) {
            return redirect()->route('room.show', ['room' => $room]);
        }

        return Inertia::render('Booking/Create', [
            'room' => $room,
            'profiles' => Profile::all(),
            ...$bookingDates
        ]);
    }

    public function store(StoreBookingRequest $bookingRequest, StoreBillingInfoRequest $billingInfoRequest, Room $room): \Illuminate\Http\RedirectResponse|null
    {
        // Rollback on insert error
        DB::transaction(function () use ($bookingRequest, $billingInfoRequest, $room) {
            // Step 1: Create booking
            $booking = Profile::find($bookingRequest->get('profile_id'))->bookings()->create([
                'room_id' => $room->id,
                'check_in_date' => $bookingRequest->get('check_in_date'),
                'check_out_date' => $bookingRequest->get('check_out_date'),
            ]);

            // Step 2: Create payment
            $payment = $booking->payment()->create();

            // Step 3: Create billing info
            $billing_info = $payment->billingInfo()->create([
                'address' => $billingInfoRequest->get('address'),
                'city' => $billingInfoRequest->get('city'),
                'state' => $billingInfoRequest->get('state'),
                'postal_code' => $billingInfoRequest->get('postal_code'),
                'country' => $billingInfoRequest->get('country'),
                'payment_id' => $payment->id,
            ]);

            return redirect()->route('payment.mockup', [
                'payment' => $payment
            ]);
        });

        return null;
    }

    public function show(Booking $booking): \Inertia\Response
    {
        $booking->load('profile', 'room');
        $room = $booking->room;

        return Inertia::render('Booking/Show', [
            'booking' => $booking,
            'isAvailable' => $room->isAvailable($booking->check_in_date, $booking->check_out_date),
            'bookingEnum' => [
                'CONFIRMED' => BookingStatus::CONFIRMED,
                'text' => $booking->status->name
            ]
        ]);
    }
}
