import AppLayout from '@/Layouts/AppLayout';
import PageHeader from '@/Components/PageHeader';
import { Link } from '@inertiajs/react';

const pageTitle = 'Our Rooms';
const pageHeader = <PageHeader title={pageTitle} />;

const Index = ({ rooms }) =>
  <AppLayout title={pageTitle} header={pageHeader}>
    <div className="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
      <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-8 grid grild-cols-1 sm:grid-cols-2 sm:gap-2 md:grid-cols-4 md:gap-4 text-center text-sm font-bold leading-6">
        {rooms.map(room =>
          <Link
            key={room.id}
            href={route('room.show', room.id)}
            className="block rounded-lg dark:bg-indigo-900 bg-indigo-300 p-4 shadow-lg"
          >
            <h3 className="text-lg font-semibold text-gray-800 dark:text-gray-200">{room.name}</h3>
            <p className="text-gray-500 dark:text-gray-400">{room.description}</p>
          </Link>
        )}
      </div>
    </div>
  </AppLayout>;

export default Index;
