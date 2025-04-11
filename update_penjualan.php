<?php
include "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ProdukID = $_POST['ProdukID'];
    $Harga = $_POST['Harga'];
    $Stok = $_POST['Stok'];
    $TanggalPenjualan = $_POST['TanggalPenjualan'];
    $TokoID = $_POST['TokoID'];
    $Subtotal = $_POST['Subtotal']; // Pastikan ini juga dikirim dari form

    // Ambil Nama Produk berdasarkan ProdukID
    $sql_get_produk = "SELECT NamaProduk FROM produk WHERE ProdukID = $ProdukID";
    $result_get_produk = $koneksi->query($sql_get_produk);
    if ($result_get_produk && $result_get_produk->num_rows > 0) {
        $row_produk = $result_get_produk->fetch_assoc();
        $NamaProduk = $row_produk['NamaProduk'];
    } else {
        $NamaProduk = ''; // Atau handle jika produk tidak ditemukan
    }

    // Ambil Nama Toko berdasarkan TokoID
    $sql_get_toko = "SELECT NamaToko FROM toko WHERE TokoID = $TokoID";
    $result_get_toko = $koneksi->query($sql_get_toko);
    if ($result_get_toko && $result_get_toko->num_rows > 0) {
        $row_toko = $result_get_toko->fetch_assoc();
        $NamaToko = $row_toko['NamaToko'];
    } else {
        $NamaToko = ''; // Atau handle jika toko tidak ditemukan
    }

    // Validasi sederhana
    if (empty($TanggalPenjualan) || empty($TokoID) || $Stok <= 0) {
        echo "<script>alert('Data tidak lengkap atau stok tidak valid.'); window.location.href='data_penjualan.php';</script>";
        exit();
    }

    // Modifikasi query INSERT untuk menyertakan NamaProduk dan NamaToko
    $sql_insert_penjualan = "INSERT INTO penjualan (ProdukID, NamaProduk, Harga, Stok, Subtotal, TanggalPenjualan, TokoID, NamaToko)
                             VALUES ('$ProdukID', '$NamaProduk', '$Harga', '$Stok', '$Subtotal', '$TanggalPenjualan', '$TokoID', '$NamaToko')";

    if ($koneksi->query($sql_insert_penjualan) === TRUE) {
        echo "<script>alert('Data penjualan berhasil ditambahkan.'); window.location.href='detail_penjualan.php';</script>";
    } else {
        echo "Error: " . $sql_insert_penjualan . "<br>" . $koneksi->error;
    }

    $koneksi->close();
} else {
    header("Location: data_penjualan.php"); // Jika diakses tidak melalui POST
    exit();
}
?>