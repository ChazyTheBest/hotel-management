import AppLayout from '@/Layouts/AppLayout';
import DeleteUserForm from '@/Pages/Account/Partials/DeleteUserForm';
import LogoutOtherBrowserSessionsForm from '@/Pages/Account/Partials/LogoutOtherBrowserSessionsForm';
import PageHeader from '@/Components/PageHeader';
import SectionBorder from '@/Components/SectionBorder';
import TwoFactorAuthenticationForm from '@/Pages/Account/Partials/TwoFactorAuthenticationForm';
import UpdatePasswordForm from '@/Pages/Account/Partials/UpdatePasswordForm';
import UpdateAccountInformationForm from '@/Pages/Account/Partials/UpdateAccountInformationForm';

const pageTitle = 'Account';
const pageHeader = <PageHeader title={pageTitle} />;

const Show = ({ confirmsTwoFactorAuthentication, sessions, fortify, auth }) =>
  <AppLayout title={pageTitle} header={pageHeader}>
    <div className="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
      {fortify.canUpdateAccountInformation &&
        <>
          <UpdateAccountInformationForm user={auth.user} />
          <SectionBorder />
        </>
      }

      {fortify.canUpdatePassword &&
        <>
          <UpdatePasswordForm className="mt-10 sm:mt-0" />
          <SectionBorder />
        </>
      }

      {fortify.canManageTwoFactorAuthentication &&
        <>
          <TwoFactorAuthenticationForm
            user={auth.user}
            requiresConfirmation={confirmsTwoFactorAuthentication}
            className="mt-10 sm:mt-0"
          />
          <SectionBorder />
        </>
      }

      <LogoutOtherBrowserSessionsForm
        sessions={sessions}
        className="mt-10 sm:mt-0"
      />

      {auth.user.hasAccountDeletionFeatures &&
        <>
          <SectionBorder />
          <DeleteUserForm className="mt-10 sm:mt-0" />
        </>
      }
    </div>
  </AppLayout>;

export default Show;
