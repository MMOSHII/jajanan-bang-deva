<div class="sidebar">
  <div class="logo-container">
    <div class="logo">🍴</div>
    <div class="band-name">Jajanan Bang Deva</div>
  </div>

  <?php $current_page = basename($_SERVER['SCRIPT_NAME']); ?>

  <a href="home.php" class="menu-item <?= ($current_page == 'home.php') ? 'active' : ''; ?>">
    <span class="menu-icon">🏠</span>
    Beranda
  </a>

  <a href="Transaction.php" class="menu-item <?= ($current_page == 'Transaction.php') ? 'active' : ''; ?>">
    <span class="menu-icon">📋</span>
    Transaksi
  </a>

  <a href="Stock.php" class="menu-item <?= ($current_page == 'Stock.php') ? 'active' : ''; ?>">
    <span class="menu-icon">📦</span>
    Stok Produk
  </a>

  <a href="Stats.php" class="menu-item <?= ($current_page == 'Stats.php') ? 'active' : ''; ?>">
    <span class="menu-icon">📊</span>
    Pemasukan & Pengeluaran
  </a>

  <a href="Note.php" class="menu-item <?= ($current_page == 'note.php') ? 'active' : ''; ?>">
    <span class="menu-icon">📝</span>
    Catatan
  </a>
</div>