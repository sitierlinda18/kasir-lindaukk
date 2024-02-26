<?php include("koneksi.php"); ?>

<!DOCTYPE html>

<html>

<head>
    <title>Detail Penjualan</title>
    <style>
        #customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #customers td,
        #customers th {
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

    <h1>Tabel Detail Penjualan</h1>

    <form action="tabel_detail.php" method="get">
        <label>Cari :</label>
        <input type="text" name="cari">
        <input type="submit" value="Cari">
    </form>

    <?php
    if (isset($_GET['cari'])) {
        $cari = $_GET['cari'];
        echo "<b>Hasil pencarian : " . $cari . "</b>";
    }
    ?>

    <body>
        <header>
            <h3>Detail Produk</h3>
        </header>

        <nav>
            <a href="insert_penjualan.php">[+] Tambah Baru</a>
        </nav>

        <br>

        <table id="customers">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>ID Penjualan</th>
                    <th>Detail ID</th>
                    <th>Produk ID</th>
                    <th>Jumlah Produk</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>

                <?php
                $no = 1;
                if (isset($_GET['cari'])) {
                    $cari = $_GET['cari'];
                    // Search in the detail_penjualan table
                    $resultPenjualan = mysqli_query($conn, "SELECT * FROM penjualan");
                    $resultDetail = mysqli_query($conn, "SELECT * FROM detail_penjualan WHERE ProdukID LIKE '%$cari%'");

                    while ($rowDetail = mysqli_fetch_array($resultDetail)) {
                        $resultPenjualan = mysqli_query($conn, "SELECT * FROM penjualan WHERE PenjualanID = " . $rowDetail['PenjualanID']);
                        $rowPenjualan = mysqli_fetch_array($resultPenjualan);

                        echo "<tr>";
                        echo "<td>" . $no++ . "</td>";
                        echo "<td>" . $rowPenjualan['PenjualanID'] . "</td>";
                       
                        echo "<td>" . $rowDetail['DetailID'] . "</td>";
                        echo "<td>" . $rowDetail['ProdukID'] . "</td>";
                        echo "<td>" . $rowDetail['JumlahProduk'] . "</td>";
                       
                        echo "<td>" . $rowDetail['SubTotal'] . "</td>";
                        echo "<td>";
                        echo "<a href='edit_detail.php?DetailID=" . $rowDetail['DetailID'] . "'>Edit</a> | ";
                        echo "<a href='hapus-detail.php?DetailID=" . $rowDetail['DetailID'] . "'>Hapus</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    // Display all records if no search query
                    $resultPenjualan = mysqli_query($conn, "SELECT * FROM penjualan");
                    while ($rowPenjualan = mysqli_fetch_array($resultPenjualan)) {
                        $resultDetail = mysqli_query($conn, "SELECT * FROM detail_penjualan WHERE PenjualanID = " . $rowPenjualan['PenjualanID']);
                        while ($rowDetail = mysqli_fetch_array($resultDetail)) {
                            echo "<tr>";
                            echo "<td>" . $no++ . "</td>";
                            echo "<td>" . $rowPenjualan['PenjualanID'] . "</td>";
                            echo "<td>" . $rowDetail['DetailID'] . "</td>";
                            echo "<td>" . $rowDetail['ProdukID'] . "</td>";
                            echo "<td>" . $rowDetail['JumlahProduk'] . "</td>";
                            echo "<td>" . $rowDetail['SubTotal'] . "</td>";
                            echo "<td>";
                            echo "<a href='edit_detail.php?DetailID=" . $rowDetail['DetailID'] . "'>Edit</a> | ";
                            echo "<a href='hapus-detail.php?DetailID=" . $rowDetail['DetailID'] . "'>Hapus</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    }
                }
                ?>

            </tbody>
        </table>

        <p>Total: <?php echo mysqli_num_rows($resultPenjualan) ?></p>

    </body>
</html>
