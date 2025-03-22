<?php
require 'config.php';

// Jika ada update stok
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_stok"])) {
  $id_produk = $_POST["id_produk"];
  $stok = $_POST["stok"];

  $sql_update = "UPDATE stok_produk SET stok = ? WHERE id_produk = ?";
  $stmt = $conn->prepare($sql_update);
  $stmt->bind_param("ii", $stok, $id_produk);

  if ($stmt->execute()) {
      echo "success";
  } else {
      echo "error";
  }

  $stmt->close();
  exit;
}

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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Stok Produk - Jajanan Bang Deva</title>
  </head>
  <body>
    
  <?php include 'sidebar.php'; ?>
    <div class="main-content">
      <h1 class="page-title">Stok Produk</h1>
      <p class="page-subtitle">Stok Produk usaha Jajanan Bang Deva</p>
      <!-- Form Edit Stok -->
      <div class="edit-form">
          <h2>Edit Stok</h2>
          <form id="editStokForm">
              <input type="hidden" id="edit_id" name="id_produk">
              
              <label>Nama Produk:</label>
              <input type="text" id="edit_nama" name="nama_produk" readonly>

              <label>Stok:</label>
              <input type="number" id="edit_stok" name="stok" required>

              <button type="submit">Simpan Perubahan</button>
          </form>
      </div>
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
                                  data-nama='" . htmlspecialchars($row["nama_produk"]) . "' 
                                  data-stok='" . $row['stok'] . "'>
                                  Edit
                              </button>
                        </td>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Tidak ada stok ditemukan</td></tr>";
                }
              ?>
          </tbody>
        </table>
      </div>
      <script>
      $(document).ready(function() {
          $(".edit-btn").click(function() {
              $("#edit_id").val($(this).data("id"));
              $("#edit_nama").val($(this).data("nama"));
              $("#edit_stok").val($(this).data("stok"));
              $(".edit-form").show();
          });

          $("#editStokForm").submit(function(e) {
              e.preventDefault();
              $.ajax({
                  url: "", 
                  type: "POST",
                  data: $(this).serialize() + "&update_stok=1",
                  success: function(response) {
                      if (response === "success") {
                          alert("Stok berhasil diperbarui!");
                          location.reload();
                      } else {
                          alert("Gagal memperbarui stok.");
                      }
                  }
              });
          });
      });
      </script>
    </div>
  </body>
</html>
