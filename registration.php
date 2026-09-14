<?php
require "connection.php";

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // ambil input, langsung disanitasi dengan htmlentities() sesuai Tips #3 di materi
    $iduser        = htmlentities(trim($_POST["iduser"] ?? ""));
    $nama          = htmlentities(trim($_POST["nama"] ?? ""));
    $password      = $_POST["password"] ?? "";        // password JANGAN di-htmlentities, nanti hash-nya berubah
    $confirm_pass  = $_POST["confirm_password"] ?? "";

    // ---- Validasi ulang di sisi SERVER (Tips #1: jangan percaya validasi HTML5/JS saja) ----
    if ($iduser === "" || $nama === "" || $password === "" || $confirm_pass === "") {
        $error = "Semua field wajib diisi.";
    } elseif ($password !== $confirm_pass) {
        $error = "Konfirmasi password tidak cocok.";
    } elseif (strlen($password) < 6) {
        $error = "Password minimal 6 karakter.";
    } else {
        // cek apakah iduser sudah dipakai (pakai prepared statement, bukan concat string)
        $cek = $mysqli->prepare("SELECT iduser FROM users WHERE iduser = ?");
        $cek->bind_param("s", $iduser);
        $cek->execute();
        $cek->store_result();

        if ($cek->num_rows > 0) {
            $error = "ID User sudah terpakai, silakan pilih yang lain.";
        } else {
            // ---- Enkripsi password satu arah sebelum disimpan (materi "Enkripsi") ----
            $hash_password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $mysqli->prepare("INSERT INTO users (iduser, nama, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $iduser, $nama, $hash_password);

            if ($stmt->execute()) {
                $success = "Registrasi berhasil! Silakan login.";
            } else {
                $error = "Gagal menyimpan data: " . $stmt->error;
            }
            $stmt->close();
        }
        $cek->close();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
</head>
<body>
    <h2>Registrasi Akun Baru</h2>

    <?php if ($error): ?>
        <p style="color:red;"><?= $error ?></p>
    <?php endif; ?>

    <?php if ($success): ?>
        <p style="color:green;"><?= $success ?>
        <a href="login.php">Ke halaman login</a></p>
    <?php endif; ?>

    <form method="post" action="Registration.php">
        <label>ID User:</label><br>
        <input type="text" name="iduser" required><br><br>

        <label>Nama Pengguna:</label><br>
        <input type="text" name="nama" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <label>Konfirmasi Password:</label><br>
        <input type="password" name="confirm_password" required><br><br>

        <button type="submit">Daftar</button>
    </form>
</body>
</html>