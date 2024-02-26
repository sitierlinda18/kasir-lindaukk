<?php
include("koneksi.php");


session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit(); 
}

// Check if PenjualanID is provided in the URL
if(isset($_GET['ProdukID'])) {
    $ProdukID = $_GET['ProdukID'];

    // Fetch the existing penjualan data
    $sql = "SELECT * FROM produk WHERE ProdukID = '$ProdukID'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0) {
        $barang = mysqli_fetch_assoc($result);
    } else {
        echo "Produk not found.";
        exit();
    }
} else {
    echo "Produk ID not provided.";
    exit();
}

// Check if the form is submitted for updating the data
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve updated data from the form
    $NamaProduk = $_POST['NamaProduk'];
    $Harga = $_POST['Harga'];
    $Stok = $_POST['Stok'];

    // Update the penjualan data in the database
    $updateQuery = "UPDATE produk SET
                    NamaProduk = '$NamaProduk',
                    Harga = '$Harga', Stok ='$Stok'
                    WHERE ProdukID = '$ProdukID'";

    if(mysqli_query($conn, $updateQuery)) {
        echo "Penjualan updated successfully!";
    } else {
        echo "Error updating penjualan: " . mysqli_error($conn);
    }
}

?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Edit Produk</title>
            <style>
                body {
                    font-family: Arial, Helvetica, sans-serif;
                    background-color: #f4f4f4;
                    margin: 0;
                    padding: 0;
                }

                h1 {
                    color: #333;
                }

                form {
                    max-width: 400px;
                    margin: 20px auto;
                    background: #fff;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                }

                label {
                    display: block;
                    margin-bottom: 8px;
                    color: #333;
                }

                input {
                    width: 100%;
                    padding: 10px;
                    margin-bottom: 15px;
                    box-sizing: border-box;
                }

                input[type="submit"] {
                    background: #04AA6D;
                    color: white;
                    cursor: pointer;
                }

                input[type="submit"]:hover {
                    background: #45a049;
                }
            </style>
        </head>
        <body>

            <h1>Form Edit Produk</h1>

            <form action="" method="post">
                <input type="hidden" name="ProdukID" value="<?php echo $barang['ProdukID']; ?>">

                <label>Nama Produk:</label>
                <input type="text" name="NamaProduk" value="<?php echo $barang['NamaProduk']; ?>" required>

                <label>Harga:</label>
                <input type="text" name="Harga" value="<?php echo $barang['Harga']; ?>" required>

                <label>Stok:</label>
                <input type="text" name="Stok" value="<?php echo $barang['Stok']; ?>" required>

                <input type="submit" value="Update Produk">
            </form>

            <a href="produk.php">Back to Produk List</a>
        </body>
        </html>
        <?php
   