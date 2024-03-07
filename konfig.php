<?php
//variabel inisialisasi
$servername= "localhost";
$username = "root";
$password = "";
$database= "dbnotes";

//create connection
$koneksi = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$koneksi) {
    die("KONEKSI GAGAL: " .mysqli_connect_error());
  }
 
?>