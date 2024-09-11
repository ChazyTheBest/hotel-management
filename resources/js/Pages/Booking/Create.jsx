import AppLayout from '@/Layouts/AppLayout';
import PageHeader from '@/Components/PageHeader';
import CreateBookingForm from '@/Pages/Booking/Partials/CreateBookingForm';

const pageTitle = 'Room Booking';

const Create = ({ room, profiles, checkInDate, checkOutDate }) =>
  <AppLayout title={pageTitle} header={<PageHeader title={`Booking ${room.name}`}/>}>
    <div className="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
      <CreateBookingForm
        room={room}
        profiles={profiles}
        checkInDate={checkInDate}
        checkOutDate={checkOutDate}
      />
    </div>
  </AppLayout>;

export default Create;
