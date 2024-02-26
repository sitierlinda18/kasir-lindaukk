<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Detail Penjualan</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background-color: #f8f9fa;
            padding: 20px;
            width: 30%;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #495057;
            font-weight: bold;
        }

        select,
        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 16px;
            box-sizing: border-box;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }

        .button-container {
            text-align: center;
        }

        button {
            background-color: #E3651D;
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #EBC7E8;
        }

        .link-container {
            text-align: center;
            margin-top: 10px;
        }

        a {
            color: #E3651D;
            text-decoration: none;
            font-weight: ;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
<?php

include 'koneksi.php';
session_start();


if (isset($_GET['DetailID'])) {
    $DetailID = $_GET['DetailID'];

    //menampilkan data berdasarkan ID
    $data = mysqli_query($conn, "SELECT * FROM detail_penjualan where DetailID='$DetailID'");
    $data = mysqli_fetch_assoc($data);
}

if (isset($_POST['update'])) {
    $DetailID = $_GET['DetailID'];

    $DetailID = $_POST['DetailID'];
    $PenjualanID = $_POST['PenjualanID'];
    $ProdukID = $_POST['ProdukID'];
    $JumlahProduk = $_POST['JumlahProduk'];
    $SubTotal = $_POST['SubTotal'];

    // Menyimpan ke database;
    mysqli_query($conn, "UPDATE detail_penjualan SET DetailID='$DetailID', PenjualanID='$PenjualanID', ProdukID='$ProdukID', JumlahProduk='$JumlahProduk', SubTotal='$SubTotal' where DetailID='$DetailID' ");

    $_SESSION['success'] = 'Berhasil memperbaruhi data';

    // mengalihkan halaman ke list barang
    header('location:tabel_detail.php');
}

?>

<!-- ... (rest of your HTML code) ... -->

  <form action="" method="post">
        <center>
            <h1 class="display-3 fw-bolder mb-5"><span class="text-gradient d-inline">Form Update Penjualan</span></h1>
        </center>
        <label for="DetailID">DetailID:</label>
        <input type="text" id="DetailID" name="DetailID" value="<?= $data['DetailID'] ?>">

        <label for="PenjualanID">PenjualanID:</label>
        <input type="text" id="PenjualanID" name="PenjualanID" value="<?= $data['PenjualanID'] ?>">

        <label for="ProdukID">ProdukID:</label>
        <input type="text" id="ProdukID" name="ProdukID" value="<?= $data['ProdukID'] ?>">

        <label for="JumlahProduk">JumlahProduk:</label>
        <input type="text" id="JumlahProduk" name="JumlahProduk" value="<?= $data['JumlahProduk'] ?>" onchange="updateSubTotal()">

        <label for="SubTotal">SubTotal:</label>
        <input type="text" id="SubTotal" name="SubTotal" value="<?= $data['SubTotal'] ?>" readonly>

        <div class="button-container">
            <button type="submit" name="update" class="btn btn-primary">Update</button>
            <button type="reset" class="btn btn-danger">CANCEL</button>
        </div>
    </form>

    <script>
        function updateSubTotal() {
            // Get the values
            var jumlahProduk = document.getElementById('JumlahProduk').value;
            var hargaProduk = /* Add your logic to get the hargaProduk from ProdukID */;
            
            // Calculate SubTotal
            var subTotal = jumlahProduk * hargaProduk;

            // Update the SubTotal input field
            document.getElementById('SubTotal').value = subTotal;
        }
    </script>

</body>

</html>