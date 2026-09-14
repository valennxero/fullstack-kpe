<?php
// require_once "koneksi.php"; // menyediakan variabel $mysqli

require_once "movie.php";
// Declare variable bertipe object class movie
$movie = new movie();
// $total = $movie->getTotalData();
// $resDataMovie = $movie->getMovie("", 0, 5); 


$mysqli = new mysqli("127.0.0.1", "root", "", "fullstack");

if ($mysqli->connect_errno) {
    echo "Failed to connect MySQL:" . $mysqli->connect_error;
}

$keyword = $_GET['judul'] ?? "";

// Ambil semua movie
$stmt = $mysqli->prepare("SELECT m.*,
GROUP_CONCAT(g.nama ORDER BY g.nama SEPARATOR ', ') AS genre_list 
FROM movie m 
LEFT JOIN genre_movie gm
ON gm.id_movie = m.idmovie
LEFT JOIN genre g
ON g.idgenre = gm.id_genre
WHERE m.judul LIKE CONCAT('%', ?, '%')
GROUP BY m.idmovie ");
$stmt->bind_param('s', $keyword);
$stmt->execute();
$res = $stmt->get_result();


// Ambil semua pemain untuk setiap movie
$qPemain = $mysqli->prepare("SELECT p.nama FROM pemain p
JOIN detail_pemain dp ON dp.idpemain = p.idpemain
WHERE dp.idmovie = ?");

// 1. Tentukan Total Data per Page
$totalPerPage = 5; // SET 5
define('DEFAULT_TOTAL_PER_PAGE', 5);
// replace dengan user define = 7
$totalPerPage = DEFAULT_TOTAL_PER_PAGE; 

// 2. Tentukan hendak menampilkan Page ke berapa
// User nya tidak kirim parameter page
// User berada di halaman pertama
// User kirim parameter page = 3 berarti user akan akses page 3
$page = (int)($_GET['page'] ?? 1);   // cast ke int (kalau ?page=abc -> 0)
if ($page < 1) $page = 1;            // KUNCI: jangan sampai < 1, biar offset tidak negatif

// 3. Tentukan Offset
// $page = 1 => (1 - 1) * 5 = 0
// $page = 2 => (2 - 1) * 5 = 5
// $page = 3 => (3 - 1) * 5 = 10
$offset = ($page - 1) * $totalPerPage;

// 4. Cari jumlah data dari query SELECT tanpa limit
// Table movie => jumlah data = 12
// SELECT COUNT(*) FROM [table_name] => 12
// $totalData = 12
// $totalDataQuery = $mysqli->query("SELECT COUNT(*) as totalData FROM movie");
// // Jika menerapkan filter judul maka where condition di query where nya perlu diterapkan
// $totalDataQuery = $mysqli->query("SELECT COUNT(*) as totalData FROM movie WHERE judul LIKE '%" . $keyword . "%'");

//$totalData = $totalDataQuery->fetch_assoc()['totalData'];
$totalData = $movie->getTotalData("");

// 5. Lakukan query kembali dengan menggunakan limit
// SELECT * FROM movie LIMIT 5 OFFSET 0
// Total data = 12
// parameter page = 1 => Data yang ditampilkan: 1-5
// parameter page = 2 => Data yang ditampilkan: 6-10
// parameter page = 3 => Data yang ditampilkan: 11-12
// $stmt = $mysqli->prepare("SELECT * FROM movie ORDER BY judul ASC LIMIT ? OFFSET ?");
// // // Jika menerapkan filter judul maka where condition di query where nya perlu diterapkan
// // $stmt = $mysqli->prepare("SELECT * FROM movie WHERE judul LIKE '%" . $keyword . "%' ORDER BY judul ASC LIMIT ? OFFSET ?");
// $stmt->bind_param('ii', $totalPerPage, $offset);
// $stmt->execute();
// $resDataPagination = $stmt->get_result();
$resDataPagination = $movie->getMovie("", $offset, $totalPerPage);

// 6. Cari tahu maksimal page yang mungkin
// $totalData = 12
// $totalPerPage = 5
// $totalPage = ceil(12 / 5) = 3;
$totalPage = ceil($totalData / $totalPerPage);

// 7. Tampilkan nomor halaman

?>
<!DOCTYPE html>
<html>
<head>
    <title>Daftar Movie</title>
    <style>
        /* Homework 1: baris movie dengan skor < 5 dibuat merah */
        table { border-collapse: collapse; }
        th, td { padding: 4px 8px; }
        .teks-merah td { color: red; }
    </style>
</head>
<body>
    <div>
        <h1>My Movie</h1>
    </div>

    <div>
        <div id="menu">
            <a href="get.php">Daftar Movie</a>
            <a href="pemain.php">Daftar Pemain</a>
        </div>
    </div>

    <div>

        <h1>Daftar Movie</h1>
        <p><a href="insertmovie.php">+ Tambah Movie</a></p>

        <table border="1">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Rilis</th>
                    <th>Skor</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $resDataPagination->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $row['judul']; ?></td>
                        <td><?php echo $row['rilis']; ?></td>
                        <td><?php echo $row['skor']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>


        <!-- // 7. Menampilkan nomor halaman -->
        <!-- First menuju ke page paling awal => page = 1 -->
        <a href="get.php?page=1">First</a>

        <!-- 
            Kalau berada di halaman pertama
            Tombol previous tidak muncul
            Parameter page > 1 => Tombol previous muncul
            $page diperoleh dari $_GET['page'] ?? 1 
        -->
        <?php if($page > 1) : ?>
            <a href="get.php?page=<?php echo $page - 1; ?>">Previous</a>
        <?php endif; ?>

        <?php
        // Akan menampilkan page number
        // Starting point = 1 (inisialisasi value $i)
        // Page terakhir = $totalPage => $totalPage = 4
        // 1, 2, 3, 4 => Result dari pagination
        for ($i = 1; $i<= $totalPage; $i++): ?>
            <a href="get.php?page=<?php echo $i; ?>">
                <?php echo $i; ?>
            </a>
        <?php endfor; ?>

        <!-- 
        Kalau halaman bukan di halaman terakhir
        Tombol Next akan dimunculkan 
        -->
        <?php if($page < $totalPage) : ?>
            <a href="get.php?page=<?php echo $page + 1;?>">Next</a>
        <?php endif; ?>

        <!-- Akan mengarah ke halaman paling akhir 
        dimana halaman terakhir akan sesuai dengan $totalPage -->
        <a href="get.php?page=<?php echo $totalPage; ?>">Last</a>


        <br><br>
        <!-- Membuat textbox baru untuk pencarian judul movie -->
        <form action="get.php" method="get">
            <label>Masukkan Judul</label>
            <input type="text" name="judul" />
            <input type="submit" value="Search" />
        </form>

        <table border="1">
            <tr>
                <th>Judul</th>
                <th>Poster Film</th>
                <th>Tgl. Rilis</th>
                <th>Skor</th>
                <th>Sinopsis</th>
                <th>Serial?</th>
                <th>Genre</th>
                <th>Pemain</th>
                <th>Aksi</th>
            </tr>
            <?php while ($row = $res->fetch_assoc()) : ?>
                <?php
                // Homework 1: kalau skor < 5, beri class "teks-merah" ke seluruh baris
                $kelas = ($row['skor'] < 5) ? "teks-merah" : "";
                ?>
                <tr class="<?php echo $kelas; ?>">
                    <td><?php echo $row['judul']; ?></td>
                    <td>
                        <?php
                        if ($row['extention_new'] != null):
                        ?>
                        <img
                        src="img/<?php echo $row["idmovie"]
                        . "." . $row['extention_new']; ?>"
                        height="100px"
                        />
                        <?php else: ?>
                        -
                        <?php
                        endif;
                        ?>
                    </td>
                    <td><?php echo date('d-M-Y', strtotime($row['rilis'])); ?></td>
                    <td><?php echo $row['skor']; ?></td>
                    <td><?php echo $row['sinopsis']; ?></td>
                    <td><?php echo ($row['serial'] == "0" ? "Tidak" : "Ya"); ?></td>
                    <td>
                        <?php 
                            // echo $row['genre']; 
                            echo $row['genre_list'];
                        ?>
                    </td>
                    <td>
                        <?php 
                            $qPemain->bind_param('i', $row['idmovie']);
                            $qPemain->execute();
                            $resPemain = $qPemain->get_result();
                            while ($rowPemain = $resPemain->fetch_assoc()) {
                                echo $rowPemain['nama'] . "<br>";
                            }
                        ?>
                    </td>
                    <td>
                        <!-- Homework 2: link Ubah Data -->
                        <a href="editmovie.php?idmovie=<?php echo $row['idmovie']; ?>">Ubah Data</a>
                        &nbsp;
                        <!-- Homework 3: link Hapus Data -->
                        <a href="deletemovie.php?idmovie=<?php echo $row['idmovie']; ?>"
                        onclick="return confirm('Yakin ingin menghapus movie ini?');">Hapus Data</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
<?php
$stmt->close();
$mysqli->close();
?>
