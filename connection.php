<?php

// ip server db 192.168.1.1
// user = root super admin
// password
// nama database
$mysqli = new mysqli("127.0.0.1", "root", "", "fullstack");
if ($mysqli->connect_errno) {
    die("Failed to connect database MySQL: " . $mysqli->connect_error);
}

// tidak ada echo, tidak ada close() di sini —
// biar $mysqli tetap bisa dipakai oleh file yang me-require ini