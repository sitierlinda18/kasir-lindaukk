<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Detail Penjualan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background-color: #E5D4FF;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input, textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #7360DF;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #EBC7E8;
        }
    </style>
</head>
<body>
<?php
 include "koneksi.php";
// Create record


// Create record
if (isset($_POST['submit'])) {
    $PenjualanID = $_POST['PenjualanID'];
    $TanggalPenjualan = $_POST['TanggalPenjualan'];
    $DetailID = $_POST['DetailID'];
    $ProdukID = $_POST['ProdukID'];
    $JumlahProduk = $_POST['JumlahProduk'];

    // Validate and sanitize user input before using in SQL query
    // ...

    // Insert into penjualan table
    $sql_penjualan = "INSERT INTO penjualan (PenjualanID, TanggalPenjualan) VALUES ('$PenjualanID', '$TanggalPenjualan')";
    $conn->query($sql_penjualan);

    // Insert into detail_penjualan table
    $sql_detail_penjualan = "INSERT INTO detail_penjualan (DetailID, PenjualanID, ProdukID, JumlahProduk) VALUES ('$DetailID', '$PenjualanID', '$ProdukID', '$JumlahProduk')";
    $conn->query($sql_detail_penjualan);

    // Check if the queries were successful
    if ($conn->affected_rows > 0) {
        // If successful, redirect to tabel_detail.php
        header("location: tabel_detail.php");
        exit;
    } else {
        // If there's an error
        echo "Terjadi kesalahan saat menambahkan data";
    }
}

// Rest of your HTML form
?>


<form action="" method="post" enctype="multipart/form-data">
    <center>
        <h1 class="display-3 fw-bolder mb-5"><span class="text-gradient d-inline">Form Detail Penjualan</span></h1>
    </center>
    <label for="PenjualanID">ID Penjualan:</label>
    <input type="number" id="PenjualanID" name="PenjualanID" required>

    <label for="TanggalPenjualan">Tanggal:</label>
    <input type="date" id="TanggalPenjualan" name="TanggalPenjualan" required>

    <label for="DetailID">ID Detail:</label>
    <input type="number" id="DetailID" name="DetailID" required>
    <label>Produk ID</label>
    <select name="ProdukID" class="form-control">
        <option>Pilih</option>
        <?php
     $t_produk = mysqli_query($conn, "select ProdukID, NamaProduk, Harga, Stok from produk ");
     foreach ($t_produk as $barang)   {
        echo "<option value=$barang[ProdukID]>$barang[ProdukID]</option>";
     }
?>
</select>
    </div>
    <div class="form-group">
    <label for="Jumlah Produk">JumlahProduk</label>
    <input type="number" id="JumlahProduk" name="JumlahProduk" required>


    <button type="submit" name="submit">Kirim Data</button>
    <button type="reset" class="btn btn-danger mb-2">CANCEL</button>

    <br>
   
</form>


</body>
</html>