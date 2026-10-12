import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';

import collectModuleAssetsPaths from './vite-module.js';

export default defineConfig(async () => {
    const input = await collectModuleAssetsPaths(
        ['resources/css/app.css', 'resources/js/app.js'],
        'Modules',
    );

    return {
        resolve: {
            alias: {
                '@core': '/Modules/Core/Resources/assets/js',
                '@core-css' : '/Modules/Core/Resources/assets/css',
            },
        },
        plugins: [
            laravel({
                input,
                refresh: [
                    'resources/**',
                    'Modules/**/Resources/views/**',
                    'Modules/**/Routes/**',
                ],
                fonts: [
                    bunny('Poppins', {
                        weights: [400, 500, 600],
                        optimizedFallbacks: false,
                    }),
                ],
            }),

            tailwindcss(),
        ],
        server: {
            watch: {
                ignored: ['**/storage/framework/views/**'],
            },
        },
    };
});

