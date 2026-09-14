<?php
$mysqli = new mysqli("127.0.0.1", "root", "", "fullstack");

if ($mysqli->connect_errno) {
    echo "Failed to connect MySQL:" . $mysqli->connect_error;
}

$genres = $mysqli->query("SELECT * FROM genre ORDER BY nama");

$pemain = $mysqli->query("SELECT * FROM pemain ORDER BY nama");

?>
         
<html>
    <head>
        <title>Insert Movie</title>
        <script src="jquery-3.7.1.js"></script>
        <script src="app.js"></script>
        <script>
            $(function () {
                // Menambahkan input gambar baru
                $("#btnTambahGambar").on("click", function () {
                    var inputFile = 
                    '<div class="baris-gambar"> ' +
                    '    <input type="file" name="gambar[]" /> ' +
                    '    <button type="button" class="btnHapusGambar"> ' +
                    '        Hapus Gambar ' +
                    '    </button> ' +
                    '</div> ' +
                    '<br/>';
                    // $(this).after(inputFile);
                    $("#divGambar").append(inputFile);
                });

                // Menghapus input gambar
                $("#divGambar").on("click", ".btnHapusGambar", function() {
                    // $(this).prev("input[type='file']").remove();
                    // $(this).remove();
                    $(this).closest(".baris-gambar").remove();
                })

                $("#btnTambahPemain").on("click", function() {
                    // Get value dari combobox pemain dan peran
                    var idpemain = $("select[name='pemain']").val();
                    // Mendapatkan nama pemain atau label dari option yang terpilih
                    var namaPemain = $("select[name='pemain'] option:selected").text();
                    var peran = $("select[name='peran']").val();

                    var barisPemain = 
                    '<tr> ' +
                    '    <td> <input type="hidden" name="pemain[]" value = "'+ idpemain +'" /> ' + namaPemain + '</td> ' +
                    '    <td> '+ 
                    '<select name="peran[]"> ' +
                    '        <option value="Utama" ' + (peran === "Utama" ? "selected" : "") + '>Utama</option> ' +
                    '        <option value="Pendukung" ' + (peran === "Pendukung" ? "selected" : "") + '>Pendukung</option> ' +
                    '        <option value="Cameo" ' + (peran === "Cameo" ? "selected" : "") + '>Cameo</option> ' +
                    '</select>' +
                    '</td> ' +
                    '    <td> ' +
                    '        <button type="button" class="btnHapusPemain">Hapus</button> ' +
                    '    </td> ' +
                    '</tr>';

                    $("#tblPemain tbody").append(barisPemain);
                });

                $("#tblPemain").on("click", ".btnHapusPemain", function() {
                    $(this).closest("tr").remove();
                });


            });
        </script>
    </head>
    <body>
        <h1>Insert Movie</h1>
        <form action="insertmovie_proses.php" method="post" enctype="multipart/form-data">
            <label>Judul</label>
            <input type="text" id="judul" name="judul" required />
            <br>
            <label>Tanggal Rilis</label>
            <input type="date" id="rilis" name="rilis" required />
            <br>
            <label>Skor</label>
            <input type="number" id="skor" name="skor" required />
            <br>
            <label>Sinopsis</label>
            <textarea id="sinopsis" name="sinopsis"></textarea>
            <br>
            <label>Serial</label>
            <select id="serial" name="serial">
                <option value="1">Ya</option>
                <option value="0">Tidak</option>
            </select>
            <br>

            <label>Genre Old</label>
            <select id="genre" name="genre">
                <option value="action">Action</option>
                <option value="adventure">Adventure</option>
                <option value="comedy">Comedy</option>
            </select>

            <br>

            <label>Genre New (Multiple)</label>

            <?php while($g = $genres->fetch_assoc()): ?>
            <label>
                <input type="checkbox" name="genre[]"
                value = "<?php echo $g['idgenre'] ?>">
                <?php echo $g['nama'] ?>
            </label>
            <?php endwhile; ?>

            <!-- <label>
                <input type="checkbox" name="genre[]"
                value = "1">Action
                <input type="checkbox" name="genre[]"
                value = "2">Comedy
            </label> -->

            <br>
            
            <!-- <label>Poster Movie</label>
            <input type="file" name="gambar" /> -->

            <!-- Membuat button tambah gambar -->
            <label>Gambar</label>
            <button type="button" id="btnTambahGambar">Tambah Gambar</button>
            <div id="divGambar">
                <input type="file" name="gambar[]" />
                
                <br>
                
            </div>

            <br>
            <label>Pemain</label>
            <select name="pemain">
                <?php while ($p = $pemain->fetch_assoc()) : ?>                
                    <option value="<?php echo $p['idpemain']; ?>">
                        <?php echo $p['nama']; ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <select name="peran">
                <option value"Utama">Utama</option>
                <option value"Pendukung">Pendukung</option>
                <option value="Cameo">Cameo</option>

            </select>

            <button type="button" id="btnTambahPemain">Tambah Pemain</button>

            <br><br>

            <table border="1" id="tblPemain">
                <thead>
                    <tr>
                        <td>Pemain</td>
                        <td>Peran</td>
                        <td>Aksi</td>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>

                <br><br>
            <input type="submit" value="Insert Movie">
        </form>
    </body>
</html>