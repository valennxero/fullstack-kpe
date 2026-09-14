<html>
<head>
    <title>Artikel Berita Teknologi</title>
    <meta charset="UTF-8">
    <meta name="description" content="Artikel Berita Teknologi">
    <meta name="keywords" content="Jaringan, Handphone, Gadget">
    <meta name="author" content="Informatika UBAYA">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/light.css">
</head>
<body>
    <header>
        <h1>Artikel Berita Teknologi 5G</h1>
        <nav>
            <a href="artikel.php">Artikel</a>
            <a href="get.php">Movie</a>
        </nav>
    </header>

    <main>
        <!-- <section></section> -->
         <article>
            <h2>Title Article</h2>
            <time datetime="<?php date("Y-m-d"); ?>">
                <?php echo date('d M Y', strtotime(date('Y-m-d'))) ?>
            </time>
            <figure>
                <img src="img/ilustrasi-5g.jpg" alt="Ilustrasi 5G" />
                <figcaption>Ilustrasi 5G</figcaption>
            </figure>
         </article>
    </main>

    <footer>@Informatika UBAYA 2026</footer>
</body>
</html>