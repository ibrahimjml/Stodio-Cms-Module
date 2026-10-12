import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    build: {
        outDir: '../../public/build-member',
        emptyOutDir: true,
        manifest: true,
    },
    plugins: [
        laravel({
            publicDirectory: '../../public',
            buildDirectory: 'build-member',
            input: [
                'Resources/assets/css/member.css',
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
    'Modules/Member/Resources/assets/css/member.css',
    'Modules/Member/Resources/assets/js/login.js',
];
