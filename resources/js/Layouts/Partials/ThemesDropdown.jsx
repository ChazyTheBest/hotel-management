import { useEffect, useState } from 'react';
import { useTheme } from '@/contexts';
import { SunIcon, MoonIcon, ComputerDesktopIcon } from '@heroicons/react/20/solid';
import Dropdown from '@/Components/Dropdown';
import DropdownLink from '@/Components/DropdownLink';

const ThemesDropdown = () => {
  const {
    theme,
    setThemeTo,
    isSystemThemeDark,
    themeLight,
    themeDark,
    themeSystem
  } = useTheme();

  const isActive = checkedTheme => checkedTheme === theme ? ' text-sky-400' : '';

  const iconMap = {
    [themeLight]: <SunIcon className={`size-6${isActive(themeLight)}`} aria-hidden="true" />,
    [themeDark]: <MoonIcon className={`size-6${isActive(themeDark)}`} aria-hidden="true" />,
    [themeSystem]: isSystemThemeDark
      ? <MoonIcon className="size-6" aria-hidden="true" />
      : <SunIcon className="size-6" aria-hidden="true" />
  };

  const [ triggerButtonIcon, setTriggerButtonIcon ] = useState(null);

  useEffect(() => {
    setTriggerButtonIcon(iconMap[theme]);
  }, [theme]);

  return <Dropdown
    width="32"
    trigger={
      <button
        type="button"
        className="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 transition ease-in-out duration-150"
      >
        {triggerButtonIcon}
      </button>
    }
  >
    {/* Theme Switcher */}
    <div className="block px-4 py-2 text-xs text-gray-400">
      Switch Themes
    </div>

    <DropdownLink as="button" onClick={setThemeTo(themeLight)}>
      <div className={`flex items-start${isActive(themeLight)}`}>
        <SunIcon className="size-5" aria-hidden="true" />
        <span className="ms-2">Light</span>
      </div>
    </DropdownLink>

    <DropdownLink as="button" onClick={setThemeTo(themeDark)}>
      <div className={`flex items-start${isActive(themeDark)}`}>
        <MoonIcon className="size-5" aria-hidden="true" />
        <span className="ms-2">Dark</span>
      </div>
    </DropdownLink>

    <DropdownLink as="button" onClick={setThemeTo(themeSystem)}>
      <div className={`flex items-start${isActive(themeSystem)}`}>
        <ComputerDesktopIcon className="size-5" aria-hidden="true" />
        <span className="ms-2">System</span>
      </div>
    </DropdownLink>
  </Dropdown>;
};

export default ThemesDropdown;
