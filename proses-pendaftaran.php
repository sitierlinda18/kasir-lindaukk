<?php

include("koneksi.php");

// cek apakah tombol daftar sudah diklik atau blum?
if(isset($_POST['Submit'])){

    // ambil data dari formulir
    $ProdukID = $_POST['ProdukID'];
    $NamaProduk = $_POST['NamaProduk'];
    $Harga = $_POST['Harga'];
    $Stok = $_POST['Stok'];


    // buat query
    $sql = "INSERT INTO produk (ProdukID, NamaProduk, Harga, Stok ) VALUE ('$ProdukID', '$NamaProduk', '$Harga', '$Stok')";
    $query = mysqli_query($conn, $sql);

    // apakah query simpan berhasil?
    if( $query ) {
        // kalau berhasil alihkan ke halaman index.php dengan status=sukses
        header('Location: produk.php?status=sukses');
    } else {
        // kalau gagal alihkan ke halaman indek.php dengan status=gagal
        header('Location: index.php?status=gagal');
    }
}

?>