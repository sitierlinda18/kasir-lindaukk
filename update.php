<?php

include("koneksi.php");

// cek apakah tombol simpan sudah diklik atau blum?
if(isset($_POST['simpan'])){

    // ambil data dari formulir
    $ProdukID = $_POST['ProdukID'];
    $NamaProduk = $_POST['NamaProduk'];
    $Harga = $_POST['Harga'];
    $Stok = $_POST['Stok'];
    

    // buat query update
    $sql = "UPDATE Produk SET NamaProduk='$NamaProduk', Harga='$Harga', Stok='$Stok' WHERE ProdukID=$id";
    $query = mysqli_query($conn, $sql);

    // apakah query update berhasil?
    if( $query ) {
        // kalau berhasil alihkan ke halaman produk.php
        header('Location: produk.php');
    } else {
        // kalau gagal tampilkan pesan
        die("Gagal menyimpan perubahan...");
    }


} else {
    die("Akses dilarang...");
}

?>

if ($conn->query($sql) === TRUE) {
        // Jika update berhasil, redirect ke halaman produk.php
        header("Location: produk.php");
        exit;
    } else {
        // Jika terjadi kesalahan, tampilkan pesan error
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Tutup koneksi
$conn->close();
?>