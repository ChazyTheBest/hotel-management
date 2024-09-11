import { createContext, useContext } from 'react';
import ThemeManager from './theme';

export const ThemeContext = createContext({
    theme: ThemeManager.LIGHT,
    setThemeTo: () => {},
    isSystemThemeDark: false,
    themeLight: ThemeManager.LIGHT,
    themeDark: ThemeManager.DARK,
    themeSystem: ThemeManager.SYSTEM
});
export const AuthContext = createContext({});

export const useTheme = () => useContext(ThemeContext);
export const useAuth = () => useContext(AuthContext);
