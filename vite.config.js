import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',

                // Admin Theme
                // 'resources/theme/admin/css/nucleo-icons.css',
                // 'resources/theme/admin/css/nucleo-svg.css',
                // 'resources/theme/admin/css/dashboard-tailwind.css',
                // 'resources/theme/admin/js/plugins/chartjs.min.js',
                // 'resources/theme/admin/js/plugins/perfect-scrollbar.js',
                // 'resources/theme/admin/js/dashboard-tailwind.js',

                // Frontend Theme
                //'resources/theme/frontend/css/frontend.css',
                //'resources/theme/frontend/js/frontend.js',
            ],
            refresh: true,
        }),
    ],
});
