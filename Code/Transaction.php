<?php
require 'config.php';

$sql_transactions = "
    SELECT 
        histori_transaksi.id_histori,
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

if (!$result_transactions) {
  echo "Error pada query: " . $sql_transactions . "<br>";
  echo "MySQL Error: " . $conn->error;
}

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
              <label for="jumlah">Jumlah:</label>
              <input type="number" id="jumlah" name="jumlah" required />
              <label for="tanggal">Tanggal:</label>
              <input type="date" id="tanggal" name="tanggal" required />
              <button type="submit">Tambah Transaksi</button>
          </form>
      </div>
      
      <div class="edit-form" id="editForm" style="display: none;">
            <h2>Edit Transaksi</h2>
            <form id="formEdit">
                <input type="hidden" id="edit_id_transaksi" name="id_transaksi">
                
                <label for="edit_nama_pelanggan">Nama Pelanggan:</label>
                <input type="text" id="edit_nama_pelanggan" name="nama_pelanggan" required>

                <label for="edit_produk_dibeli">Produk:</label>
                <select id="edit_produk_dibeli" name="produk_dibeli" required>
                    <?php
                    $sql_produk = "SELECT id_produk, nama_produk FROM stok_produk";
                    $result_produk = $conn->query($sql_produk);
                    while ($row = $result_produk->fetch_assoc()) {
                        echo "<option value='" . $row['id_produk'] . "'>" . $row['nama_produk'] . "</option>";
                    }
                    ?>
                </select>

                <label for="edit_jumlah">Jumlah:</label>
                <input type="number" id="edit_jumlah" name="jumlah" required>

                <label for="edit_tanggal">Tanggal:</label>
                <input type="date" id="edit_tanggal" name="tanggal" required>

                <button type="submit">Simpan Perubahan</button>
            </form>
        </div>

        <script>
        document.addEventListener("DOMContentLoaded", () => {
        // Tombol Edit
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id_transaksi = this.getAttribute('data-id');
                const pelanggan = this.getAttribute('data-pelanggan');
                const produk = this.getAttribute('data-produk');
                const jumlah = this.getAttribute('data-jumlah');
                const tanggal = this.getAttribute('data-tanggal');
                
                // Masukkan data ke dalam form
                document.getElementById('edit_id_transaksi').value = id_transaksi;
                document.getElementById('edit_nama_pelanggan').value = pelanggan;
                document.getElementById('edit_produk_dibeli').value = produk;
                document.getElementById('edit_jumlah').value = jumlah;
                document.getElementById('edit_tanggal').value = tanggal;

                // Tampilkan form
                document.getElementById('editForm').style.display = 'block';
            });
        });

                // Form Submit pakai AJAX
                document.getElementById('formEdit').addEventListener('submit', function(e) {
                    e.preventDefault(); // Hindari reload halaman
                    
                    const formData = new FormData(this);

                    fetch('crudTransaction.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => confirm('Yakin ingin mengubah transaksi ini?'))
                    .then(data => {
                        alert('Transaksi Berhasil Diubah.'); // Tampilkan pesan sukses
                        location.reload(); // Reload halaman untuk update data
                    })
                    .catch(error => console.error('Error:', error));
                });
            });
        </script>

      <div class="card">
        <h2 class="card-title">Histori Transaksi</h2>
        <table class="transaction-table">
          <thead>
            <tr>
              <th>Pelanggan</th>
              <th>Produk Dibeli</th>
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
                        echo "<td>" . htmlspecialchars($row["jumlah"]) . " pcs</td>";
                        echo "<td>" . date("d M Y", strtotime($row["tanggal"])) . "</td>";
                        echo "<td>Rp " . number_format($row["keuntungan"], 0, ',', '.') . "</td>";
                        echo "<td>
                              <button 
                                  class='edit-btn' 
                                  data-id='" . $row['id_histori'] . "' 
                                  data-pelanggan='" . htmlspecialchars($row["nama_pelanggan"]) . "' 
                                  data-produk='" . $row['produk_dibeli'] . "' 
                                  data-jumlah='" . $row['jumlah'] . "' 
                                  data-tanggal='" . $row['tanggal'] . "'>
                                  Edit
                              </button>
                        </td>";
                        echo "<td>
                            <form action='crudTransaction.php' method='POST' style='display:inline-block;'>
                                <input type='hidden' name='id_histori' value='" . $row['id_histori'] . "' />
                                <button type='submit' name='action' value='delete' onclick=\"return confirm('Yakin ingin menghapus transaksi ini?');\">Hapus</button>
                            </form>
                        </td>";
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