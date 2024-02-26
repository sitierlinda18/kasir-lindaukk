<?php
include("koneksi.php");

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit(); 
}

// Check if PenjualanID is provided in the URL
if(isset($_GET['id'])) {
    $penjualanID = $_GET['id'];

    // Fetch the existing penjualan data
    $sql = "SELECT * FROM penjualan WHERE PenjualanID = '$penjualanID'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0) {
        $penjualan = mysqli_fetch_assoc($result);
    } else {
        echo "Penjualan not found.";
        exit();
    }
} else {
    echo "Penjualan ID not provided.";
    exit();
}

// Check if the form is submitted for updating the data
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve updated data from the form
    $newTanggalPenjualan = $_POST['tanggal_penjualan'];
    $newTotalHarga = $_POST['total_harga'];

    // Update the penjualan data in the database
    $updateQuery = "UPDATE penjualan SET
                    TanggalPenjualan = '$newTanggalPenjualan',
                    TotalHarga = '$newTotalHarga'
                    WHERE PenjualanID = '$penjualanID'";

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
    <title>Edit Penjualan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h2 {
            color: #333;
        }

        form {
            max-width: 400px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #04AA6D;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #21825A;
        }

        a {
            display: block;
            margin-top: 10px;
            color: #333;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <h2>Form Edit Penjualan</h2>

    <form method="post" action="">
        <label for="tanggal_penjualan">Tanggal Penjualan:</label>
        <input type="date" name="tanggal_penjualan" value="<?php echo $penjualan['TanggalPenjualan']; ?>">

        <label for="total_harga">Total Harga:</label>
        <input type="text" name="total_harga" value="<?php echo $penjualan['TotalHarga']; ?>">

        <input type="submit" value="Update">
    </form>

    <a href="penjualan.php">Back to Penjualan List</a>

</body>
</html>
