<?php
session_start();
require "db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $iduser   = htmlentities(trim($_POST["iduser"] ?? ""));
    $password = $_POST["password"] ?? "";

    if ($iduser === "" || $password === "") {
        $error = "ID User dan password wajib diisi.";
    } else {
        // ambil hash password dari database berdasarkan iduser (prepared statement)
        $stmt = $mysqli->prepare("SELECT iduser, nama, password FROM users WHERE iduser = ?");
        $stmt->bind_param("s", $iduser);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();

        // ---- Otentikasi: bandingkan password polos dengan hash tersimpan ----
        if ($user && password_verify($password, $user["password"])) {
            // login sukses -> simpan data di session
            $_SESSION["iduser"] = $user["iduser"];
            $_SESSION["nama"]   = $user["nama"];

            header("Location: home.php");
            exit;
        } else {
            // sengaja pesan error digeneralisasi (tidak bilang "iduser salah" vs "password salah")
            // supaya orang jahat tidak bisa menebak iduser mana yang valid
            $error = "ID User atau password salah.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>

    <?php if ($error): ?>
        <p style="color:red;"><?= $error ?></p>
    <?php endif; ?>

    <form method="post" action="login.php">
        <label>ID User:</label><br>
        <input type="text" name="iduser" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Login</button>
    </form>

    <p>Belum punya akun? <a href="Registration.php">Daftar di sini</a></p>
</body>
</html>