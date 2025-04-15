<?php
include "koneksi.php";

// Inisialisasi variabel pencarian
$search = isset($_GET['search']) ? $_GET['search'] : '';
$PenjualanID = isset($_GET['PenjualanID']) ? $_GET['PenjualanID'] : null;

// Query SQL dengan kondisi pencarian dan pengurutan tanggal
$sql = "SELECT penjualan.*, produk.NamaProduk FROM penjualan INNER JOIN produk ON penjualan.ProdukID = produk.ProdukID";

if (!empty($search)) {
    $sql .= " WHERE produk.NamaProduk LIKE '%$search%'"; // Perbaikan di sini
}

if ($PenjualanID) {
    $sql .= " WHERE PenjualanID = $PenjualanID";
}

$sql .= " ORDER BY TanggalPenjualan DESC"; // DESC untuk terbaru ke terlama

$query = mysqli_query($koneksi, $sql);
$result = mysqli_fetch_all($query, MYSQLI_ASSOC);

// Periksa apakah hasil query kosong
$found = !empty($result);

// Hitung total jumlah dan subtotal
$totalJumlah = 0;
$totalSubtotal = 0;
foreach ($result as $row) {
    $totalJumlah += $row['Stok'];
    $totalSubtotal += $row['Subtotal'];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Penjualan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #80B9AD; /* Warna latar belakang */
            padding-top: 100px; /* Padding untuk navbar */
            font-family: 'Arial', sans-serif; /* Font umum */
        }

        .header {
            background-color: #538392; /* Warna navbar */
            position: fixed; /* Navbar tetap di atas */
            top: 0; /* Menempelkan navbar ke bagian atas viewport */
            left: 0; /* Memastikan navbar membentang dari kiri */
            width: 100%; /* Memastikan navbar membentang selebar viewport */
            z-index: 1000; /* Memastikan navbar berada di atas konten lain */
            padding: 29px; /* Padding untuk navbar */
        }

        .header .nav-link {
            color: #EBE5C2; /* Warna tautan navbar */
        }

        .header .nav-link:hover {
            color: #504B38; /* Warna saat hover pada tautan */
        }

        .container {
            max-width: 1200px;
            margin: 40px auto;
            background-color: #FDFFE2; /* Latar belakang kontainer data */
            padding: 20px;
            border-radius: 10px; /* Sudut melengkung */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #504B38; /* Warna judul */
            font-weight: bold; /* Tebal */
        }

        table {
            width: 100%;
            margin-top: 20px; /* Jarak atas tabel */
        }

        th {
            background-color: #538392; /* Warna header tabel */
            color: #FDFFE2; /* Warna teks header tabel */
            padding: 10px;
            text-align: left;
        }

        td {
            padding: 10px;
            border-bottom: 1px solid #504B38; /* Garis bawah tabel */
        }

        tr:hover td {
            background-color: #FFFDF0; /* Warna saat hover pada baris tabel */
        }

        .btn-secondary {
            background-color: #538392; /* Warna tombol */
            border: none; /* Menghilangkan border */
        }

        .btn-secondary:hover {
            background-color: #1A2130; /* Warna tombol saat hover */

        }
        .btn-success, .btn-primary {
            background-color: #538392; /* Warna tombol */
            border: none; /* Menghilangkan border */
            transition: background-color 0.3s, transform 0.3s; /* Transisi warna dan transform */
        }

        .btn-success:hover, .btn-primary:hover {
            background-color: #1A2130; /* Warna tombol saat hover */
        }

        .input-group .form-control {
            border-radius: 20px; /* Sudut melengkung pada input */
            border: 1px solid #B9B28A; /* Border input */
            transition: border-color 0.3s; /* Transisi border */
        }

        .input-group .form-control:focus {
            border-color: #504B38; /* Warna border saat fokus */
            box-shadow: 0 0 5px rgba(80, 75, 56, 0.5); /* Bayangan saat fokus */
        }

        .input-group-append .btn {
            border-radius: 20px; /* Sudut melengkung pada tombol cari */
        }
    </style>
</head>
<body>
<header class="header">
    <div class="d-flex justify-content-between align-items-center">
        <div class="text-lg font-weight-bold" style="color: #FDFFE2;">GUDANG ALAT TULIS KANTOR</div>
        <nav class="nav">
            <a class="nav-link" href="tampil_produk.php">PRODUK</a>
            <a class="nav-link" href="data_penjualan.php">PENJUALAN</a>
            <a class="nav-link" href="detail_penjualan.php">DETAIL PENJUALAN</a>
        </nav>
    </div>
</header>

<div class="container mt-5">
    <h2>Detail Penjualan</h2>
    <div class="row mb-3">
        <div class="col-md-6">
            <form method="GET" action="detail_penjualan.php" class="form-inline">
                <div class="input-group">
                    <input type="text" name="search" id="search" class="form-control" placeholder="Cari Nama Produk..." value="<?= htmlspecialchars($search) ?>">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Harga Produk/Pack</th>
                <th>Produk Terjual</th></th>
                <th>Subtotal</th>
                <th>Tanggal Penjualan</th>
                <th>Nama Toko</th>
            </tr>
            </thead>
            <tbody>
                <?php if ($found): ?>
                    <?php foreach ($result as $row): ?>
                        <tr>
                            <td><?= $row['NamaProduk'] ?></td>
                            <td><?= $row['Harga'] ?></td>
                            <td><?= $row['Stok'] ?></td>
                            <td><?= $row['Subtotal'] ?></td>
                            <td><?= $row['TanggalPenjualan'] ?></td>
                            <td><?= $row['NamaToko'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">Barang yang Anda cari tidak ada.</td>
                    </tr>
                <?php endif; ?>
            </tbody><tfoot>
                <tr>
                    <td colspan="3" class="text-right"><strong>Total:</strong></td>
                    <td><?= $totalSubtotal ?></td>
                    <td></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </div>
</body>
</html>
