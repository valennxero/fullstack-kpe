<?php
session_start();

// Guard: kalau belum login (session tidak valid), lempar ke login.php
if (!isset($_SESSION["iduser"])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
</head>
<body>
    <h2>Selamat datang, <?= htmlentities($_SESSION["nama"]) ?>!</h2>
    <p>ID User kamu: <?= htmlentities($_SESSION["iduser"]) ?></p>
    <a href="logout.php">Logout</a>
</body>
</html>