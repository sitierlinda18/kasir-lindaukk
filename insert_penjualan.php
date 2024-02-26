
<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit(); 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Insert Penjualan</title>
    
    <style>
    body {
        background-color: #e6ffe6; /* Light green background color */
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .container {
        width: 50%;
        margin: 20px auto;
        padding: 20px;
        background-color: #f0fff0; /* Light green container background */
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
        color: #008000; /* Green text color */
        margin-bottom: 20px;
        text-align: center;
    }

    label {
        font-weight: bold;
        color: #008000; /* Green text color */
    }

    input[type="text"],
    input[type="date"],
    select {
        width: calc(100% - 20px);
        padding: 10px;
        margin: 8px 0;
        border: 1px solid #6b8e23; /* Olive border color */
        border-radius: 5px;
        box-sizing: border-box;
    }

    input[type="submit"],
    button {
        padding: 12px 20px;
        border: none;
        border-radius: 5px;
        background-color: #008000; /* Green button background */
        color: #fff;
        cursor: pointer;
        margin-right: 10px;
    }

    input[type="submit"]:hover,
    button:hover {
        background-color: #006400; /* Darker green on hover */
    }

    button {
        background-color: #ccc; /* Gray cancel button background */
        color: #000;
    }

    button:hover {
        background-color: #999; /* Darker gray on hover */
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    th, td {
        border: 1px solid #6b8e23; /* Olive border color */
        padding: 12px;
        text-align: left;
    }

    th {
        background-color: #008000; /* Green header background */
        color: #fff;
    }
</style>

</head>
<body>
    <div class="container">
        <h2>Form Insert Penjualan</h2>
        <form action="" method="POST">
            <label for="PenjualanID">Penjualan ID:</label><br>
            <input type="text" id="PenjualanID" name="PenjualanID" required><br>
            
            <label for="DetailID">Detail ID:</label><br>
            <input type="text" id="DetailID" name="DetailID" required><br>
            
            <table border="1">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="detail_penjualan">
                    <!-- Baris detail penjualan akan ditambahkan secara dinamis menggunakan JavaScript -->
                </tbody>
            </table>
            <button type="button" onclick="tambahBaris()">Tambah Produk</button><br><br><br>
                
            <label for="TanggalPenjualan">Tanggal Penjualan:</label><br>
            <input type="date" id="TanggalPenjualan" name="TanggalPenjualan" required><br><br>
                
            <input type="submit" value="Submit"><br></br>
            <button type="button" onclick="cancel()">Cancel</button>
        </form>
    </div>

    <script>
    // Fungsi untuk mengambil data produk dari server menggunakan AJAX
    function getDataProduk(selectElement) {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "get_produk.php", true); // Sesuaikan dengan nama file PHP yang digunakan untuk mengambil data produk
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var response = xhr.responseText;
                selectElement.innerHTML = response;
            }
        };
        xhr.send();
    }

    function cancel() {
        window.location.href = "penjualan.php"; // Ganti dengan halaman tujuan untuk cancel
    }

    function tambahBaris() {
        var table = document.getElementById("detail_penjualan");
        var row = table.insertRow();
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        
        // Buat ID unik untuk elemen dropdown ProdukID
        var uniqueID = 'ProdukID_' + Math.random().toString(36).substr(2, 9);
        
        cell1.innerHTML = '<select id="' + uniqueID + '" name="ProdukID[]" required></select>'; // Kosongkan dulu dropdown
        cell2.innerHTML = '<input type="text" name="jumlah[]" onchange="hitungTotal()">'; // Ubah input menjadi text
        cell3.innerHTML = '<button type="button" onclick="hapusBaris(this)">Hapus</button>';
        
        // Panggil fungsi untuk mengambil data produk setelah menambahkan baris baru
        var selectElement = document.getElementById(uniqueID);
        getDataProduk(selectElement);
    }

    function hapusBaris(button) {
        var row = button.parentNode.parentNode;
        row.parentNode.removeChild(row);
        hitungTotal();
    }
    </script>


</body>
</html>

<?php
// Koneksi ke database
include "koneksi.php";

// Tangkap data dari formulir jika ada
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil nilai dari form
    $DetailID = $_POST['DetailID'];
    $PenjualanID = $_POST['PenjualanID'];
    $TanggalPenjualan = $_POST['TanggalPenjualan'];
    $JumlahProdukArray = $_POST['jumlah']; // Ubah menjadi array untuk menangkap jumlah produk
    $ProdukIDArray = $_POST['ProdukID']; // Ubah menjadi array untuk menangkap ID produk

    // Variabel untuk menyimpan total harga
    $totalHarga = 0;

    // Loop untuk setiap produk yang dibeli
    for ($i = 0; $i < count($ProdukIDArray); $i++) {
        // Ambil nilai dari form
        // Generate ID detail penjualan secara unik
        $ProdukID = $ProdukIDArray[$i];
        $JumlahProduk = $JumlahProdukArray[$i];

        // Ambil harga produk dari tabel produk
        $sql_harga_produk = "SELECT Harga, Stok FROM produk WHERE ProdukID = '$ProdukID'";
        $result_produk = $conn->query($sql_harga_produk);

        if ($result_produk->num_rows > 0) {
            $row_produk = $result_produk->fetch_assoc();
            $Harga = $row_produk['Harga'];
            $Stok = $row_produk['Stok'];

            // Cek apakah stok mencukupi
            if ($JumlahProduk <= $Stok) {
                // Kurangi stok
                $stokBaru = $Stok - $JumlahProduk;
                $sql_update_stok = "UPDATE produk SET Stok = '$stokBaru' WHERE ProdukID = '$ProdukID'";
                if ($conn->query($sql_update_stok) !== TRUE) {
                    echo "Error updating stok: " . $conn->error;
                }

                // Hitung subtotal
                $SubTotal = $JumlahProduk * $Harga;
                $totalHarga += $SubTotal;

                // Query untuk menyimpan data ke dalam tabel detail_penjualan
                $sql_detail_penjualan = "INSERT INTO detail_penjualan (DetailID, PenjualanID, ProdukID, JumlahProduk, SubTotal) VALUES ('$DetailID', '$PenjualanID', '$ProdukID', '$JumlahProduk', '$SubTotal')";

                if ($conn->query($sql_detail_penjualan) !== TRUE) {
                    echo "Error inserting detail penjualan: " . $conn->error;
                }
            } else {
                echo "Stok produk tidak mencukupi untuk produk dengan ID: " . $ProdukID;
            }
        } else {
            echo "Error fetching produk data: " . $conn->error;
        }
    }

    // Query untuk menyimpan data ke dalam tabel penjualan
    $sql_penjualan = "INSERT INTO penjualan (PenjualanID, TanggalPenjualan, TotalHarga) VALUES ('$PenjualanID', '$TanggalPenjualan', '$totalHarga')";

    if ($conn->query($sql_penjualan) === TRUE) {
      echo"<script>window.location='tabel_detail.php';</script>";
       
        exit();
    } else {
        echo "Error inserting penjualan data: " . $conn->error;
    }
}

// Tutup koneksi
$conn->close();
?>