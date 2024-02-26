<?php 
include 'koneksi.php';


$PenjualanID = $_GET['PenjualanID'];
$hasil = "DELETE FROM penjualan WHERE PenjualanID='$PenjualanID'";
$conn->query($hasil);
  

header("Location: penjualan.php");
exit();

?>