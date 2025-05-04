import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        headers: {
            'Access-Control-Allow-Origin': '*',
            'Access-Control-Allow-Methods': 'GET, POST, PUT, DELETE, PATCH, OPTIONS',
            'Access-Control-Allow-Headers': 'X-Requested-With, content-type, Authorization',
        }
    },
    plugins: [
        laravel({
            input: ['resources/js/app.js', 'resources/libs/bootstrap/bootstrap.bundle.js', 'resources/libs/twentytwenty-master/css/twentytwenty.css', 'resources/libs/jquery/dist/jquery-3.7.1.js', 'resources/js/script.js', 'resources/js/test.js', 'resources/libs/twentytwenty-master/js/jquery.event.move.js', 'resources/libs/twentytwenty-master/js/jquery.twentytwenty.js', 'resources/js/phoneMask.js', 'resources/js/eventTime.js', 'resources/libs/bootstrap/bootstrap.css', 'resources/libs/fontawesome/css/all.css', 'resources/css/main.css','resources/css/admin.css', 'resources/css/admin-login.css', 'resources/js/admin.js'],
            refresh: true,
        }),
    ],
});
