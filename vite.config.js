import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { VitePWA } from 'vite-plugin-pwa';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/js/Pages/Index.vue'],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        VitePWA({
            outDir: 'public',
            base: '/',
            scope: '/',
            registerType: 'autoUpdate',
            manifest: {
                name: 'Радіо Марія',
                short_name: 'Радіо Марія',
                description: 'Католицьке радіо онлайн та подкасти',
                theme_color: '#005b9f',
                background_color: '#ffffff',
                display: 'standalone',
                start_url: '/',
                id: '/',
                icons: [
                    {
                        src: '/pwa-192x192.png',
                        sizes: '192x192',
                        type: 'image/png'
                    },
                    {
                        src: '/pwa-512x512.png',
                        sizes: '512x512',
                        type: 'image/png'
                    }
                ]
            }
        })
    ],
});