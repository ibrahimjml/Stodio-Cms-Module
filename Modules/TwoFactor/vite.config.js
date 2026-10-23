import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    build: {
        outDir: '../../public/build-twofactor',
        emptyOutDir: true,
        manifest: true,
    },
    plugins: [
        laravel({
            publicDirectory: '../../public',
            buildDirectory: 'build-twofactor',
            input: [
                'Resources/assets/css/twofactor.css',
                'Resources/assets/js/2fa.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});

// Consumed by the root "vite-module.js" collector so the main app build also
// compiles this module's assets alongside resources/js/app.js.
export const paths = [
    'Modules/TwoFactor/Resources/assets/css/twofactor.css',
    'Modules/TwoFactor/Resources/assets/js/2fa.js',
];
