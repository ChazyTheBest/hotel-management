import AppLayout from '@/Layouts/AppLayout';
import PageHeader from '@/Components/PageHeader';
import CheckBookingForm from '@/Pages/Room/Partials/CheckBookingForm';

const pageTitle = 'Room Booking';

const Show = ({ room, checkInDateMin, checkOutDateMin, unAvailableDates }) =>
  <AppLayout title={pageTitle} header={<PageHeader title={room.name}/>}>
    <div className="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
      <CheckBookingForm
        room={room}
        checkInDateMin={checkInDateMin}
        checkOutDateMin={checkOutDateMin}
        initialUnavailableDates={unAvailableDates}
      />
    </div>
  </AppLayout>;

export default Show;
