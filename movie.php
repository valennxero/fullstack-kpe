<?php
require_once "parent.php";

// class [NAMA_CLASS] extends [NAMA_CLASS_PARENT]
// 1. Inherit Parent Class
class movie extends orangtua {
    // 2. Memiliki constructor 
    // Di dalam constructor, 
    // memanggil constructor parent class
    public function __construct() {
        parent::__construct();
    }

    // 3. Siapkan public method getMovie()
    // 4. Menambahkan parameter $keyword_judul, $offset, $limit
    // Misal implement pagination dan ingin menampilkan page = 2
    // offset & limit 
    // limit 5
    // offset = 5
    public function getMovie(
        $keyword_judul, 
        $offset = null, 
        $limit = null) {
        $sql = "SELECT * FROM movie WHERE judul LIKE CONCAT('%', ?, '%')";
        if ($offset !== null && $limit !== null) {
            $sql .= " LIMIT ? OFFSET ?";
        }
        $stmt = $this->mysqli->prepare($sql);
        // Binding param dengan 3 parameter jika offset dan limit dikirim / tidak null
        if ($offset !== null && $limit !== null) {
            $stmt->bind_param('sii', $keyword_judul, $limit, $offset);
        } else { // Binding param hanya dengan 1 parameter judul
            $stmt->bind_param('s', $keyword_judul);
        }

        // Execute statement query
        $stmt->execute();

        // Return hasil query ke pemanggil method getMovie()
        return $stmt->get_result();
    }

    public function getTotalData($keyword_judul) {
        // Memanggil method getMovie() dengan parameter keyword_judul
        // Return total data dari query getMovie
        // Di database movie ada 16 data
        // keyword_judul => avenger
        // movie akan di filter dengan where condition judul like '%avenger%'
        // return total data num_rows sesuai dengan filter condition

        // misal keyword_judul =? ""
        // return all data dari table movie => 16 data
        return $this->getMovie($keyword_judul)->num_rows;
    }

    public function insertMovie($arr_col) {
        $sql = "INSERT INTO movie (judul, rilis, serial, skor, sinopsis) VALUES (?,?,?,?,?)";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("ssdss", 
            $arr_col['judul'], 
            $arr_col['rilis'], 
            $arr_col['serial'], 
            $arr_col['skor'], 
            $arr_col['sinopsis']
        );
        $stmt->execute();
        return $stmt->insert_id;
    }

    public function updateMovie($id, $arr_col){
        // UPDATE movie SET judul = ?
        // WHERE idmovie = ?
    }

    public function deleteMovie($id) {
        // DELETE from movie WHERE idmovie = ?
    }
    
}

?>