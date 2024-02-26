<?php include("koneksi.php"); ?>

<!DOCTYPE html>
<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit(); 
}
?>
<html>
<head>
    <title>Penjualan</title>
    <style>
        #customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #customers td, #customers th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #customers tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #customers tr:hover {
            background-color: #ddd;
        }

        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #04AA6D;
            color: white;
        }
    </style>
</head>
<body>

<h1>Data Penjualan</h1>

<form action="insert_penjualan.php" method="get">
    <label>Cari :</label>
    
    <input type="text" name="search">
    <input type="submit" value="Cari">
    <input type="submit" value="Tampilkan Semua">
</form>

<?php 
if(isset($_GET['search'])){
    $search = $_GET['search'];
    echo "<b>Hasil pencarian : ".$search."</b>";
}
?>

<body>
    <header>
        <h3>Penjualan Barang</h3>
    </header>
    
    <nav>
        <a href="insert_penjualan.php">[+] Tambah Baru</a>
    </nav>

    <br>

    <table id="customers">
        <thead>
            <tr>
                <th>Penjualan ID</th>
                <th>Tanggal Penjualan</th>
                <th>Total Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Construct the SQL query based on the search parameter
            $search = isset($_GET['search']) ? $_GET['search'] : '';
            $query = "SELECT * FROM penjualan WHERE 
                         PenjualanID LIKE '%$search%' OR
                         TanggalPenjualan LIKE '%$search%' OR
                         TotalHarga LIKE '%$search%'";

            $barang = mysqli_query($conn, $query);

            while($row = mysqli_fetch_array($barang)){
                echo "<tr>";
                echo "<td>".$row['PenjualanID']."</td>";
                echo "<td>".$row['TanggalPenjualan']."</td>";
                echo "<td>".$row['TotalHarga']."</td>";
                echo "<td>";
                echo "<a href='edit-penjualan.php?id=".$row['PenjualanID']."'>Edit</a> | ";
                echo "<a href='hapus-penjualan.php?PenjualanID=".$row['PenjualanID']."'>Hapus</a>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <p>Total: <?php echo mysqli_num_rows($barang) ?></p>

</body>
</html>
