import { reactive, nextTick } from 'vue';

export const playerState = reactive({
    isPlaying: false,
    currentStream: 'https://radiomaria.org.ua:8443/stream160',
    audioElement: null,

    async toggle(streamUrl = null) {
        // Если передали новый URL и он отличается от текущего
        if (streamUrl && this.currentStream !== streamUrl) {
            this.currentStream = streamUrl;
            this.isPlaying = false; // Ставим на паузу визуально

            // nextTick() ждет, пока Vue обновит атрибут :src у тега <audio> в HTML
            await nextTick();

            if (this.audioElement) {
                this.audioElement.load();
                this.playAudio();
            }
            return;
        }

        if (!this.audioElement) return;

        // Если кликнули по тому же стриму, что сейчас играет
        if (this.isPlaying && (!streamUrl || this.currentStream === streamUrl)) {
            this.audioElement.pause();
            this.isPlaying = false;
        } else {
            this.playAudio();
        }
    },

    // Вынесли запуск в отдельный метод, чтобы аккуратно ловить ошибки
    playAudio() {
        if (!this.audioElement) return;

        this.audioElement.play().then(() => {
            this.isPlaying = true;
        }).catch(e => {
            // Игнорируем AbortError (нормальное поведение браузера при переключении)
            if (e.name !== 'AbortError') {
                console.error("Помилка відтворення:", e);
            }
            this.isPlaying = false;
        });
    }
});