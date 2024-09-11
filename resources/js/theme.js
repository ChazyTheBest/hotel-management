const ThemeManager = Object.freeze({
    LIGHT: 'light',
    DARK: 'dark',
    SYSTEM: 'system',

    docClasses: typeof document !== 'undefined'
        ? document.documentElement.classList
        : null,

    setToLight(store = true) {
        store && localStorage.setItem('theme', this.LIGHT);
        this.docClasses?.contains(this.DARK) && this.docClasses.remove(this.DARK);
    },

    setToDark(store = true) {
        store && localStorage.setItem('theme', this.DARK);
        !this.docClasses?.contains(this.DARK) && this.docClasses.add(this.DARK);
    },

    setToSystem(remove = true, prefersDarkScheme) {
        remove && localStorage.removeItem('theme');
        prefersDarkScheme
            ? !this.docClasses?.contains(this.DARK) && this.docClasses.add(this.DARK)
            : this.docClasses?.contains(this.DARK) && this.docClasses.remove(this.DARK);
    }
});

export default ThemeManager;
