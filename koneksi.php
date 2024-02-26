<?php
$dbhost= "localhost";
$dbuser= "root";
$dbpassword = "";
$dbname= "kasir_linda";

// Membuat koneksi
$conn = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);

// Mengecek koneksi
if (!$conn) {
  die("Koneksi gagal: " . mysqli_connect_error());
}

?>