<?php
// include isi dari data.php
require_once("data.php");

class orangtua {
    // Memiliki protected member 
    // : object mysqli
    protected $mysqli;

    // Memiliki constructor dan 
    // di dalam constructor, 
    // langsung dilakukan koneksi ke database
    // Contructor di class orangtua
    public function __construct() {
        // Cara sebelumnya untuk konek ke database
        // $mysqli = 
        // new mysqli(
        //     "127.0.0.1", 
        //     "root", 
        //     "", 
        //     "fullstack_kpe"
        // );

        // Assign mysqli dengan koneksi ke database
        $this->mysqli = new mysqli(
            SERVER_NAME, 
            USER_NAME, 
            PASSWORD, 
            DB_NAME
        );

        if ($this->mysqli->connect_errno) {
            die("Failed to connect database MySQL: ". $this->mysqli->connect_error);
        }
    }

    // Memiliki destructor, 
    // yaitu melakukan close connection
    // pada object mysqli
    public function __destruct() {
        $this->mysqli->close();
    }

}
