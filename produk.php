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
    <title>Produk</title>
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

        #customers tr:nth-child(even){background-color: #f2f2f2;}

        #customers tr:hover {background-color: #ddd;}

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

    <h1>Data Produk</h1>

    <form action="" method="get">
        <label>Cari :</label>
        <input type="text" name="search">
        <input type="submit" value="Cari">
    </form>

    <?php 
    if(isset($_GET['search'])){
        $search = $_GET['search'];
        echo "<b>Hasil pencarian : ".$search."</b>";
    }
    ?>

    <body>
        <header>
            <h3>Produk Ready</h3>
        </header>
        
        <nav>
            <a href="form-daftar.php">[+] Tambah Baru</a>
        </nav>

        <br>

        <table id="customers">
            <thead>
                <tr>
                    <th>ProdukID</th>
                    <th>NamaProduk</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Tindakan</th>
                </tr>
            </thead>
            <tbody>

                <?php
                // Check if the search parameter is provided
                $search = isset($_GET['search']) ? $_GET['search'] : '';

                // Construct the SQL query based on the search parameter
                $query = "SELECT * FROM produk WHERE 
                           ProdukID LIKE '%$search%' OR
                           NamaProduk LIKE '%$search%' OR
                           Harga LIKE '%$search%' OR
                           Stok LIKE '%$search%'";

                $result = mysqli_query($conn, $query);

                while($barang = mysqli_fetch_array($result)){
                    echo "<tr>";
                    echo "<td>".$barang['ProdukID']."</td>";
                    echo "<td>".$barang['NamaProduk']."</td>";
                    echo "<td>".$barang['Harga']."</td>";
                    echo "<td>".$barang['Stok']."</td>";
                    
                    echo "<td>";
                    echo "<a href='edit-produk.php?ProdukID=".$barang['ProdukID']."'>Edit</a> | ";
                    echo "<a href='hapus-produk.php?id=".$barang['ProdukID']."'>Hapus</a>";
                    echo "</td>";

                    echo "</tr>";
                }
                ?>

            </tbody>
        </table>

        <p>Total: <?php echo mysqli_num_rows($result) ?></p>

   </body>
</html>
