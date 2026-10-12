import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    build: {
        outDir: '../../public/build-core',
        emptyOutDir: true,
        manifest: true,
    },
    plugins: [
        laravel({
            publicDirectory: '../../public',
            buildDirectory: 'build-core',
            input: [
                'Resources/assets/js/core.js',
                'Resources/assets/js/alpine.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});

// Consumed by the root "vite-module.js" collector so the main app build also
// compiles this module's assets alongside resources/js/app.js.
export const paths = [
    'Modules/Core/Resources/assets/js/core.js',
    'Modules/Core/Resources/assets/js/alpine.js',
];
