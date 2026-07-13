import { reactive, nextTick } from 'vue';
import axios from 'axios';

export const playerState = reactive({
    // Базовые состояния
    isPlaying: false,
    currentStream: 'https://radiomaria.org.ua:8443/stream160', // По умолчанию играет лайв
    audioElement: null,

    // Время для подкастов
    currentTime: 0,
    duration: 0,

    // Мета-данные для отображения в шапке
    trackType: 'live', // Может быть 'live' или 'podcast'
    trackTitle: 'Прямий ефір',
    subtitle: 'Радіо Марія',

    // --- РОЗКЛАД ТА ТАЙМЕР ---
    schedule: {},
    liveProgramsToday: [],
    liveProgramIndex: -1,
    liveTimerInterval: null,

    // 1. Загружаем расписание с бекенда
    async fetchSchedule() {
        try {
            const response = await axios.get('/schedule');
            this.schedule = response.data;
            this.updateLiveProgram(); // Сразу пересчитываем, что сейчас в эфире
        } catch (e) {
            console.error("Ошибка завантаження розкладу:", e);
        }
    },

    // 2. Запускаем фоновые часики
    initLiveTimer() {
        if (this.liveTimerInterval) clearInterval(this.liveTimerInterval);

        // Раз в 30 секунд проверяем, не сменилась ли передача
        this.liveTimerInterval = setInterval(() => {
            this.updateLiveProgram();
        }, 30000);
    },

    // 3. Высчитываем текущую передачу
    updateLiveProgram() {
        if (Object.keys(this.schedule).length === 0) return;

        // Получаем текущую дату в формате YYYY-MM-DD
        const now = new Date();
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        const todayDate = `${year}-${month}-${day}`;

        // Текущий UNIX-таймстемп в секундах
        const currentTs = Math.floor(now.getTime() / 1000);

        // Берем массив передач на сегодня
        const todaysPrograms = this.schedule[todayDate] || [];
        this.liveProgramsToday = todaysPrograms;

        if (todaysPrograms.length === 0) return;

        // Ищем индекс программы, которая уже началась (ts <= сейчас)
        let currentIndex = -1;
        for (let i = 0; i < todaysPrograms.length; i++) {
            if (todaysPrograms[i].ts <= currentTs) {
                currentIndex = i;
            } else {
                break; // Как только наткнулись на будущую передачу - стоп
            }
        }

        this.liveProgramIndex = currentIndex;

        // Если сейчас играет прямой эфир — динамически меняем заголовки
        if (currentIndex !== -1 && this.trackType === 'live') {
            const currentProg = todaysPrograms[currentIndex];
            const nextProg = todaysPrograms[currentIndex + 1];

            this.trackTitle = currentProg.program?.name || 'Прямий ефір';

            if (nextProg) {
                // Если есть следующая передача, выводим её время
                const timeShort = nextProg.time.substring(0, 5); // обрезаем секунды
                this.subtitle = `Наступна: <span>${nextProg.program?.name} о ${timeShort}</span>`;
            } else {
                this.subtitle = 'Радіо Марія';
            }
        }
    },
    // ---------------------------------

    // Теперь метод toggle принимает объект настроек
    async toggle(options = {}) {
        const url = options.url || null;

        // Если передали новый URL и он отличается от текущего
        if (url && this.currentStream !== url) {
            this.currentStream = url;
            this.isPlaying = false;

            // Сбрасываем время
            this.currentTime = 0;
            this.duration = 0;

            // Обновляем мета-данные из переданных опций
            this.trackType = options.type || 'live';

            // Если переключаемся обратно на эфир — заставляем стейт пересчитать заголовки
            if (this.trackType === 'live') {
                this.updateLiveProgram();
            } else {
                // Если это подкаст — берем заголовки из аргументов
                this.trackTitle = options.title || 'Архівний запис';
                this.subtitle = options.subtitle || '';
            }

            // Ждем обновления DOM (чтобы тег <audio> подхватил новый src)
            await nextTick();

            if (this.audioElement) {
                this.audioElement.load();
                this.playAudio();
            }
            return;
        }

        if (!this.audioElement) return;

        // Если нажали на паузу (тот же URL или кнопка в самой шапке)
        if (this.isPlaying && (!url || this.currentStream === url)) {
            this.audioElement.pause();
            this.isPlaying = false;
        } else {
            this.playAudio();
        }
    },

    // Внутренний метод запуска
    playAudio() {
        if (!this.audioElement) return;

        this.audioElement.play().then(() => {
            this.isPlaying = true;
        }).catch(e => {
            if (e.name !== 'AbortError') console.error("Помилка відтворення:", e);
            this.isPlaying = false;
        });
    },

    // Метод перемотки для ползунка
    seek(time) {
        if (this.audioElement) {
            this.audioElement.currentTime = time;
        }
    },

    // Метод для кнопок +/- 15 секунд
    skip(seconds) {
        // Разрешаем мотать только архивные записи
        if (this.audioElement && this.trackType === 'podcast') {
            let newTime = this.audioElement.currentTime + seconds;

            // Защита от выхода за пределы трека
            if (newTime < 0) newTime = 0;
            if (this.duration && newTime > this.duration) newTime = this.duration;

            this.audioElement.currentTime = newTime;
        }
    }
});