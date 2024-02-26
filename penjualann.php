
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'koneksi.php';

    $id_penjualan = $_POST["id_penjualan"];
    $tanggal_penjualan = $_POST["tanggal_penjualan"];
    $subtotal_harga = $_POST["subtotal_data"];
    $id_detail = $_POST["id_detail"];
    
    $produk_ids = $_POST["produk_id"];
    $jumlah_produks = $_POST["jumlah_produk"];
    $total_hargas = $_POST["total_harga"];
    $subtotals = $_POST["subtotal"];

    // Insert data into penjualan table
    $sqlPenjualan = "INSERT INTO penjualan (PenjualanID, TanggalPenjualan, TotalHarga) VALUES ('$id_penjualan', '$tanggal_penjualan', '$subtotal_harga')";
    $conn->query($sqlPenjualan);

    // Get the last inserted ID
    $lastID = $conn->insert_id;

    // Loop through each array element and insert data into detail_penjualan table
    for ($i = 0; $i < count($produk_ids); $i++) {
        $id_produk = $produk_ids[$i];
        $jumlah_produk = $jumlah_produks[$i];
        $total_harga = $total_hargas[$i];
        $subtotal = $subtotals[$i];

        $sqlDetailPenjualan = "INSERT INTO detail_penjualan (DetailID, PenjualanID, ProdukID, JumlahProduk, Subtotal) VALUES ('$id_detail', '$id_penjualan', '$id_produk', '$jumlah_produk', '$subtotal')";
        $conn->query($sqlDetailPenjualan);

        // Update stok in produk table
        $selSto = mysqli_query($conn, "SELECT * FROM produk WHERE ProdukID='$id_produk'");
        $sto = mysqli_fetch_array($selSto);
        $stok = $sto['stok'];
        // Calculate new stok
        $sisa = $stok + $jumlah_produk;

        // Update stok in produk table
        $upstok = mysqli_query($conn, "UPDATE produk SET Stok='$sisa' WHERE ProdukID='$id_produk'");
    }

    // Close the database connection
    $conn->close();

    // Redirect to a success page or do something else
    header("Location: tabel_detail.php");
    exit();
}
?>

<!DOCTYPE html>

