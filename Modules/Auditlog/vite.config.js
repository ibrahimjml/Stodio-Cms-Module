import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    build: {
        outDir: '../../public/build-auditlog',
        emptyOutDir: true,
        manifest: true,
    },
    plugins: [
        laravel({
            publicDirectory: '../../public',
            buildDirectory: 'build-auditlog',
            input: [
                'Resources/assets/css/auditlog.css',
                'Resources/assets/js/auditlog.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});

// Consumed by the root "vite-module.js" collector so the main app build also
// compiles this module's assets alongside resources/js/app.js.
export const paths = [
    // 'Modules/Auditlog/Resources/assets/css/auditlog.css',
    // 'Modules/Auditlog/Resources/assets/js/auditlog.js',
];
