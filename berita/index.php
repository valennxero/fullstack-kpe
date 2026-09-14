<?php

// Get URI parameter terakhir yang akan where condition (url)
// Explode url ($_SERVER["REQUEST_URI"]) dengan delimiter /

$exploded = explode("/", $_SERVER["REQUEST_URI"]);
echo end($exploded);
?>

<html>
    <head>
        <title>Berita Teknologi 5G sudah ada di Indonesia</title>
        <!-- Meta Tag untuk Open Graph
        Diawal og:[property name] seperti title, etc -->
        <meta property="og:title" content="The Rock" />
        <meta property="og:url" content="https://www.imdb.com/title/tt0117500/" />
        <meta property="og:image" content="https://ia.media-imdb.com/images/rock.jpg" />
        <meta property="og:description" content="Lorem ipsum …."/>
        <meta property="og:type" content="video.movie" />

        <meta property="og:video" content="https://example.com/bond/trailer.swf" />
        <meta property="og:audio" content="https://example.com/bond/theme.mp3" />

        <!-- Menghubungkan dengan twitter
         Diawali dengan twitter:[property] -->
        <meta name="twitter:card" content="summary" />
        <meta name="twitter:site" content="@flickr" />
        <meta name="twitter:title" content="Small Island Developing States Photo Submission" />
        <meta name="twitter:description" content="View the album on Flickr." />
        <meta name="twitter:image:src" content="https://farm6.staticflickr.com/5510/14338202952_93595258ff_z.jpg" />

    </head>
    <body>
        <header>
            <h1>
                Berita Teknologi 5G sudah ada di Indonesia
            </h1>
        </header>
    </body>
</html>