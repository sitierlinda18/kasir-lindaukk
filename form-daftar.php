<!DOCTYPE html>


<html>

<head>
    <title>Form Produk Baru</title>
    <style>
        input[type=text],
        select {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type=submit] {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type=submit]:hover {
            background-color: #45a049;
        }

        div {
            border-radius: 5px;
            background-color: #f2f2f2;
            padding: 20px;
        }
    </style>
</head>

<body>

    <?php
    include("koneksi.php");

    // cek apakah tombol Submit sudah diklik atau belum
    if (isset($_POST['Submit'])) {

        // ambil data dari formulir
        $ProdukID = $_POST['ProdukID'];
        $NamaProduk = $_POST['NamaProduk'];
        $Harga = $_POST['Harga'];
        $Stok = $_POST['Stok'];

        // buat query
        $sql = "INSERT INTO produk (ProdukID, NamaProduk, Harga, Stok) VALUES ('$ProdukID', '$NamaProduk', '$Harga', '$Stok')";
        $query = mysqli_query($conn, $sql);

        // cek apakah query berhasil
        if ($query) {
            // jika berhasil, alihkan ke halaman produk.php dengan status=sukses
            header('Location: produk.php?status=sukses');
        } else {
            // jika gagal, alihkan ke halaman form ini dengan status=gagal
            header('Location: form_produk.php?status=gagal');
        }
    }
    ?>

    <h3>Form Insert Produk</h3>

    <div>
        <form action="" method="POST">

            <label for="ProdukID">Produk ID: </label>
            <input type="text" name="ProdukID" placeholder="ProdukID" />

            <label for="NamaProduk">Nama Produk: </label>
            <input type="text" name="NamaProduk" placeholder="NamaProduk" />

            <label for="Harga">Harga: </label>
            <input type="text" name="Harga" placeholder="Harga" />

            <label for="Stok">Stok: </label>
            <input type="text" name="Stok" placeholder="Stok" />

            <input type="submit" name="Submit"value="Submit">
        </form>
    </div>

</body>

</html>
