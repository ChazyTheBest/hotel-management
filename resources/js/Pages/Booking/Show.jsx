import AppLayout from '@/Layouts/AppLayout';
import PageHeader from '@/Components/PageHeader';

const pageTitle = 'Booking details';

const Show = ({ booking, isAvailable, bookingEnum }) =>
  <AppLayout title={pageTitle} header={<PageHeader title={pageTitle}/>}>
    <div className="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
      <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-8">
        <div className="w-full rounded-lg text-center text-sm font-bold leading-6 text-white">
          <span className="font-semibold text-gray-600 dark:text-gray-500">{booking.room.number}</span>
          <h3 className="text-lg font-semibold text-gray-800 dark:text-gray-200">{booking.room.name}</h3>
          <p className="text-gray-500 dark:text-gray-400">{booking.room.description}</p>
          <p className="text-gray-500 dark:text-gray-400">
            {`Accommodation: ${booking.room.capacity} ${booking.room.capacity > 1 ? 'guests' : 'guest'}`}
          </p>
          <p className="text-gray-500 dark:text-gray-400">
            {`# of beds: ${booking.room.beds}`}
          </p>
          <p className="text-lg text-gray-400 dark:text-gray-300 mt-4">Booking Information:</p>
          <div className="mt-4">
            <p className="text-md font-medium text-gray-700 dark:text-gray-300">
              Contact Name: <span>{booking.profile.name}</span>
            </p>
            <p className="text-md font-medium text-gray-700 dark:text-gray-300">
              Contact Phone: <span>{booking.profile.phone}</span>
            </p>
          </div>
          <div className="flex flex-col md:flex-row mt-4 justify-center">
            <div className="mb-4 md:mb-0">
              <label htmlFor="check_in_date" className="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Check-in Date
              </label>
              <span>{booking.check_in_date}</span>
            </div>
            <div className="ml-0 md:ml-4">
              <label htmlFor="check_out_date" className="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Check-out Date
              </label>
              <span>{booking.check_out_date}</span>
            </div>
          </div>
          <div className="mt-4">
            <p className="text-md font-medium text-gray-700 dark:text-gray-300">
              Booking Status: {bookingEnum.text}
            </p>
          </div>
          <div className="mt-4">
            {booking.status === bookingEnum.CONFIRMED ?
              <p className="text-md font-medium text-gray-700 dark:text-gray-300">
                Total Paid: ${booking.room.price_per_night}
              </p>
            :
              <>
                <p className="text-md font-medium text-gray-700 dark:text-gray-300">
                  Total Due: ${booking.room.price_per_night}
                </p>
                {isAvailable ?
                  <a href={`/payment/mockup/${booking.payment.id}`}>
                    Retry payment
                  </a>
                :
                  <p className="text-md font-medium text-red-700 dark:text-red-300">
                    This room is no longer available for the chosen dates.
                  </p>
                }
              </>
            }
          </div>
        </div>
      </div>
    </div>
  </AppLayout>;

export default Show;
