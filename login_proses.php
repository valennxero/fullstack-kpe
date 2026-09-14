<?php
require "connection.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: login.php");
    exit;
}

$iduser   = htmlentities(trim($_POST["iduser"] ?? ""));
$password = $_POST["password"] ?? "";

if ($iduser === "" || $password === "") {
    header("Location: login.php?" . http_build_query([
        "error"  => "ID User dan password wajib diisi.",
        "iduser" => $iduser,
    ]));
    exit;
}

// ambil hash password dari database berdasarkan iduser (prepared statement)
$stmt = $mysqli->prepare("SELECT iduser, nama, password FROM users WHERE iduser = ?");
$stmt->bind_param("s", $iduser);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// ---- Otentikasi: bandingkan password polos dengan hash tersimpan ----
if ($user && password_verify($password, $user["password"])) {
    // session di sini BUKAN untuk kirim pesan, tapi untuk menyimpan status "sudah login"
    // supaya home.php tahu siapa yang sedang login
    session_start();
    $_SESSION["iduser"] = $user["iduser"];
    $_SESSION["nama"]   = $user["nama"];

    header("Location: home.php");
    exit;
} else {
    // pesan error digeneralisasi supaya tidak bocor iduser mana yang valid
    header("Location: login.php?" . http_build_query([
        "error"  => "ID User atau password salah.",
        "iduser" => $iduser,
    ]));
    exit;
}