<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_histori = $_POST['id_produk'] ?? null;
    $action = $_POST['action'] ?? null;

    if ($action === 'delete' && $id_produk) {
        // HAPUS TRANSAKSI
        $sql = "DELETE FROM stok_produk WHERE id_produk = '$id_produk'";
        if ($conn->query($sql) === TRUE) {
            header("Location: Stock.php");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }

    if ($action === 'edit' && $id_produk) {
        // TAMPILKAN FORM EDIT
        $sql = "SELECT * FROM stok_produk WHERE id_produk = '$id_produk'";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $data = $result->fetch_assoc();

            // Form Edit
            echo "<form action='crudStock.php' method='POST'>";
            echo "<input type='hidden' name='id_produk' value='" . $data['id_produk'] . "' />";
            echo "<label for='nama_pelanggan'>Nama Pelanggan:</label>";
            echo "<input type='text' name='nama_pelanggan' value='" . $data['nama_pelanggan'] . "' required />";
            echo "<label for='produk_dibeli'>Produk:</label>";
            
            // Pilihan produk
            $sql_produk = "SELECT id_produk, nama_produk FROM stok_produk";
            $result_produk = $conn->query($sql_produk);
            echo "<select name='produk_dibeli'>";
            while ($row = $result_produk->fetch_assoc()) {
                $selected = ($row['id_produk'] == $data['produk_dibeli']) ? 'selected' : '';
                echo "<option value='" . $row['id_produk'] . "' $selected>" . $row['nama_produk'] . "</option>";
            }
            echo "</select>";

            echo "<label for='jumlah'>Jumlah:</label>";
            echo "<input type='number' name='jumlah' value='" . $data['jumlah'] . "' required />";
            echo "<label for='tanggal'>Tanggal:</label>";
            echo "<input type='date' name='tanggal' value='" . $data['tanggal'] . "' required />";
            echo "<button type='submit' name='action' value='update'>Update</button>";
            echo "</form>";
        }
    }

    if ($action === 'update' && $id_histori) {
        // UPDATE TRANSAKSI
        $nama_pelanggan = $_POST["nama_pelanggan"];
        $produk_dibeli = $_POST["produk_dibeli"];
        $jumlah = $_POST["jumlah"];
        $tanggal = $_POST["tanggal"];

        $sql = "UPDATE histori_transaksi 
                SET nama_pelanggan = '$nama_pelanggan', 
                    produk_dibeli = '$produk_dibeli', 
                    jumlah = '$jumlah', 
                    tanggal = '$tanggal' 
                WHERE id_histori = '$id_histori'";

        if ($conn->query($sql) === TRUE) {
            header("Location: Transaction.php");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssisi", $nama_pelanggan, $produk_dibeli, $jumlah, $tanggal, $id_transaksi);
    
        if ($stmt->execute()) {
            echo "Data transaksi berhasil diupdate!";
        } else {
            echo "Error: " . $conn->error;
        }
    
        $stmt->close();
        $conn->close();
    }
}

$conn->close();
