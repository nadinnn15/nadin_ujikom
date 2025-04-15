<?php
include "koneksi.php";

// Ambil ID barang dari parameter GET (tetap ada karena mungkin digunakan untuk hal lain)
$ProdukID = isset($_GET['PenjualanID']) ? $_GET['PenjualanID'] : null;

// Jika ID barang ada, ambil data barang dari database (tetap ada)
if ($ProdukID) {
    $sql_produk = "SELECT * FROM produk WHERE ProdukID = $ProdukID";
    $result_produk = $koneksi->query($sql_produk);
    $barang = $result_produk->fetch_assoc();
} else {
    $barang = null;
}

// Ambil semua data barang untuk dropdown Produk (tetap ada)
$sql_semua_barang = "SELECT * FROM produk";
$result_semua_barang = $koneksi->query($sql_semua_barang);

// Ambil semua data toko untuk dropdown Nama Toko
$sql_semua_toko = "SELECT TokoID, NamaToko FROM toko";
$result_semua_toko = $koneksi->query($sql_semua_toko);


?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #80B9AD; /* Warna latar belakang utama */
            padding-top: 100px; /* Padding untuk navbar */
            font-family: 'Arial', sans-serif; /* Font umum */
        }
        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            border-radius: 8px;
            background-color: #FDFFE2; /* Warna latar belakang kontainer */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #504B38; /* Warna teks judul */
        }
        .header {
            background-color: #538392; /* Warna latar belakang header */
            padding: 20px;
            position: fixed; /* Navbar tetap di atas */
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3); /* Bayangan pada navbar */
        }
        .nav-link {
            color: #EBE5C2; /* Warna teks tautan navigasi */
        }
        .nav-link:hover {
            color: #212121; /* Warna teks tautan saat hover */
        }
        th {
            background-color: #B9B28A; /* Warna kolom judul */
            color: #D9DFC6;
            padding: 15px;
            text-align: left;
        }
        td {
            vertical-align: middle;
            padding: 15px;
            border-bottom: 1px solid #FDFFE2; /* Warna border */
        }
        tr:hover {
            background-color: #FFFDF0; /* Warna saat hover pada baris */
        }

        .btn-success, .btn-primary {
            background-color: #6295A2; /* Warna tombol */
            border: none; /* Menghilangkan border */
            transition: background-color 0.3s, transform 0.3s; /* Transisi warna dan transform */
        }

        .btn-success:hover, .btn-primary:hover {
            background-color: #1A2130; /* Warna tombol saat hover */
        }

    </style>
</head>
<body>
<header class="header p-4">
    <div class="d-flex justify-content-between align-items-center">
        <div class="text-lg font-weight-bold">GUDANG ALAT TULIS KANTOR</div>
        <nav class="nav">
            <a class="nav-link" href="tampil_produk.php">PRODUK</a>
            <a class="nav-link" href="data_penjualan.php">PENJUALAN</a>
            <a class="nav-link" href="detail_penjualan.php">DETAIL PENJUALAN</a>
        </nav>
    </div>
</header>
<div class="container mt-5">
    <h2>Tambah Data Penjualan</h2>
    <form action="update_penjualan.php" method="POST">
        <div class="form-group">
            <label for="ProdukID">Nama Produk:</label>
            <select name="ProdukID" id="ProdukID" class="form-control" required onchange="updateHarga()">
                <option value="">Pilih Produk</option>
                <?php while ($semua_barang = $result_semua_barang->fetch_assoc()): ?>
                    <option value="<?= $semua_barang['ProdukID'] ?>" <?= ($barang && $barang['ProdukID'] == $semua_barang['ProdukID']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($semua_barang['NamaProduk']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="Harga">Harga Produk/Pack:</label>
            <input type="number" id="Harga" name="Harga" class="form-control" value="<?= $barang ? $barang['Harga'] : '' ?>" required readonly>
        </div>

        <div class="form-group">
            <label for="Stok">Jumlah Produk:</label>
            <input type="number" id="Stok" name="Stok" class="form-control" oninput="validasiStok()">
        </div>

        <div class="form-group">
            <label for="Subtotal">Subtotal:</label>
            <input type="text" id="Subtotal" name="Subtotal" class="form-control" readonly>
        </div>

        <div class="form-group">
            <label for="TanggalPenjualan">Tanggal Penjualan:</label>
            <input type="date" id="TanggalPenjualan" name="TanggalPenjualan" class="form-control" value="<?= $penjualan ? $penjualan['TanggalPenjualan'] : '' ?>" required>
        </div>

        <div class="form-group">
            <label for="TokoID">Nama Toko:</label>
            <select name="TokoID" id="TokoID" class="form-control" required>
                <option value="">Pilih Toko</option>
                <?php while ($semua_toko = $result_semua_toko->fetch_assoc()): ?>
                    <option value="<?= $semua_toko['TokoID'] ?>">
                        <?= htmlspecialchars($semua_toko['NamaToko']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Tambah Data</button>
        <a href="tampil_produk.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<script>
    function updateHarga() {
        var produkID = document.getElementById("ProdukID").value;
        <?php
        $produk_harga = array();
        $result_harga = $koneksi->query("SELECT ProdukID, Harga FROM produk");
        while ($row = $result_harga->fetch_assoc()) {
            $produk_harga[$row['ProdukID']] = $row['Harga'];
        }
        echo "var hargaProduk = " . json_encode($produk_harga) . ";";
        ?>
        document.getElementById("Harga").value = hargaProduk[produkID] || '';
        validasiStok();
    }

    function validasiStok() {
        var produkID = document.getElementById("ProdukID").value;
        var stokInput = document.getElementById("Stok");
        var stokPenjualan = parseInt(stokInput.value) || 0;
        <?php
        $produk_stok = array();
        $result_stok = $koneksi->query("SELECT ProdukID, Stok FROM produk");
        while ($row = $result_stok->fetch_assoc()) {
            $produk_stok[$row['ProdukID']] = $row['Stok'];
        }
        echo "var stokProduk = " . json_encode($produk_stok) . ";";
        ?>
        var stokTersedia = parseInt(stokProduk[produkID]) || 0;

        if (stokPenjualan > stokTersedia) {
            alert("Stok tidak mencukupi. Stok tersedia: " + stokTersedia);
            stokInput.value = stokTersedia;
        }
        hitungSubtotal();
    }

    function hitungSubtotal() {
        var harga = document.getElementById("Harga").value;
        var stok = document.getElementById("Stok").value;
        var subtotal = harga * stok;
        document.getElementById("Subtotal").value = subtotal || '';
    }
</script>
</body>
</html>
