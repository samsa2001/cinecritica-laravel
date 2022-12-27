<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach ($series as $serie)
  <url>
    <loc>https://cinecritica.com/serie/{{$serie->slug}}</loc>
    <lastmod>2018-06-04</lastmod>
  </url>
@endforeach
</urlset>
{{ $series -> links() }}