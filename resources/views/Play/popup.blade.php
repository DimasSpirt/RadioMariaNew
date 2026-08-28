<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Радіо Марія - Плеєр</title>

    <script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>

    <style>
        body {
            margin: 0; padding: 0; background-color: #081221; color: #ffffff;
            font-family: system-ui, -apple-system, sans-serif; overflow: hidden;
        }
        .popup-wrapper {
            display: flex; flex-direction: column; justify-content: space-between;
            height: 100vh; padding: 24px 20px; box-sizing: border-box;
            background: linear-gradient(180deg, #0d1e36 0%, #081221 100%);
        }
        .header { text-align: center; }
        .live-badge {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(255, 255, 255, 0.1); padding: 4px 12px;
            border-radius: 20px; font-size: 12px; font-weight: 600;
            text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px;
        }
        .dot { width: 8px; height: 8px; background-color: #ef4444; border-radius: 50%; }
        .brand-title { margin: 0; font-size: 22px; font-weight: 700; color: #e6b74a; }

        .track-info { text-align: center; margin: 15px 0 10px 0; }
        .track-now { font-size: 16px; font-weight: 600; margin-bottom: 6px; text-transform: capitalize; }
        .track-next { font-size: 13px; color: #94a3b8; }

        .controls { display: flex; justify-content: center; margin-top: 15px; }
        .mega-play-btn {
            width: 70px; height: 70px; border-radius: 50%;
            background-color: #e6b74a; border: none; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 6px 20px rgba(230, 183, 74, 0.3); transition: transform 0.2s;
        }
        .mega-play-btn:hover { transform: scale(1.05); }
        .mega-play-btn svg { width: 28px; height: 28px; fill: #081221; }

        /* Контроллер громкости */
        .volume-container {
            display: flex; align-items: center; justify-content: center;
            gap: 10px; margin: 15px 0 20px 0;
        }
        .volume-icon { width: 18px; height: 18px; fill: #94a3b8; flex-shrink: 0; }
        .volume-slider {
            -webkit-appearance: none; appearance: none;
            width: 120px; height: 4px; border-radius: 2px;
            background: rgba(255, 255, 255, 0.2); outline: none; cursor: pointer;
        }
        .volume-slider::-webkit-slider-thumb {
            -webkit-appearance: none; appearance: none;
            width: 14px; height: 14px; border-radius: 50%;
            background: #e6b74a; cursor: pointer; transition: transform 0.1s;
        }
        .volume-slider::-webkit-slider-thumb:hover { transform: scale(1.2); }
        .volume-slider::-moz-range-thumb {
            width: 14px; height: 14px; border-radius: 50%;
            background: #e6b74a; cursor: pointer; border: none;
        }

        .streams-container { background: rgba(255, 255, 255, 0.05); padding: 12px; border-radius: 10px; }
        .streams-title { font-size: 11px; color: #94a3b8; margin-bottom: 8px; text-align: center; text-transform: uppercase; }
        .streams-list { display: flex; flex-wrap: wrap; gap: 6px; justify-content: center; }
        .stream-btn {
            background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2);
            color: white; padding: 6px 12px; border-radius: 6px; font-size: 12px; cursor: pointer;
            text-transform: capitalize; transition: background 0.2s;
        }
        .stream-btn:hover { background: rgba(255, 255, 255, 0.2); }
        .stream-btn.active { background: #e6b74a; color: #081221; font-weight: bold; border-color: #e6b74a; }
    </style>
</head>
<body>

<div id="app" class="popup-wrapper">
    <audio
            ref="audioRef"
            :src="currentStreamUrl"
            preload="none"
            @@play="isPlaying = true"
            @@pause="isPlaying = false"
    ></audio>

    <div class="header">
        <div class="live-badge"><span class="dot"></span> Live</div>
        <h1 class="brand-title">Радіо Марія</h1>
    </div>

    <div class="track-info">
        <div class="track-now">@{{ currentStreamName }}</div>
        <div class="track-next">Прямий ефір</div>
    </div>

    <div>
        <!-- Кнопка Play/Pause -->
        <div class="controls">
            <button class="mega-play-btn" @@click="togglePlay">
                <svg v-if="!isPlaying" viewBox="0 0 12 12">
                    <polygon points="3,2 10,6 3,10"/>
                </svg>
                <svg v-else viewBox="0 0 12 12">
                    <rect x="3" y="2" width="2" height="8"/>
                    <rect x="7" y="2" width="2" height="8"/>
                </svg>
            </button>
        </div>

        <!-- Регулятор громкости -->
        <div class="volume-container">
            <svg class="volume-icon" viewBox="0 0 24 24">
                <path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02zM14 3.23v2.06c2.89.86 5 3.54 5 6.71s-2.11 5.85-5 6.71v2.06c4.01-.91 7-4.49 7-8.77s-2.99-7.86-7-8.77z"/>
            </svg>
            <input
                    type="range"
                    min="0"
                    max="1"
                    step="0.01"
                    v-model.number="volume"
                    @@input="changeVolume"
                    class="volume-slider"
            />
        </div>
    </div>

    <div class="streams-container">
        <div class="streams-title">Вибір потоку:</div>
        <div class="streams-list">
            <button
                    v-for="(stream, key) in streams"
                    :key="key"
                    class="stream-btn"
                    :class="{ active: currentStreamKey === key }"
                    @@click="selectStream(key)"
            >
                @{{ stream.name }}
            </button>
        </div>
    </div>
</div>

<script>
    const { createApp, ref, nextTick } = Vue;

    createApp({
        setup() {
            const rawData = <?php echo json_encode($streams ?? []); ?>;
            const streams = {};

            for (const key in rawData) {
                const item = rawData[key];
                if (typeof item === 'string') {
                    streams[key] = { name: key, url: item };
                } else if (item && typeof item === 'object') {
                    streams[key] = { name: item.name || key, url: item.url || '' };
                }
            }

            const keys = Object.keys(streams);

            // Приоритетно ищем stream160, иначе любой валидный аудиопоток
            const defaultKey = keys.find(k => k.toLowerCase() === 'stream160' || k.toLowerCase().includes('160'))
                || keys.find(k => streams[k].url && !streams[k].url.includes('youtube'))
                || keys[0] || '';

            const currentStreamKey = ref(defaultKey);
            const currentStreamUrl = ref(streams[defaultKey] ? streams[defaultKey].url : '');
            const currentStreamName = ref(streams[defaultKey] ? streams[defaultKey].name : defaultKey);

            const isPlaying = ref(false);
            const volume = ref(0.8); // Громкость по умолчанию (80%)
            const audioRef = ref(null);

            const changeVolume = () => {
                if (audioRef.value) {
                    audioRef.value.volume = volume.value;
                }
            };

            const togglePlay = () => {
                if (!audioRef.value) return;
                audioRef.value.volume = volume.value;

                if (isPlaying.value) {
                    audioRef.value.pause();
                } else {
                    if (!currentStreamUrl.value) return;
                    audioRef.value.play().catch(err => console.error("Помилка відтворення:", err));
                }
            };

            const selectStream = (key) => {
                const stream = streams[key];
                if (!stream || !stream.url) return;

                const url = String(stream.url);

                if (url.includes('youtube') || String(key).toLowerCase().includes('youtube')) {
                    window.open(url, '_blank');
                    return;
                }

                currentStreamKey.value = key;
                currentStreamUrl.value = url;
                currentStreamName.value = stream.name;

                if (audioRef.value) {
                    audioRef.value.pause();
                    isPlaying.value = false;

                    nextTick(() => {
                        audioRef.value.volume = volume.value;
                        audioRef.value.play().then(() => {
                            isPlaying.value = true;
                        }).catch(err => console.error("Помилка відтворення нового потоку:", err));
                    });
                }
            };

            return {
                streams,
                currentStreamKey,
                currentStreamUrl,
                currentStreamName,
                isPlaying,
                volume,
                audioRef,
                togglePlay,
                selectStream,
                changeVolume
            };
        }
    }).mount('#app');
</script>
</body>
</html>