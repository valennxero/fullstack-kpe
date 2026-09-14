<?php
$mysqli = new mysqli("127.0.0.1", "root", "", "fullstack");
if ($mysqli->connect_errno) {
    die("Failed to connect database MySQL: ". $mysqli->connect_error);
}

// Property name
$judul = $_POST['judul'];
$rilis = $_POST['rilis'];
$skor = $_POST['skor'];
$sinopsis = $_POST['sinopsis'];
$serial = $_POST['serial'];
$genre = $_POST['genre'] ?? [];
$extension = ".mp4";

$idpemain = $_POST['pemain'] ?? [];
$peran = $_POST['peran'] ?? [];

$stmt = $mysqli->prepare(
"INSERT INTO movie (judul, rilis, skor, sinopsis, serial, extension) 
VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssdsis", $judul, $rilis, $skor, $sinopsis, $serial, $extension);

$stmt->execute();

// Get latest id from current insert process
$id_movie = $stmt->insert_id;

$stmt->close();

$insDetailPemain = $mysqli->prepare("INSERT INTO detail_pemain(idmovie, idpemain, peran) VALUES(?, ?, ?)");
foreach ($idpemain as $index => $idp) {
    $peranPemain = $peran[$index];
    $insDetailPemain->bind_param('iis', $id_movie, $idp, $peranPemain);
    $insDetailPemain->execute();
}

$insDetailPemain->close();

if (isset($_FILES['gambar'])) {
    // $ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
    // $destination = __DIR__ . "/img/" . $id_movie . "." . $ext; // output: [ID_MOVIE = 1].[EXT = PNG/JPG] eg = 1.png

    // if (move_uploaded_file($_FILES['gambar']['tmp_name'], $destination)) {
    //     $up = $mysqli->prepare("UPDATE movie SET extention_new = ? WHERE idmovie = ?");
    //     $up->bind_param("si", $ext, $id_movie);
    //     $up->execute();
    //     $up->close();
    // }

    // Query insert gambar ke database
    $insGambar = $mysqli->prepare("INSERT INTO gambar(extension, idmovie) VALUES(?, ?)");
    // looping dari awal hingga akhir sebanyak jumlah file yang diupload
    for ($i=0; $i < count($_FILES['gambar']['name']); $i++) {
        // if (move_uploaded_file($_FILES['gambar']['tmp_name'][$i], $destination)) {
            $ext = strtolower(pathinfo($_FILES['gambar']['name'][$i], PATHINFO_EXTENSION));
    
            $insGambar->bind_param("si", $ext, $id_movie);
            $insGambar->execute();

            // get latest id gambar
            $idgambar = $insGambar->insert_id;

            // proses rename gambar ke directory dengan nama file = [IDGAMBAR].[EXT] eg = 1.png
            $destination = __DIR__ . "/img/" . $idgambar . "." . $ext; // output: [ID_GAMBAR = 1].[EXT = PNG/JPG] eg = 1.png
            move_uploaded_file($_FILES['gambar']['tmp_name'][$i], $destination);
        // }
    }
    $insGambar->close();
}

$gm = $mysqli->prepare("INSERT INTO genre_movie(id_movie, id_genre) VALUES(?, ?)");
// berulang sesuai jumlah checkbox (genre) yang dipilih pengguna
// Action, Comedy
// INSERT genre_movie -> 2x
// Insert id_movie, id_genre (action)
// Insert id_movie, id_genre (comedy)

foreach($genre as $idgenre) {
    $gm->bind_param('ii', $id_movie, $idgenre);
    $gm->execute();
}


$mysqli->close();

header("location: get.php")

?>