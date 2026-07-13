import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

export function useSocials() {
    const page = usePage();

    // Забираем массив соцсетей из middleware (из объекта global)
    const networks = computed(() => page.props.global?.socialNetworks || []);

    // Конфигурация иконок
    const socialConfig = {
        'facebook.com': {
            name: 'Facebook',
            svg: '<path d="M9 6h2V4a4 4 0 00-4 4v1H5v2h2v5h2v-5h2l.5-2H9V8a2 2 0 012-2z"/>'
        },
        'youtube.com': {
            name: 'YouTube',
            svg: '<rect x="1" y="3" width="14" height="10" rx="2.5"/><path d="M6.5 6l4 2-4 2V6z" fill="currentColor"/>'
        },
        'telegram': {
            name: 'Telegram',
            svg: '<path d="M14 2L2 6.5l4 1.5 1.5 4L10 9l3 5V2z"/>'
        },
        'instagram.com': {
            name: 'Instagram',
            svg: '<rect x="2" y="2" width="12" height="12" rx="3"/><circle cx="8" cy="8" r="3"/><circle cx="11.5" cy="4.5" r=".75" fill="currentColor"/>'
        },
        'RSS': {
            name: 'RSS',
            svg: '<circle cx="3.5" cy="12.5" r="1.5"/><path d="M2 7v2a4 4 0 014 4h2a6 6 0 00-6-6zm0-4v2a8 8 0 018 8h2a10 10 0 00-10-10z"/>'
        }
    };

    // Собираем готовый массив для вывода в шапке и подвале
    const renderedSocials = computed(() => {
        return networks.value
            .filter(net => socialConfig[net.title]) // Отсекаем то, чего нет в конфиге
            .map(net => ({
                ...net,
                name: socialConfig[net.title].name,
                svg: socialConfig[net.title].svg
            }));
    });

    // Функция для получения одиночной ссылки (например, для RSS на главной)
    const getLink = (title) => {
        const net = networks.value.find(n => n.title === title);
        return net ? net.link : '#';
    };

    return { renderedSocials, getLink, socialConfig };
}