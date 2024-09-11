import { useEffect, useState, useRef } from 'react';
import { useForm } from '@inertiajs/react';
import InputLabel from '@/Components/InputLabel';
import InputError from '@/Components/InputError';
import PrimaryButton from '@/Components/PrimaryButton';
import SecondaryButton from '@/Components/SecondaryButton';
import ActionSection from '@/Components/ActionSection';
import Datepicker from 'react-tailwindcss-datepicker';

const CheckBookingForm = ({ room, checkInDateMin, checkOutDateMin, initialUnavailableDates }) => {
  const [ unavailableDates, setUnavailableDates ] = useState([]);
  const [ selectedDates, setSelectedDates ] = useState({
    startDate: null,
    endDate: null
  });
  const totalPriceRef = useRef(null);
  const checkBookingForm = useForm({
    room_id: room.id,
    check_in_date: null,
    check_out_date: null
  });

  useEffect(() => {
    setUnavailableDates(initialUnavailableDates.map(dates => ({
      startDate: dates.check_in_date,
      endDate: dates.check_out_date
    })));
  }, []);

/*  useEffect(() => {
    window.Echo.channel(`room.${room.id}`)
      .listen('BookingCreated', (e) => {
        setUnavailableDates((prevDates) => [...prevDates, e.booking.date]);
      });
  }, [room.id]);*/

  const calculateTotalPrice = () => {
    const checkInDate = new Date(checkBookingForm.data.check_in_date);
    const checkOutDate = new Date(checkBookingForm.data.check_out_date);
    const dayDifference = (checkOutDate - checkInDate) / (1000 * 3600 * 24);
    const totalPrice = totalPriceRef.current.querySelector('span');

    if (dayDifference > 0) {
      totalPrice.textContent = (dayDifference * room.price_per_night).toFixed(2);
    }
  }

  const handleOnChange = dates => {
    setSelectedDates(dates);
    checkBookingForm.setData(previousData => ({
      ...previousData,
      check_in_date: dates.startDate,
      check_out_date: dates.endDate,
    }));
  };

  const checkAvailability = e => {
    e.preventDefault();

    checkBookingForm.post(route('room.check', { room: room }), {
      preserveScroll: true,
    });
  };

  return (
    <ActionSection
      title="Booking Room"
      description={`Room name: ${room.name}`}
    >
      <span className="font-semibold text-gray-600 dark:text-gray-500">{room.number}</span>
      <h3 className="text-lg font-semibold text-gray-800 dark:text-gray-200">{room.name}</h3>
      <p className="text-gray-500 dark:text-gray-400">{room.description}</p>
      <p className="text-gray-500 dark:text-gray-400">
        {room.capacity === 1 ? 'Accommodation: 1 guest' : `Accommodation: ${room.capacity} guests`}
      </p>
      <p className="text-gray-500 dark:text-gray-400">
        # of beds: {room.beds}
      </p>

      <InputLabel htmlFor="dates" value="Select Booking Dates" />
      <Datepicker
        id="dates"
        minDate={new Date(checkInDateMin)}
        disabledDates={unavailableDates}
        value={selectedDates}
        onChange={handleOnChange}
      />
      <InputError message={checkBookingForm.errors.check_in_date} className="mt-2" />
      <InputError message={checkBookingForm.errors.check_out_date} className="mt-2" />

      <div className="mt-4">
        <p className="text-sm font-medium text-gray-700 dark:text-gray-300">
          Price Per Night: ${room.price_per_night}
        </p>
        <p ref={totalPriceRef} className="text-md font-medium text-gray-700 dark:text-gray-300">
          Total Price: $<span>{room.price_per_night}</span>
        </p>
      </div>

      <div className="mt-5">
        <InputError message={checkBookingForm.errors.room_id} className="mb-2" />
        <SecondaryButton className="me-3" onClick={calculateTotalPrice}>
          Calculate
        </SecondaryButton>
        <PrimaryButton type="button" onClick={checkAvailability} disabled={checkBookingForm.processing}>
          Book now
        </PrimaryButton>
      </div>
    </ActionSection>
  );
};

export default CheckBookingForm;
