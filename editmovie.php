<?php
// require_once "koneksi.php"; // menyediakan variabel $mysqli

$mysqli = new mysqli("127.0.0.1", "root", "", "fullstack");

if ($mysqli->connect_errno) {
    echo "Failed to connect MySQL:" . $mysqli->connect_error;
}

// Homework 2a: tangkap id movie dari query string (?idmovie=xx)
$idmovie = $_GET['idmovie'] ?? null;
if ($idmovie === null) {
    die("idmovie tidak ada di query string. Buka halaman lewat link 'Ubah Data'.");
}

// Homework 2b: SELECT data movie sesuai idmovie (prepared statement)
$stmt = $mysqli->prepare("SELECT * FROM movie WHERE idmovie=?");
$stmt->bind_param('i', $idmovie);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();

$genreTerpilih = [];
$gm = $mysqli->prepare("SELECT id_genre FROM genre_movie 
WHERE id_movie = ?");
// Example
// Genre 1 (Action), 2 (Adventure), 3 (Comedy)
$gm->bind_param('i', $idmovie);
$gm->execute();
$result_genres = $gm->get_result();
// Looping data
// genreTerpilih[1] = true
// genreTerpilih[2] = true
while ($x = $result_genres->fetch_assoc()) {
    $genreTerpilih[$x['id_genre']] = true;
}
$gm->close();

if (!$row) {
    die("Data movie dengan idmovie=" . htmlspecialchars($idmovie) . " tidak ditemukan.");
}

$genres = $mysqli->query("SELECT * FROM genre ORDER BY nama");

// Daftar genre untuk dropdown (disamakan dengan insertmovie.php)
// $daftar_genre = ["Action", "Sci-Fi", "Drama", "Comedy", "Horror", "Crime", "Romance", "Anime"];
?>
<html>
    <head>
        <title>Edit Movie</title>
    </head>
    <body>
        <h1>Edit Movie</h1>
        <!-- Homework 2c: tampilkan data lama di masing-masing input (atribut value) -->
        <form action="editmovie_proses.php" method="post">
            <label for="judul">Judul:</label>
            <input type="text" id="judul" name="judul"
                   value="<?php echo htmlspecialchars($row['judul']); ?>" required><br><br>

            <label for="rilis">Tanggal Rilis:</label>
            <input type="date" id="rilis" name="rilis"
                   value="<?php echo htmlspecialchars($row['rilis']); ?>" required><br><br>

            <label for="skor">Skor:</label>
            <input type="number" id="skor" name="skor" step="0.1"
                   value="<?php echo htmlspecialchars($row['skor']); ?>" required><br><br>

            <label for="sinopsis">Sinopsis:</label>
            <textarea id="sinopsis" name="sinopsis" required><?php echo htmlspecialchars($row['sinopsis']); ?></textarea><br><br>

            <label for="serial">Serial:</label>
            <select id="serial" name="serial" required>
                <option value="0" <?php echo ($row['serial'] == "0" ? "selected" : ""); ?>>Tidak</option>
                <option value="1" <?php echo ($row['serial'] == "1" ? "selected" : ""); ?>>Ya</option>
            </select><br><br>

            <!-- <label for="genre">Genre:</label>
            <select id="genre" name="genre" required>
                <?php foreach ($daftar_genre as $g) : ?>
                    <option value="<?php echo $g; ?>" <?php echo ($row['genre'] == $g ? "selected" : ""); ?>>
                        <?php echo $g; ?>
                    </option>
                <?php endforeach; ?>
            </select><br><br> -->

            <label for="genre">Genre:</label>
            <?php while($g = $genres->fetch_assoc()): ?>
            <label>
                <input type="checkbox" name="genre[]"
                value = "<?php echo $g['idgenre'] ?>" 
                <?php echo isset($genreTerpilih[$g['idgenre']]) ? 'checked' : '' ?>
                >
                <?php echo $g['nama'] ?>
            </label>
            <?php endwhile; ?>

            <br><br>

            <!-- Homework 2d: input hidden untuk menampung idmovie (dipakai saat UPDATE) -->
            <input type="hidden" name="idmovie" value="<?php echo htmlspecialchars($row['idmovie']); ?>">

            <input type="submit" value="Simpan">
            &nbsp;<a href="get.php">Batal</a>
        </form>
    </body>
</html>
<?php
$stmt->close();
$mysqli->close();
?>
