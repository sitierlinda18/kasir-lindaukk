<?php 
include 'koneksi.php';


$DetailID = $_GET['DetailID'];
$sqlPenjualan = "DELETE FROM detail_penjualan WHERE DetailID='$DetailID'";
$conn->query($sqlPenjualan);
  

header("Location: tabel_detail.php");
exit();

?>