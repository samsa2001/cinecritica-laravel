<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach ($peliculas as $pelicula)
  <url>
    <loc>{pelicula->slug}</loc>
    <lastmod>2018-06-04</lastmod>
  </url>
@endforeach
</urlset>
{{ $peliculas -> links() }}