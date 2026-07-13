<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ url('play') }}</loc>
    </url>
    <url>
        <loc>{{ url('archive') }}</loc>
    </url>
    @foreach($posts as $post)
        @if(!empty($post->link))
            <url>
                <loc>{{ url($post->link) }}</loc>
            </url>
        @endif
    @endforeach
</urlset>