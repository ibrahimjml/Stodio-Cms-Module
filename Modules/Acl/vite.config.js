import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    build: {
        outDir: '../../public/build-acl',
        emptyOutDir: true,
        manifest: true,
    },
    plugins: [
        laravel({
            publicDirectory: '../../public',
            buildDirectory: 'build-acl',
            input: [
                'Resources/assets/css/acl.css',
                'Resources/assets/js/login.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});

// Consumed by the root "vite-module.js" collector so the main app build also
// compiles this module's assets alongside resources/js/app.js.
export const paths = [
    'Modules/Acl/Resources/assets/css/acl.css',
    'Modules/Acl/Resources/assets/js/login.js',
];
