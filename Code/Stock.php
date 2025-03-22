<?php
require 'config.php';

$sql_stock = "SELECT * FROM stok_produk";
$result_stock = $conn->query($sql_stock);

$conn->close();
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
    
  <?php include 'sidebar.php'; ?>

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
                        echo "<td>
                              <button 
                                  class='edit-btn' 
                                  data-id='" . $row['id_produk'] . "' 
                                  data-produk='" . htmlspecialchars($row["nama_produk"]) . "' 
                                  data-modal='" . $row['modal'] . "' 
                                  data-harga='" . $row['harga'] . "' 
                                  data-stok='" . $row['stok'] . "'>
                                  Edit
                              </button>
                        </td>";
                        echo "<td>
                            <form action='' method='POST' style='display:inline-block;'>
                                <input type='hidden' name='id_produk' value='" . $row['id_produk'] . "' />
                                <button type='submit' name='action' value='delete' onclick=\"return confirm('Yakin ingin menghapus stok ini?');\">Hapus</button>
                            </form>
                        </td>";
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
