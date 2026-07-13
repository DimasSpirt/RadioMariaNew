import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import MainLayout from './Layouts/MainLayout.vue';
import { registerSW } from 'virtual:pwa-register';

const updateSW = registerSW({
    onNeedRefresh() {
        console.log('PWA: Доступно обновление!');
    },
    onOfflineReady() {
        console.log('PWA: Приложение готово к работе в офлайне');
    },
});

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => {
        // Загружаем все страницы
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true });
        let page = pages[`./Pages/${name}.vue`];

        // Магия: Если у страницы нет своего специфического лейаута,
        // мы НАСИЛЬНО назначаем ей MainLayout глобально.
        // Это гарантирует 100% сохранение инстанса плеера при переходах.
        page.default.layout = page.default.layout || MainLayout;

        return page;
    },
    setup({ el, App, props, plugin }) {
        // 1. Создаем инстанс приложения
        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue);

        // 2. Регистрируем нашу глобальную переменную для медиа
        app.config.globalProperties.$mediaUrl = import.meta.env.VITE_MEDIA_URL || '';

        // 3. Монтируем приложение
        return app.mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});