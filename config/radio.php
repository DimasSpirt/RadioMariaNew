<?php

return [
    'streams' => [
        'stream32'  => env('STREAM_32_URL', 'https://radiomaria.org.ua:8443/stream32'),
        'stream64'  => env('STREAM_64_URL', 'https://radiomaria.org.ua:8443/stream64'),
        'stream160' => env('STREAM_160_URL', 'https://radiomaria.org.ua:8443/stream160'),
        'youtube'   => env('YOUTUBE_LIVE_URL', 'https://www.youtube.com/@RadioMariaUkraine/live'),
    ],
];