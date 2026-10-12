import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    build: {
        outDir: '../../public/build-admin',
        emptyOutDir: true,
        manifest: true,
    },
    plugins: [
        laravel({
            publicDirectory: '../../public',
            buildDirectory: 'build-admin',
            input: [
                'Resources/assets/css/admin.css',
                'Resources/assets/js/admin.js'
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});

// Consumed by the root "vite-module.js" collector so the main app build also
// compiles this module's assets alongside resources/js/app.js.
export const paths = [
     'Modules/Admin/Resources/assets/css/admin.css',
     'Modules/Admin/Resources/assets/js/admin.js'
];
