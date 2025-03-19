<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_pelanggan = $_POST["nama_pelanggan"];
    $produk_dibeli = $_POST["produk_dibeli"];
    $jumlah = $_POST["jumlah"];
    $tanggal = $_POST["tanggal"];

    // Simpan ke database
    $sql = "INSERT INTO histori_transaksi (nama_pelanggan, produk_dibeli, jumlah, tanggal) 
            VALUES ('$nama_pelanggan', '$produk_dibeli', '$jumlah', '$tanggal')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>window.location.href='Transaction.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