<html>
<head>
	<title>Tambah Produk</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<style>
    body {
      font-family: 'Arial', sans-serif;
    }

    h1 {
      text-align: center;
      color: #333;
    }

    .form {
      max-width: 400px;
      margin: 0 auto;
      background-color: #f4f4f4;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .form-group {
      margin-bottom: 15px;
    }

    label {
      display: block;
      font-size: 14px;
      color: #555;
      margin-bottom: 5px;
    }

    input {
      width: 100%;
      padding: 8px;
      font-size: 14px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }

    input[type="date"] {
      padding: 6px;
    }

    .btn {
      display: inline-block;
      padding: 8px 12px;
      font-size: 14px;
      text-align: center;
      text-decoration: none;
      background-color: #3498db;
      color: #fff;
      border: 1px solid #3498db;
      border-radius: 4px;
      cursor: pointer;
    }

    .btn:hover {
      background-color: #2980b9;
    }

    /* Style untuk pop-up form */
    #form-popup {
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      padding: 20px;
      border: 1px solid #ccc;
      background-color: #fff;
      z-index: 1000;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    /* Style untuk tombol membuka pop-up */
    #open-popup-btn {
      display: block;
      margin-top: 15px;
      text-align: center;
      font-size: 14px;
      color: #3498db;
      cursor: pointer;
    }

    .container_item {
        background-color: #2980b9;
        color: white;
        font-size: 16px;
        cursor: pointer;
        padding: 5px;
        margin: 10px;
        border: 1px solid white;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .container_sutotal {
      display: block;
      margin-top: 15px;
      text-align: center;
      font-size: 14px;
      color: #db3434;
      cursor: pointer;
    }
  </style>
<body>
<div class="container">

<h1>Tambah Penjualan</h1>

  <!-- Form utama -->
  <form method="post" id="form">
    <div class="form">

      <!-- Elemen yang tetap ditampilkan -->
      <div class="form-group">
        <label>ID Penjualan</label>
        <input type="text" name="id_penjualan" class="form-control" placeholder="ID Penjualan">
      </div>
      <div class="form-group">
        <label>ID Detail</label>
        <input type="text" name="id_detail" class="form-control" placeholder="ID Detail">
      </div>
      <div class="form-group">
        <label>Tanggal Penjualan</label>
        <input type="date" name="tanggal_penjualan" class="form-control">
      </div>
      <div class="form-group">
        <label>Sub Total</label>
        <input type="text" readonly id="subtotal_data" class="form-control" placeholder="Harga Produk">
        <input type="hidden" id="subtotal-data" name="subtotal_data" class="form-control" placeholder="Harga Produk">
      </div>

      <!-- Tombol untuk membuka pop-up form -->
      <button type="button" id="open-popup-btn" class="btn btn-info">Next</button>

      <!-- Pop-up form untuk elemen ID Produk, Jumlah Produk, Harga Produk, dan SubTotal Produk -->
      <div id="form-popup">
        <div class="form-group">
          <label>ID Produk</label>
          <input type="text" id="id_produk" name="id_produk" class="form-control" placeholder="ID Produk">
        </div>
        <div class="form-group">
          <label>Jumlah Produk</label>
          <input type="number" id="jumlah_produk" name="jumlah_produk" class="form-control" placeholder="Jumlah Produk">
        </div>
        <div class="form-group">
          <label>Harga Produk</label>
          <input type="number" id="total_harga" name="total_harga" class="form-control" placeholder="Harga Produk">
        </div>
        <button type="button" id="back-to-main-btn" class="btn btn-primary">Kembali</button>
      </div>

      <input type="submit" readonly id="save_data" name="simpan" value="Simpan" class="btn btn-primary">
    </div>
    <div class="container" id="appended-data"></div>
  </form>

  <script>
    // Fungsi untuk membuka pop-up form
    document.getElementById('open-popup-btn').addEventListener('click', function() {
        document.getElementById('form-popup').style.display = 'block';
    });

    // Fungsi untuk kembali ke form utama
    document.getElementById('back-to-main-btn').addEventListener('click', function() {
        var id_produk = document.getElementById("id_produk").value; //? - Ambil value
        var jumlah_produk = document.getElementById("jumlah_produk").value; //? - Ambil value
        var total_harga = document.getElementById("total_harga").value; //? - Ambil value

        appendData(id_produk, jumlah_produk, total_harga); //? - Manggil function appendData
        updateSubtotal(); //? - Manggil function updateSubtotal
        document.getElementById('save_data').disabled = false;
        document.getElementById('form-popup').style.display = 'none';
    });

    // Fungsi untuk hitung subtotal
    function calculateSubtotal(jumlah_produk, total_harga) {
        return jumlah_produk * total_harga; //? - Perkalian Jumlah Subtotal
    }

    // Fungsi untuk menambahkan data baru ke dalam div appended-data
    function appendData(id_produk, jumlah_produk, total_harga) {
        var subtotal = calculateSubtotal(jumlah_produk, total_harga); //? - Manggil function calculateSubtotal

        var newData = document.createElement("div");
        newData.innerHTML = `
            <div class="container_item">
                <span>Id = ${id_produk}</span><br>
                <span>Jumlah_Produk = ${jumlah_produk}</span><br>
                <span>Harga_Produk = ${total_harga}</span><br>
                <span class='subtotal'>Total_Harga = ${subtotal}</span><br>
                <input type="hidden" name="produk_id[]" value="${id_produk}">
                <input type="hidden" name="jumlah_produk[]" value="${jumlah_produk}">
                <input type="hidden" name="total_harga[]" value="${total_harga}">
                <input type="hidden" name="subtotal[]" value="${subtotal}">
            </div>
        `; //? - Generate Div component
        document.getElementById("appended-data").appendChild(newData); //? - Append value newData
    }

    // Fungsi untuk mengupdate subtotal
    function updateSubtotal() {
        var subtotals = document.querySelectorAll(".subtotal");
        var total = 0;
        subtotals.forEach(function(subtotal) {
            total += parseFloat(subtotal.textContent.split('=')[1].trim());
        });
        
        document.getElementById("subtotal-data").value = total;
        document.getElementById("subtotal_data").value = total;
    }

    // Fungsi untuk generate input data Array
    function generateInputData() {
        var appendedDivs = document.querySelectorAll("#appended-data .container_item");
        var dataArray = [];
        appendedDivs.forEach(function(div) {
            var id_produk = div.querySelector("[name='produk_id[]']").value;
            var jumlah_produk = parseInt(div.querySelector("[name='jumlah_produk[]']").value);
            var total_harga = parseInt(div.querySelector("[name='total_harga[]']").value);
            var subtotal = parseInt(div.querySelector("[name='subtotal[]']").value);
            dataArray.push({
                id_produk: id_produk,
                jumlah_produk: jumlah_produk,
                total_harga: total_harga,
                subtotal: subtotal
            });
        });
        return dataArray;
    }

    // Function save data ke database
    document.getElementById('form').addEventListener('submit', function(event) {
        event.preventDefault();
        var formData = generateInputData();
        console.log(formData);
        this.submit();
    });
  </script>

</div>
</body>
</html>
