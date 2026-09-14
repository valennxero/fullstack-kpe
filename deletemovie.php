<?php
// require_once "koneksi.php"; // menyediakan variabel $mysqli

$mysqli = new mysqli("127.0.0.1", "root", "", "fullstack");

if ($mysqli->connect_errno) {
    echo "Failed to connect MySQL:" . $mysqli->connect_error;
}

// Homework 3: tangkap id movie dari query string (?idmovie=xx)
$idmovie = $_GET['idmovie'] ?? null;
if ($idmovie === null) {
    die("idmovie tidak ada di query string. Buka halaman lewat link 'Hapus Data'.");
}

// DELETE data movie sesuai idmovie (prepared statement)
$stmt = $mysqli->prepare("DELETE FROM movie WHERE idmovie=?");
$stmt->bind_param('i', $idmovie);

if ($stmt->execute()) {
    // Sukses -> kembali ke daftar movie
    header("location: get.php");
    exit();
} else {
    echo "Gagal menghapus data: " . $stmt->error;
}

$stmt->close();
$mysqli->close();
