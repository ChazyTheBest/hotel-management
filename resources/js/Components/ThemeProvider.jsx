import { useEffect, useState} from 'react';
import { ThemeContext } from '@/contexts';
import ThemeManager from '@/theme';

const ThemeProvider = ({ children }) => {
  const [ theme, setTheme ] = useState(localStorage.getItem('theme') || ThemeManager.SYSTEM);
  const [ store, setStore ] = useState(false);
  const [ remove, setRemove ] = useState(false);
  const prefersDarkScheme = window.matchMedia('(prefers-color-scheme: dark)').matches;

  useEffect(() => {
    if (theme === ThemeManager.LIGHT) {
      ThemeManager.setToLight(store);
    } else if (theme === ThemeManager.DARK) {
      ThemeManager.setToDark(store);
    } else {
      ThemeManager.setToSystem(remove, prefersDarkScheme);
    }
  }, [theme]);

  return (
    <ThemeContext.Provider value={{
      theme,
      setThemeTo: newTheme => () => {
        setTheme(newTheme);
        !store && setStore(true);
        !remove && setRemove(true);
      },
      isSystemThemeDark: prefersDarkScheme,
      themeLight: ThemeManager.LIGHT,
      themeDark: ThemeManager.DARK,
      themeSystem: ThemeManager.SYSTEM
    }}>
      {children}
    </ThemeContext.Provider>
  );
};

export default ThemeProvider;
