import { useEffect } from 'react';
import { useForm } from '@inertiajs/react';
import FormSection from '@/Components/FormSection';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import Select from '@/Components/Select';
import Checkbox from '@/Components/Checkbox';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';

const CreateBookingForm = ({ room, profiles, checkInDate, checkOutDate }) => {
  const defaultProfile = profiles[0];
  const createBookingForm = useForm({
    room_id: room.id,
    profile_id: defaultProfile?.id,
    payment_method: null,
    check_in_date: checkInDate,
    check_out_date: checkOutDate,
    address: defaultProfile?.address,
    city: defaultProfile?.city,
    state: defaultProfile?.state,
    postal_code: defaultProfile?.postal_code,
    country: defaultProfile?.country,
  });

  useEffect(() => {
    const selectedProfile = profiles.find(p => parseInt(p.id) === parseInt(createBookingForm.data.profile_id));

    createBookingForm.setData(previousData => ({
      ...previousData,
      address: selectedProfile.address,
      city: selectedProfile.city,
      state: selectedProfile.state,
      postal_code: selectedProfile.postal_code,
      country: selectedProfile.country,
    }));
  }, [createBookingForm.data.profile_id]);

  const handleOnChangeSelect = profileId => createBookingForm.setData('profile_id', profileId);
  const handleOnChangeCheckbox = value => createBookingForm.setData('payment_method', value);
  const handleOnChange = e => createBookingForm.setData(e.target.id, e.target.value);

  const submit = e => {
    e.preventDefault();

    createBookingForm.post(route('booking.store', { room }), {
      preserveScroll: true,
    });
  };

  return (
    <FormSection
      title={`Booking ${room.name}`}
      description={
        <>
          <span>We just need a few details before we can book the room for you.</span>
          <span className="block mt-2">Check-in Date: {checkInDate}</span>
          <span className="block mt-2">Check-out Date: {checkOutDate}</span>
          <span className="block mt-2">Room Price per Night: {room.price_per_night}</span>
        </>
      }
      form={
        <>
          <div className="col-span-6 sm:col-span-4">
            <InputLabel htmlFor="profiles" value="Select Profile" />
            <Select
              id="profiles"
              value={createBookingForm.data.profile_id}
              onChange={handleOnChangeSelect}
              className="mt-1"
              options={profiles}
              required
            />
            <InputError message={createBookingForm.errors.profile_id} className="mt-2" />
          </div>

          <div className="col-span-6 sm:col-span-4">
            <InputLabel value="Select Payment Method" />
            <div className="mt-2">
              <div className="flex">
                <Checkbox
                  id="credit_debit"
                  type="radio"
                  value="1"
                  onChange={handleOnChangeCheckbox}
                  className="mr-2"
                  name="payment_method"
                  required
                />
                <InputLabel htmlFor="credit_debit" value="Credit/Debit Card" />
              </div>
              <div className="flex items-center mt-2">
                <Checkbox
                  id="paypal"
                  type="radio"
                  value="2"
                  onChange={handleOnChangeCheckbox}
                  className="mr-2"
                  name="payment_method"
                  required
                />
                <InputLabel htmlFor="paypal" value="PayPal" />
              </div>
              <InputError message={createBookingForm.errors.payment_method} className="mt-2" />
            </div>
          </div>

          <div className="col-span-6 sm:col-span-4">
            <InputLabel value="Billing Information" className="col-span-6 sm:col-span-4" />

            <InputLabel htmlFor="address" value="Address" className="mt-2" />
            <TextInput
              id="address"
              value={createBookingForm.data.address}
              onChange={handleOnChange}
              className="mt-1 block w-full"
              required
              autoComplete="address"
            />
            <InputError message={createBookingForm.errors.address} className="mt-2" />

            <InputLabel htmlFor="city" value="City" className="mt-2" />
            <TextInput
              id="city"
              value={createBookingForm.data.city}
              onChange={handleOnChange}
              className="mt-1 block w-full"
              required
              autoComplete="city"
            />
            <InputError message={createBookingForm.errors.city} className="mt-2" />

            <InputLabel htmlFor="state" value="State" className="mt-2" />
            <TextInput
              id="state"
              value={createBookingForm.data.state}
              onChange={handleOnChange}
              className="mt-1 block w-full"
              required
              autoComplete="state"
            />
            <InputError message={createBookingForm.errors.state} className="mt-2" />

            <InputLabel htmlFor="postal_code" value="Postal Code" className="mt-2" />
            <TextInput
              id="postal_code"
              value={createBookingForm.data.postal_code}
              onChange={handleOnChange}
              className="mt-1 block w-full"
              required
              autoComplete="postal_code"
            />
            <InputError message={createBookingForm.errors.postal_code} className="mt-2" />

            <InputLabel htmlFor="country" value="Country" className="mt-2" />
            <TextInput
              id="country"
              value={createBookingForm.data.country}
              onChange={handleOnChange}
              className="mt-1 block w-full"
              required
              autoComplete="country"
            />
            <InputError message={createBookingForm.errors.country} className="mt-2" />
          </div>
        </>
      }
      actions={
        <>
          <InputError message={createBookingForm.errors.room_id} className="me-2" />
          <PrimaryButton disabled={createBookingForm.processing}>
            Book now
          </PrimaryButton>
        </>
      }
      onSubmit={submit}
    />
  );
};

export default CreateBookingForm;
