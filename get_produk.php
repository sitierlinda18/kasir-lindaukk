<?php
include "koneksi.php";

// Query untuk mengambil data produk
$sql_produk = "SELECT ProdukID, NamaProduk FROM produk";
$result_produk = $conn->query($sql_produk);

// Buat dropdown option berdasarkan data produk yang diambil
$options = "";
if ($result_produk->num_rows > 0) {
    while($row_produk = $result_produk->fetch_assoc()) {
        $options .= '<option value="' . $row_produk['ProdukID'] . '">' . $row_produk['NamaProduk'] . '</option>';
    }
}

echo $options;

$conn->close();
?>