<?php
// Mengimpor file koneksi.php yang berisi kode untuk koneksi ke database.
session_start();
include("koneksi.php");

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Produk</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #80B9AD; /* Warna latar belakang */
            color: #504B38; /* Warna teks body */
            margin: 0; /* Menghilangkan margin default */
            padding: 0; /* Menghilangkan padding default */
        }

        .header {
            background-color: #538392; /* Warna latar belakang header */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Menambahkan bayangan pada header */
            position: sticky; /* Membuat header tetap di atas saat scroll */
            top: 0; /* Posisi atas */
            z-index: 1000; /* Menjaga header di atas elemen lain */
        }

        .main-title {
            font-size: 2.5rem; /* Ukuran font judul utama */
            font-weight: bold; /* Tebal font judul utama */
            color: #504B38; /* Mengubah warna teks judul utama */
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2); /* Menambahkan bayangan pada teks judul */
            animation: fadeIn 1s ease-in; /* Menambahkan animasi */
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .divider {
            height: 2px; /* Tinggi garis pemisah */
            background-color: #504B38; /* Mengubah warna garis pemisah */
            margin: 1rem 0; /* Margin atas dan bawah garis pemisah */
        }

        .nav-link {
            color: #504B38; /* Mengubah warna teks tautan navigasi */
            transition: color 0.3s, transform 0.3s; /* Menambahkan efek transisi pada warna dan transformasi */
        }

        .nav-link:hover {
            color: #B3E2A7; /* Mengubah warna saat hover */
            transform: scale(1.1); /* Membesarkan tautan saat hover */
        }

        .container {
            background-color: #D8EFD3; /* Latar belakang kontainer */
            padding: 30px; /* Menambahkan padding pada kontainer */
            border-radius: 15px; /* Menambahkan sudut melengkung pada kontainer */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); /* Menambahkan bayangan pada kontainer */
            animation: slideIn 0.5s ease-in-out; /* Menambahkan animasi slide in */
        }

        @keyframes slideIn {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .img-fluid {
            border-radius: 15px; /* Menambahkan sudut melengkung pada gambar */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Menambahkan bayangan pada gambar */
            max-width: 100%; /* Membuat gambar responsif */
            height: auto; /* Menjaga aspek rasio gambar */
        }

        .welcome-row {
            display: flex; /* Menggunakan flexbox untuk mengatur tata letak */
            align-items: center; /* Membuat item berada di tengah vertikal */
        }

        .welcome-text {
            flex: 1; /* Mengambil sebagian besar ruang yang tersedia */
            margin-right: 20px; /* Memberikan jarak antara teks dan gambar */
        }

        .welcome-image {
        flex-shrink: 0; /* Mencegah gambar menyusut terlalu kecil */
        max-width: 450px; /* Lebar maksimum gambar */
        margin-left: auto; /* Mendorong gambar ke kanan */
    
        }
    </style>
</head>
<body>
    <header class="header p-4">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="text-lg font-weight-bold">GUDANG MIE NOODIN</div>
            <nav class="nav">
                <a class="nav-link" href="tampil_produk.php">PRODUK</a>
                <a class="nav-link" href="data_penjualan.php">PENJUALAN</a>
                <a class="nav-link" href="detail_penjualan.php">DETAIL PENJUALAN</a>
                <a class="nav-link" href="logout.php">LOGOUT</a>
            </nav>
        </div>
    </header>
    <main class="container my-5">
        <div class="row welcome-row">
            <div class="col-lg-6 welcome-text">
                <h1 class="main-title">Selamat Datang</h1>
                <div class="divider"></div>
                <p>Halo, selamat datang di website gudang mie^^</p>
            </div>
            <div class="col-lg-6 welcome-image">
                <img src="miee.jpeg" alt="" class="img-fluid">
            </div>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>