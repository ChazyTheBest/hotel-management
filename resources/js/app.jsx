import './bootstrap';
import '../css/app.css';

import { createRoot, hydrateRoot } from 'react-dom/client';
import { createInertiaApp } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import AuthProvider from '@/Components/AuthProvider';
import ThemeProvider from '@/Components/ThemeProvider';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: title => `${title} - ${appName}`,
    resolve: name => resolvePageComponent(
        `./Pages/${name}.jsx`,
        import.meta.glob('./Pages/**/*.jsx')
    ),
    setup({ el, App, props }) {
        const myApp = (
            <AuthProvider auth={props.initialPage.props.auth}>
                <ThemeProvider>
                    <App {...props} />
                </ThemeProvider>
            </AuthProvider>
        );

        if (import.meta.env.DEV) {
            return createRoot(el).render(myApp);
        }

        hydrateRoot(el, myApp);
    },
    progress: {
        color: '#4B5563'
    }
});
