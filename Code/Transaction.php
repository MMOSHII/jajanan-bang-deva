<?php
require 'config.php';

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

  <?php include 'sidebar.php'; ?>

    <div class="main-content">
      <h1 class="page-title">Transaksi</h1>
      <p class="page-subtitle">Detail transaksi tentang usaha Jajanan Bang Deva</p>

      <div class="transaction-form">
          <h2 class="form-title">Tambah Histori Transaksi</h2>
          <form action="" method="POST">
              <label for="nama_pelanggan">Nama Pelanggan:</label>
              <input type="text" id="nama_pelanggan" name="nama_pelanggan" required />
              <label for="produk_dibeli">Produk:</label>
              <select id="produk_dibeli" name="produk_dibeli" required>
                  <?php
                  $sql_produk = "SELECT id_produk, nama_produk FROM stok_produk";
                  $result_produk = $conn->query($sql_produk);
                  while ($row = $result_produk->fetch_assoc()) {
                      echo "<option value='" . $row['id_produk'] . "'>" . $row['nama_produk'] . "</option>";
                  }
                  ?>
              </select>
              <label for="harga">Harga:</label>
              <input type="text" id="harga" name="harga" required />
              <label for="jumlah">Jumlah:</label>
              <input type="number" id="jumlah" name="jumlah" required />
              <label for="tanggal">Tanggal:</label>
              <input type="date" id="tanggal" name="tanggal" required />
              <button type="submit">Tambah Transaksi</button>
          </form>
      </div>

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
