<?php
// pesan & nilai lama dikirim lewat query string (?error=...), tidak pakai session
$error   = $_GET["error"] ?? "";
$success = $_GET["success"] ?? "";
$old_iduser = $_GET["iduser"] ?? "";
$old_nama   = $_GET["nama"] ?? "";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
</head>
<body>
    <h2>Registrasi Akun Baru</h2>

    <?php if ($error): ?>
        <p style="color:red;"><?= htmlentities($error) ?></p>
    <?php endif; ?>

    <?php if ($success): ?>
        <p style="color:green;"><?= htmlentities($success) ?>
        <a href="login.php">Ke halaman login</a></p>
    <?php endif; ?>

    <form method="post" action="registration_proses.php">
        <label>ID User:</label><br>
        <input type="text" name="iduser" value="<?= htmlentities($old_iduser) ?>" required><br><br>

        <label>Nama Pengguna:</label><br>
        <input type="text" name="nama" value="<?= htmlentities($old_nama) ?>" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <label>Konfirmasi Password:</label><br>
        <input type="password" name="confirm_password" required><br><br>

        <button type="submit">Daftar</button>
    </form>

    <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
</body>
</html>