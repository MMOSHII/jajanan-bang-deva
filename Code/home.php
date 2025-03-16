<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "db_sim_bgdeva";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_stock = "SELECT nama_produk, modal, harga, stok FROM stok_produk";
$result_stock = $conn->query($sql_stock);

// Query 2: Fetch Transaction History
$sql_transactions = "
    SELECT 
        histori_transaksi.nama_pelanggan, 
        stok_produk.nama_produk AS produk_dibeli, 
        histori_transaksi.jumlah, 
        histori_transaksi.tanggal 
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
    <link rel="stylesheet" href="style.css" />
    <title>Jajanan Bang Deva - Dashboard</title>
  </head>
  <body>
    <!-- Sidebar navigation -->
    <div class="sidebar">
      <div class="logo-container">
        <div class="logo">🍴</div>
        <div class="brand-name">Jajanan Bang Deva</div>
      </div>

      <a href="#" class="menu-item active">
        <span class="menu-icon">🏠</span>
        Beranda
      </a>

      <a href="#" class="menu-item">
        <span class="menu-icon">📋</span>
        Transaksi
      </a>

      <a href="#" class="menu-item">
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

    <!-- Main content area -->
    <div class="main-content">
      <h1 class="page-title">Financial Report</h1>
      <p class="page-subtitle">Laporan keuangan dan analisis usaha Jajanan Bang Deva</p>

      <div class="content-grid">
        <!-- Left column -->
        <div>
          <!-- Product stock section -->
          <div class="card" style="background: #F60B0B14; padding: 20px 0">
            <h2 class="card-title" style="padding: 0 20px; color: #ff3333">Stok Produk</h2>
            <table class="product-table" style="background: white">
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
                      echo "<td>" . htmlspecialchars($row["stok"]) . " pcs</td>";
                      echo "</tr>";
                    }
                  } else {
                    echo "<tr><td colspan='4'>Tidak ada produk ditemukan</td></tr>";
                  }
                ?>
              </tbody>
            </table>
          </div>

          <!-- Transaction history section -->
          <div class="card">
            <h2 class="card-title">Histori Transaksi</h2>
            <table class="transaction-table">
              <thead>
                <tr>
                  <th>Pelanggan</th>
                  <th>Produk dibeli</th>
                  <th>Jumlah</th>
                  <th>Tanggal</th>
                </tr>
              </thead>
              <tbody>
              <?php
                if ($result_transactions->num_rows > 0) {
                    while ($row = $result_transactions->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["nama_pelanggan"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["produk_dibeli"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["jumlah"]) . " pcs</td>";
                        echo "<td>" . date("d M Y", strtotime($row["tanggal"])) . "</td>";
                        // echo "<td>Rp " . number_format($row["keuntungan"], 0, ',', '.') . "</td>";
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

        <!-- Right column -->
        <div>
          <h1 class="page-title" style="display: flex; align-items: center; gap: 5px;">
            Goals 
            <button class="goal-button">+</button>
          </h1>
          
          <!-- Goals section -->
          <div class="goals-container">
            <div class="goal-card">
              <div class="goal-amount">Rp.1.000.000</div>
              <div class="goal-date">11/04/2025</div>
              <div class="goal-title">Renovasi</div>
            </div>

            <div class="goal-card">
              <div class="goal-amount">Rp.5.000.000</div>
              <div class="goal-date">11/05/2025</div>
              <div class="goal-title">Cabang Baru</div>
            </div>

            <div class="goal-card">
              <div class="goal-amount">Rp.500.000</div>
              <div class="goal-date">11/11/2025</div>
              <div class="goal-title">Gaji Distributor</div>
            </div>
          </div>

          <!-- Expense statistics section -->
          <div class="card">
            <h2 class="card-title">Statistik Pengeluaran</h2>
            <div class="expense-stats">
              <div class="expense-item">
                <div class="expense-label">
                  <span class="expense-name">Operasional Dapur</span>
                  <span class="expense-value">50%</span>
                </div>
                <div class="expense-bar">
                  <div class="expense-bar-fill expense-kitchen" style="width: 50%"></div>
                </div>
              </div>

              <div class="expense-item">
                <div class="expense-label">
                  <span class="expense-name">Transportasi</span>
                  <span class="expense-value">30%</span>
                </div>
                <div class="expense-bar">
                  <div class="expense-bar-fill expense-transport" style="width: 30%"></div>
                </div>
              </div>

              <div class="expense-item">
                <div class="expense-label">
                  <span class="expense-name">Lainnya</span>
                  <span class="expense-value">20%</span>
                </div>
                <div class="expense-bar">
                  <div class="expense-bar-fill expense-other" style="width: 20%"></div>
                </div>
              </div>
            </div>

            <button class="action-button">Pemasukan dan Pengeluaran</button>
            <a href="#" class="action-link">Lihat detail statistik disini.</a>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
