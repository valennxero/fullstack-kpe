<?php
$mysqli = new mysqli("127.0.0.1", "root", "", "fullstack");

if ($mysqli->connect_errno) {
    echo "Failed to connect MySQL:" . $mysqli->connect_error;
}

// Query Command ke Database
$stmt = $mysqli->prepare("SELECT * FROM movie");
// Execute Command Query
$stmt->execute();

// Return data from database
$res = $stmt->get_result();

echo "<table border='1'>
    <tr><th>Judul</th> <th>Tanggal Rilis</th> <th>Serial</th> <th>Genre</th> </tr>";

while($row = $res->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['judul'] . "</td>";
    echo "<td>" . date('d-M-y', strtotime($row['rilis'])) . "</td>";
    echo "<td>" . 
    ($row['serial'] == 0 ? "Tidak" : "Ya")
    . "</td>";
    echo "<td>" . $row['genre'] . "</td>";
    echo "</tr>";
}
// // Get first data
// $row = $res->fetch_assoc();
// echo $row['judul'] . '<br>';
// echo $row['genre'];

$stmt->close();
$mysqli->close();

?>