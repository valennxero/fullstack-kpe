<?php
// require_once "koneksi.php"; // menyediakan variabel $mysqli

$mysqli = new mysqli("127.0.0.1", "root", "", "fullstack");

if ($mysqli->connect_errno) {
    echo "Failed to connect MySQL:" . $mysqli->connect_error;
}

// Homework 2a (proses): tangkap semua kiriman dari editmovie.php, termasuk hidden "idmovie"
$idmovie  = $_POST['idmovie'];
$judul    = $_POST['judul'];
$rilis    = $_POST['rilis'];
$skor     = $_POST['skor'];
$sinopsis = $_POST['sinopsis'];
$serial   = $_POST['serial'];
$genre    = $_POST['genre'];

// Homework 2b (proses): UPDATE data movie sesuai idmovie (prepared statement)
$stmt = $mysqli->prepare(
    "UPDATE movie SET judul=?, rilis=?, skor=?, sinopsis=?, genre=?, serial=? WHERE idmovie=?"
);

// Tipe: s=string, i=integer, d=double. Urutan harus sama dengan ? di atas.
// judul(s) rilis(s) skor(d) sinopsis(s) genre(s) serial(i) idmovie(i) => 'ssdssii'
$stmt->bind_param('ssdssii', $judul, $rilis, $skor, $sinopsis, $genre, $serial, $idmovie);

// Mengupdate checkbox genre_movie
// Delete genre_movie where condition id_movie
$del = $mysqli->prepare("DELETE FROM genre_movie WHERE id_movie = ?");
$del->bind_param('i', $idmovie);
$del->execute();
$del->close();

// Data di genre_movie kosong untuk id_movie = 7
// Bulk insert data baru ke genre_movie untuk mengganti data yang dihapus
$ins = $mysqli->prepare("INSERT INTO genre_movie(id_movie, id_genre) 
VALUES(?, ?)");
foreach ($genre as $idgenre) {
    $ins->bind_param('ii', $idmovie, $idgenre);
    $ins->execute();
}

$ins->close();

if ($stmt->execute()) {
    // Sukses -> kembali ke daftar movie
    header("location: get.php");
    exit();
} else {
    echo "Gagal mengubah data: " . $stmt->error;
}

$stmt->close();
$mysqli->close();
