import { useState } from 'react';
import { Bars3Icon, XMarkIcon } from '@heroicons/react/24/outline';
import { Head, Link, router, usePage } from '@inertiajs/react';
import { useAuth } from '@/contexts';
import ApplicationMark from '@/Components/ApplicationMark';
import Banner from '@/Components/Banner';
import NavLink from '@/Components/NavLink';
import NavLinks from './Partials/NavLinks';
import SettingsDropdown from './Partials/SettingsDropdown';
import ThemesDropdown from './Partials/ThemesDropdown';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink';

const switchToTeam = team => () =>
  router.put(route('current-team.update'), {
    team_id: team.id,
  }, {
    preserveState: false,
  });

const AppLayout = ({ title, header, children }) => {
  const [ showingNavigationDropdown, setShowingNavigationDropdown ] = useState(false);

  const { canLogin, canRegister } = usePage().props.fortify;

  const { authenticated, user, logout } = useAuth();

  return <>
    <Head title={title} />

    <Banner />

    <div className="min-h-screen bg-gray-100 dark:bg-gray-900">
      <nav className="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
        {/* Primary Navigation Menu */}
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="flex justify-between h-16">
            <div className="flex">
              {/* Logo */}
              <div className="shrink-0 flex items-center">
                <Link href={route('home')}>
                  <ApplicationMark className="block h-9 w-auto" />
                </Link>
              </div>

              {/* Navigation Links */}
              <div className="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                <NavLinks authenticated={authenticated} Component={NavLink} />
              </div>
            </div>

            <div className="hidden sm:flex sm:items-center sm:ml-6">
              {/* Themes Dropdown */}
              <ThemesDropdown />

              {authenticated ?
                <>
                  {/* Teams Dropdown */}
{/*                  {jetstream.hasTeamFeatures &&
                    <TeamsDropdown user={user} className="ms-3" jetstream={jetstream} switchToTeam={switchToTeam} />
                  }*/}

                  {/* Settings Dropdown */}
                  <SettingsDropdown className="ms-3" user={user} logout={logout} />
                </>
              :
                <>
                  {canLogin &&
                    <>
                      <Link
                        href={route('login')}
                        className="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                      >
                        Log in
                      </Link>

                      {canRegister &&
                        <Link
                          href={route('register')}
                          className="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                          Register
                        </Link>
                      }
                    </>
                  }
                </>
              }
            </div>

            <div className="-me-2 flex items-center sm:hidden">
              <ThemesDropdown />

              {/* Hamburger */}
              <button
                className="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out"
                onClick={() => setShowingNavigationDropdown(!showingNavigationDropdown)}
              >
                <Bars3Icon className={`size-6 stroke-2 ${showingNavigationDropdown ? 'hidden' : 'inline-flex'}`} stroke="currentColor" />
                <XMarkIcon className={`size-6 stroke-2 ${showingNavigationDropdown ? 'inline-flex' : 'hidden'}`} stroke="currentColor" />
              </button>
            </div>
          </div>
        </div>

        {/* Responsive Navigation Menu */}
        <div className={`sm:hidden ${showingNavigationDropdown ? 'block' : 'hidden'}`}>
          <div className="pt-2 pb-3 space-y-1">
            <NavLinks authenticated={authenticated} Component={ResponsiveNavLink} />
          </div>

          {/* Responsive Settings Options */}
          <div className="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            {authenticated ?
              <>
                <div className="flex items-center px-4">
                  {user.managesAccountPhotos &&
                    <div className="shrink-0 mr-3">
                      <img
                        className="h-10 w-10 rounded-full object-cover"
                        src={user.profile_photo_url}
                        alt={user.name}
                      />
                    </div>
                  }

                  <div>
                    <div className="font-medium text-base text-gray-800 dark:text-gray-200">{user.name}</div>
                    <div className="font-medium text-sm text-gray-500">{user.email}</div>
                  </div>
                </div>

                <div className="mt-3 space-y-1">
                  <ResponsiveNavLink href={route('user-settings.show')} active={route().current('user-settings.show')}>
                    User Settings
                  </ResponsiveNavLink>

{/*                  {jetstream.hasApiFeatures &&
                    <ResponsiveNavLink href={route('api-tokens.index')} active={route().current('api-tokens.index')}>
                      API Tokens
                    </ResponsiveNavLink>
                  }*/}

                  {/* Authentication */}
                  <ResponsiveNavLink as="button" onClick={logout}>
                    Log Out
                  </ResponsiveNavLink>

                  {/* Team Management */}
{/*                  {jetstream.hasTeamFeatures &&
                    <ResponsiveTeams jetstream={jetstream} user={user} switchToTeam={switchToTeam}/>
                  }*/}
                </div>
              </>
            :
              <>
                {canLogin &&
                  <div className="space-y-1">
                    <ResponsiveNavLink
                      href={route('login')}
                      className="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                    >
                      Log in
                    </ResponsiveNavLink>

                    {canRegister &&
                      <ResponsiveNavLink
                        href={route('register')}
                        className="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                      >
                        Register
                      </ResponsiveNavLink>
                    }
                  </div>
                }
              </>
            }
          </div>
        </div>
      </nav>

      {/* Page Heading */}
      {header &&
        <header className="bg-white dark:bg-gray-800 shadow">
          <div className="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            {header}
          </div>
        </header>
      }

      {/* Page Content */}
      <main>
        {children}
      </main>
    </div>
  </>;
};

export default AppLayout;
