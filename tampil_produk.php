<?php
include "koneksi.php";

// Inisialisasi variabel pencarian
$search = isset($_GET['search']) ? $_GET['search'] : '';
$pesan = isset($_GET['pesan']) ? $_GET['pesan'] : ''; // Ambil pesan dari URL

// Query SQL dengan kondisi pencarian dan pengurutan
$sql = "SELECT * FROM produk";

if (!empty($search)) {
    $sql .= " WHERE NamaProduk LIKE '%$search%'";
}

// Tambahkan klausa ORDER BY untuk mengurutkan berdasarkan TanggalMasuk secara descending (terbaru di atas)
$sql .= " ORDER BY TanggalMasuk DESC";

$query = mysqli_query($koneksi, $sql);
$result = mysqli_fetch_all($query, MYSQLI_ASSOC);

// Periksa apakah hasil query kosong
$found = !empty($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Produk</title>
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
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3); /* Bayangan pada navbar */
        }

        .data-container {
            max-width: 1000px;
            margin: 40px auto 20px;
            background-color: #F3F7EC; /* Latar belakang kontainer data */
            padding: 30px;
            border-radius: 15px; /* Sudut melengkung */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s; /* Transisi saat hover */
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #504B38; /* Warna judul */
            font-weight: bold; /* Tebal */
        }

        table {
            font-size: 1.1rem;
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px; /* Jarak atas tabel */
        }

        th {
            background-color: #538392; /* Warna header tabel */
            color: #FDFFE2; /* Warna teks header tabel */
            padding: 15px;
            text-align: left;
            border-top-left-radius: 10px; /* Sudut melengkung */
            border-top-right-radius: 10px; /* Sudut melengkung */
        }

        td {
            vertical-align: middle;
            padding: 15px;
            border-bottom: 1px solid #D9DFC6; /* Garis bawah tabel */
            transition: background-color 0.3s; /* Transisi warna */
        }

        tr:hover td {
            background-color: #FFFDF0; /* Warna saat hover pada baris tabel */
        }

        .nav-link {
            color: #EBE5C2; /* Warna tautan navbar */
            transition: color 0.3s; /* Transisi warna */
        }

        .nav-link:hover {
            color: #504B38; /* Warna saat hover pada tautan */
        }

        .btn-success, .btn-primary {
            background-color: #80B9AD; /* Warna tombol */
            border: none; /* Menghilangkan border */
            transition: background-color 0.3s, transform 0.3s; /* Transisi warna dan transform */
        }

        .btn-success:hover, .btn-primary:hover {
            background-color: #6295A2; /* Warna tombol saat hover */
        }

        .input-group .form-control {
            border-radius: 20px; /* Sudut melengkung pada input */
            border: 1px solid #6295A2; /* Border input */
            transition: border-color 0.3s; /* Transisi border */
        }

        .input-group .form-control:focus {
            border-color: #6295A2; /* Warna border saat fokus */
            box-shadow: 0 0 5px rgba(80, 75, 56, 0.5); /* Bayangan saat fokus */
        }

        .input-group-append .btn {
            border-radius: 20px; /* Sudut melengkung pada tombol cari */
        }

        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #f9f9f9;
            border: 1px solid #ccc;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 1001;
        }
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }
        .popup-content {
            margin-bottom: 15px;
        }
        .popup-buttons {
            text-align: right;
        }
        .popup-buttons button {
            margin-left: 10px;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .popup-buttons button.ok-btn {
            background-color: #B9B28A;
            color: white;
        }
        .popup-buttons button.cancel-btn {
            background-color: #d9534f;
            color: white;
        }
    </style>
</head>
<body>
    <?php if ($pesan == 'gagal_fk'): ?>
        <div class="overlay" id="overlay"></div>
        <div class="popup" id="popup">
            <div class="popup-content">
                <p>Data tidak bisa dihapus karena masih terdapat di Detail Penjualan.</p>
            </div>
            <div class="popup-buttons">
                <button onclick="closePopup()" class="ok-btn">OK</button>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('overlay').style.display = 'block';
                document.getElementById('popup').style.display = 'block';
            });

            function closePopup() {
                document.getElementById('overlay').style.display = 'none';
                document.getElementById('popup').style.display = 'none';
                window.location.href = 'tampil_produk.php'; // Redirect untuk menghilangkan parameter pesan
            }
        </script>
    <?php elseif ($pesan == 'sukses'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Data berhasil dihapus.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php elseif ($pesan == 'gagal'): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Data gagal dihapus.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

<header class="header p-4">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="text-lg font-weight-bold" style="color: #F3F7EC;">GUDANG MIE NOODIN</div>
        <nav class="nav">
            <a class="nav-link" href="tampil_produk.php">PRODUK</a>
            <a class="nav-link" href="data_penjualan.php">PENJUALAN</a>
            <a class="nav-link" href="detail_penjualan.php">DETAIL PENJUALAN</a>
        </nav>
    </div>
</header>

<div class="data-container">
    <h1>Daftar Produk</h1>
    <div class="row mb-3">
        <div class="col-md-6">
            <form method="GET" action="tampil_produk.php" class="form-inline">
                <div class="input-group">
                    <input type="text" name="search" id="search" class="form-control" placeholder="Cari Nama Produk..." value="<?= htmlspecialchars($search) ?>">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-6 text-right">
            <a href="data_produk.php" class="btn btn-success">Tambah Data</a>
            <a href="index.php" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
    <table class="table table-bordered table-hover">
        <tr>
            <th>No</th>
            <th>Nama Produk</th>
            <th>Harga Produk/Pack</th>
            <th>Stok</th>
            <th>Tanggal Masuk</th>
            <th>AKSI</th>
        </tr>
        <tbody>
            <?php if ($found): ?>
                <?php $i = 1; foreach ($result as $produk): ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= htmlspecialchars($produk['NamaProduk']) ?></td>
                        <td><?= htmlspecialchars($produk['Harga']) ?></td>
                        <td><?= htmlspecialchars($produk['Stok']) ?></td>
                        <td><?= htmlspecialchars($produk['TanggalMasuk']) ?></td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="edit.php?id=<?= $produk["ProdukID"] ?>" class="btn btn-warning btn-sm mr-2">Edit</a>
                                <a href="delete.php?id=<?= $produk["ProdukID"] ?>" class="btn btn-danger btn-sm mr-2" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">Produk yang Anda cari tidak ada.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
