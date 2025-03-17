<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "db_sim_bgdeva";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_transactions = "
    SELECT 
        histori_transaksi.nama_pelanggan, 
        stok_produk.nama_produk AS produk_dibeli, 
        stok_produk.harga AS harga, 
        histori_transaksi.jumlah, 
        histori_transaksi.tanggal,
        stok_produk.harga * histori_transaksi.jumlah as keuntungan
    FROM histori_transaksi 
    INNER JOIN stok_produk 
    ON histori_transaksi.produk_dibeli = stok_produk.id_produk 
    ORDER BY histori_transaksi.tanggal DESC";
$result_transactions = $conn->query($sql_transactions);
?>

<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Jajanan Bang Deva - Transaksi</title>
    <link rel="stylesheet" href="Transaction.css" />
  </head>
  <body>
    <!-- Sidebar navigation -->
    <div class="sidebar">
      <div class="logo-container">
        <div class="logo">🍴</div>
        <div class="brand-name">Jajanan Bang Deva</div>
      </div>

      <a href="home.php" class="menu-item">
        <span class="menu-icon">🏠</span>
        Beranda
      </a>

      <a href="Transaction.php" class="menu-item active">
        <span class="menu-icon">📋</span>
        Transaksi
      </a>

      <a href="Stock.php" class="menu-item">
        <span class="menu-icon">📦</span>
        Stok Produk
      </a>

      <a href="#" class="menu-item">
        <span class="menu-icon">📊</span>
        Pemasukan & Pengeluaran
      </a>

      <a href="#" class="menu-item">
        <span class="menu-icon">📝</span>
        Catatan
      </a>
    </div>
    <div class="main-content">
      <h1 class="page-title">Transaksi</h1>
      <p class="page-subtitle">Detail transaksi tentang usaha Jajanan Bang Deva</p>
      <div class="card">
        <h2 class="card-title">Histori Transaksi</h2>
        <table class="transaction-table">
          <thead>
            <tr>
              <th>Pelanggan</th>
              <th>Produk Dibeli</th>
              <th>Harga</th>
              <th>Jumlah</th>
              <th>Tanggal</th>
              <th>Keuntungan</th>
            </tr>
          </thead>
          <tbody>
          <?php
                if ($result_transactions->num_rows > 0) {
                    while ($row = $result_transactions->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["nama_pelanggan"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["produk_dibeli"]) . "</td>";
                        echo "<td>Rp " . number_format($row["harga"], 0, ',', '.') . "</td>";
                        echo "<td>" . htmlspecialchars($row["jumlah"]) . " pcs</td>";
                        echo "<td>" . date("d M Y", strtotime($row["tanggal"])) . "</td>";
                        echo "<td>Rp " . number_format($row["keuntungan"], 0, ',', '.') . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Tidak ada transaksi ditemukan</td></tr>";
                }
              ?>
          </tbody>
        </table>
      </div>
    </div>
  </body>
</html>
