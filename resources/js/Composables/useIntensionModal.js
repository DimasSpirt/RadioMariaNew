import { ref } from 'vue';

// Глобальное состояние (вынесено за пределы функции, чтобы сохранять реактивность между вызовами)
const isOpen = ref(false);

export function useIntensionModal() {
    const openModal = () => {
        isOpen.value = true;
    };

    const closeModal = () => {
        isOpen.value = false;
    };

    return {
        isOpen,
        openModal,
        closeModal,
    };
}