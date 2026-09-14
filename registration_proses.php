<?php
require "connection.php";

// file ini cuma boleh diakses lewat submit form (POST), bukan diakses langsung
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: registration.php");
    exit;
}

// ambil input, sanitasi dengan htmlentities() sesuai Tips #3 di materi
$iduser       = htmlentities(trim($_POST["iduser"] ?? ""));
$nama         = htmlentities(trim($_POST["nama"] ?? ""));
$password     = $_POST["password"] ?? "";       // password JANGAN di-htmlentities, nanti hash-nya berubah
$confirm_pass = $_POST["confirm_password"] ?? "";

// helper supaya nilai iduser & nama tetap terisi ulang di form kalau redirect balik
function redirect_with_error($error, $iduser, $nama) {
    $query = http_build_query([
        "error"  => $error,
        "iduser" => $iduser,
        "nama"   => $nama,
    ]);
    header("Location: registration.php?" . $query);
    exit;
}

// ---- Validasi ulang di sisi SERVER (Tips #1: jangan percaya validasi HTML5/JS saja) ----
if ($iduser === "" || $nama === "" || $password === "" || $confirm_pass === "") {
    redirect_with_error("Semua field wajib diisi.", $iduser, $nama);
}

if ($password !== $confirm_pass) {
    redirect_with_error("Konfirmasi password tidak cocok.", $iduser, $nama);
}

if (strlen($password) < 6) {
    redirect_with_error("Password minimal 6 karakter.", $iduser, $nama);
}

// cek apakah iduser sudah dipakai (prepared statement)
$cek = $mysqli->prepare("SELECT iduser FROM users WHERE iduser = ?");
$cek->bind_param("s", $iduser);
$cek->execute();
$cek->store_result();

if ($cek->num_rows > 0) {
    $cek->close();
    redirect_with_error("ID User sudah terpakai, silakan pilih yang lain.", $iduser, $nama);
}
$cek->close();

// ---- Enkripsi password satu arah sebelum disimpan (materi "Enkripsi") ----
$hash_password = password_hash($password, PASSWORD_DEFAULT);

$stmt = $mysqli->prepare("INSERT INTO users (iduser, nama, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $iduser, $nama, $hash_password);

if ($stmt->execute()) {
    $stmt->close();
    header("Location: registration.php?" . http_build_query([
        "success" => "Registrasi berhasil! Silakan login.",
    ]));
    exit;
} else {
    $err = $stmt->error;
    $stmt->close();
    redirect_with_error("Gagal menyimpan data: " . $err, $iduser, $nama);
}