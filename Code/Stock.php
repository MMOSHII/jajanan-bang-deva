<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "db_sim_bgdeva";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_stock = "SELECT * FROM stok_produk";
$result_stock = $conn->query($sql_stock);
?>

<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="Stock.css" />
    <title>Stok Produk - Jajanan Bang Deva</title>
  </head>
  <body>
    <div class="sidebar">
      <div class="logo-container">
        <div class="logo">🍴</div>
        <div class="brand-name">Jajanan Bang Deva</div>
      </div>

      <a href="Home.php" class="menu-item">
        <span class="menu-icon">🏠</span>
        Beranda
      </a>

      <a href="Transaction.php" class="menu-item">
        <span class="menu-icon">📋</span>
        Transaksi
      </a>

      <a href="Stock.php" class="menu-item active">
        <span class="menu-icon">📦</span>
        Stok Produk
      </a>

      <a href="Stats.html" class="menu-item">
        <span class="menu-icon">📊</span>
        Pemasukan & Pengeluaran
      </a>

      <a href="#" class="menu-item">
        <span class="menu-icon">📝</span>
        Catatan
      </a>
    </div>

    <div class="main-content">
      <h1 class="page-title">Stok Produk</h1>
      <p class="page-subtitle">Stok Produk usaha Jajanan Bang Deva</p>

      <div class="card">
        <h2 class="card-title">Stok Produk</h2>
        <table class="product-table">
          <thead>
            <tr>
              <th>Nama Produk</th>
              <th>Modal</th>
              <th>Harga</th>
              <th>Stok</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if ($result_stock->num_rows > 0) {
                    while ($row = $result_stock->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["nama_produk"]) . "</td>";
                        echo "<td>Rp " . number_format($row["modal"], 0, ',', '.') . "</td>";
                        echo "<td>Rp " . number_format($row["harga"], 0, ',', '.') . "</td>";
                        echo "<td>" . htmlspecialchars($row["stok"]) . " Pcs </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Tidak ada stok ditemukan</td></tr>";
                }
              ?>
          </tbody>
        </table>
      </div>
    </div>
  </body>
</html>
