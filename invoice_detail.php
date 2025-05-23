<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Items</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="title" content="Items" />
  <meta name="author" content="ColorlibHQ" />
  <meta name="description" content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS." />
  <meta name="keywords" content="bootstrap 5, dashboard, adminlte, vanilla js" />
  
  <!-- Fonts -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" crossorigin="anonymous" />
  
  <!-- Third Party CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css" crossorigin="anonymous" />

  <!-- AdminLTE CSS -->
  <link rel="stylesheet" href="adminlte.css" />
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
  <div class="app-wrapper">

    <!-- Navbar -->
    <nav class="app-header navbar navbar-expand bg-body">
      <div class="container-fluid">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
              <i class="bi bi-list"></i>
            </a>
          </li>
          <li class="nav-item d-none d-md-block"><a href="index.html" class="nav-link">Home</a></li>
          <li class="nav-item"><a href="items.php" class="nav-link">Items</a></li>
          <li class="nav-item"><a href="customers.php" class="nav-link">Customers</a></li>
          <li class="nav-item"><a href="suppliers.php" class="nav-link">Suppliers</a></li>            
        </ul>
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="#" data-lte-toggle="fullscreen">
              <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
              <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
            </a>
          </li>
        </ul>
      </div>
    </nav>

    <!-- Sidebar -->
    <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
      <div class="sidebar-brand">
        <a href="index.html" class="brand-link">
          <span class="brand-text fw-light">Wevelope</span>
        </a>
      </div>
      <div class="sidebar-wrapper">
        <nav class="mt-2">
          <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
            <li class="nav-item menu-open">
              <ul class="nav nav-treeview">
                <li class="nav-item"><a href="index.html" class="nav-link active"><i class="nav-icon bi bi-circle"></i><p>Home</p></a></li>
                <li class="nav-item"><a href="items.php" class="nav-link active"><i class="nav-icon bi bi-circle"></i><p>Items</p></a></li>
                <li class="nav-item"><a href="customers.php" class="nav-link active"><i class="nav-icon bi bi-circle"></i><p>Customers</p></a></li>
                <li class="nav-item"><a href="suppliers.php" class="nav-link active"><i class="nav-icon bi bi-circle"></i><p>Suppliers</p></a></li>
                <li class="nav-item"><a href="item_customer.php" class="nav-link active"><i class="nav-icon bi bi-circle"></i><p>Item Customer</p></a></li>
                <li class="nav-item"><a href="invoice.php" class="nav-link active"><i class="nav-icon bi bi-circle"></i><p>Invoice</p></a></li>
              </ul>
            </li>
          </ul>
        </nav>
      </div>
    </aside>

    <!-- Main -->
    <main class="app-main">
      <div class="app-content-header">
        <div class="container-fluid">
          <div class="row mb-3">
            <div class="col-sm-6"><h3 class="mb-0">Dashboard</h3></div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item"><a href="invoice.php">Invoice</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detail</li>
              </ol>
            </div>
          </div>

          <!-- Invoice Detail -->
          <div class="row">
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header border-0">
                  <h3 class="card-title">Detail Invoice</h3>
                </div>
                <div class="card-body table-responsive p-0">

                <style>
<?php
include __DIR__.'/db.php';

// Validasi ID invoice
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
}
$invoice_id = intval($_GET['id']);

// Ambil data invoice
$result = $conn->query("SELECT * FROM invoice WHERE id = $invoice_id");
if (!$result || $result->num_rows == 0) {
    echo "<div class='alert alert-danger'>Invoice tidak ditemukan.</div>";
    exit();
}
$invoice = $result->fetch_assoc();

// Tambah item
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tambah_item'])) {
    $item_id = intval($_POST['item_id']);
    $input_harga = isset($_POST['harga']) && $_POST['harga'] !== '' ? floatval($_POST['harga']) : null;
    $jumlah = intval($_POST['jumlah']);

    if ($item_id > 0 && $jumlah > 0) {
        if (is_null($input_harga)) {
            $stmt = $conn->prepare("
                SELECT ic.harga 
                FROM item_customer ic
                JOIN invoice i ON ic.customer_id = i.customer_id
                WHERE ic.item_id = ? AND i.id = ?
                LIMIT 1
            ");
            $stmt->bind_param('ii', $item_id, $invoice_id);
            $stmt->execute();
            $res = $stmt->get_result();
            if ($row = $res->fetch_assoc()) {
                $harga = (float) $row['harga'];
            } else {
                $stmt2 = $conn->prepare("SELECT price FROM items WHERE id = ? LIMIT 1");
                $stmt2->bind_param('i', $item_id);
                $stmt2->execute();
                $res2 = $stmt2->get_result();
                $harga = ($row2 = $res2->fetch_assoc()) ? (float) $row2['price'] : 0;
                $stmt2->close();
            }
            $stmt->close();
        } else {
            $harga = $input_harga;
        }

        $total_harga = $harga * $jumlah;
        $stmt = $conn->prepare("INSERT INTO invoice_items (invoice_id, item_id, harga, jumlah, total_harga) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param('iidii', $invoice_id, $item_id, $harga, $jumlah, $total_harga);
        $stmt->execute();
        $stmt->close();
    }
}

// Hapus item
if (isset($_GET['delete_item'])) {
    $delete_id = (int)$_GET['delete_item'];
    $stmt = $conn->prepare("DELETE FROM invoice_items WHERE id = ?");
    $stmt->bind_param('i', $delete_id);
    $stmt->execute();
    $stmt->close();
}

// Update item
if (isset($_POST['update_item'])) {
    $id_item_invoice = (int)$_POST['id_item_invoice'];
    $item_id = (int)$_POST['item_id'];
    $harga = (float)$_POST['harga'];
    $jumlah = (int)$_POST['jumlah'];

    $total_harga = $harga * $jumlah;
    $stmt = $conn->prepare("UPDATE invoice_items SET item_id=?, harga=?, jumlah=?, total_harga=? WHERE id=?");
    $stmt->bind_param('idiii', $item_id, $harga, $jumlah, $total_harga, $id_item_invoice);
    $stmt->execute();
    $stmt->close();

}

// Edit mode
$edit_item = null;
if (isset($_GET['edit_item'])) {
    $edit_id = (int)$_GET['edit_item'];
    $edit_item = $conn->query("SELECT * FROM invoice_items WHERE id = $edit_id")->fetch_assoc();
}

// Ambil item invoice
$item_invoice = $conn->query("
    SELECT ii.*, i.name AS nama_item
    FROM invoice_items ii
    JOIN items i ON ii.item_id = i.id
    WHERE ii.invoice_id = $invoice_id
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Detail Invoice</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <style>
    @media print {
      body * {
        visibility: hidden;
      }
      .print-area, .print-area * {
        visibility: visible;
      }
      .print-area {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        padding: 20px;
      }
      .btn, form, nav, footer {
        display: none !important;
      }
    }
  </style>
</head>
<body class="bg-light">

<!-- SEARCH BAR -->
<div class="container mt-4">
  <form method="GET" class="mb-4">
    <input type="hidden" name="id" value="<?= $invoice_id ?>">
    <div class="input-group">
      <input type="text" name="search" class="form-control" placeholder="Cari item..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
      <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i> Cari</button>
      <a href="invoice_detail.php?id=<?= $invoice_id ?>" class="btn btn-secondary">Reset</a>
    </div>
  </form>
</div>

<div class="container">

  <?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <?= $_GET['success'] === 'add' ? 'Item berhasil ditambahkan!' : ($_GET['success'] === 'edit' ? 'Item berhasil diperbarui!' : 'Item berhasil dihapus!') ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  <?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <?= $_GET['error'] === 'duplicate' ? 'Nama item sudah ada.' : 'Terjadi kesalahan.' ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  <h2 class="mb-4">Detail Invoice</h2>

  <form method="post" class="row g-3 align-items-center">
    <input type="hidden" name="id_item_invoice" value="<?= $edit_item['id'] ?? '' ?>">
    <div class="col-md-4">
      <label class="form-label">Item</label>
      <select name="item_id" class="form-select" required>
        <option value="">-- Pilih Item --</option>
        <?php
        $items = $conn->query("SELECT * FROM items");
        while ($i = $items->fetch_assoc()) :
        ?>
          <option value="<?= $i['id'] ?>" <?= isset($edit_item) && $edit_item['item_id'] == $i['id'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($i['name']) ?>
          </option>
        <?php endwhile; ?>
      </select>
    </div>
    <div class="col-md-2">
      <label class="form-label">Harga</label>
      <input type="number" name="harga" class="form-control" placeholder="Opsional" value="<?= $edit_item['harga'] ?? '' ?>">
    </div>
    <div class="col-md-2">
      <label class="form-label">Jumlah</label>
      <input type="number" name="jumlah" class="form-control" required value="<?= $edit_item['jumlah'] ?? '' ?>">
    </div>
    <div class="col-md-4 d-flex align-items-end">
      <button type="submit" name="<?= isset($edit_item) ? 'update_item' : 'tambah_item' ?>" class="btn btn-primary me-2">
        <?= isset($edit_item) ? 'Update' : 'Tambah' ?>
      </button>
      <?php if (isset($edit_item)) : ?>
        <a href="invoice_detail.php?id=<?= $invoice_id ?>" class="btn btn-secondary">Batal</a>
      <?php endif; ?>
    </div>
  </form>

  <hr>

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Nama Item</th>
        <th>Harga</th>
        <th>Jumlah</th>
        <th>Total</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if ($item_invoice->num_rows > 0):
        while ($row = $item_invoice->fetch_assoc()):
          if (isset($_GET['search']) && stripos($row['nama_item'], $_GET['search']) === false) continue;
      ?>
        <tr>
          <td><?= htmlspecialchars($row['nama_item']) ?></td>
          <td><?= number_format($row['harga']) ?></td>
          <td><?= $row['jumlah'] ?></td>
          <td>Rp. <?= number_format($row['harga'], 0, ',', '.') ?></td>
          <td>
            <a href="invoice_detail.php?id=<?= $invoice_id ?>&edit_item=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
            <a href="invoice_detail.php?id=<?= $invoice_id ?>&delete_item=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin mau hapus item ini?')">Hapus</a>
          </td>
        </tr>
      <?php
        endwhile;
      else:
        echo '<tr><td colspan="5" class="text-center">Belum ada item.</td></tr>';
      endif;
      ?>
    </tbody>
  </table>

  <a href="invoice.php" class="btn btn-secondary mt-3">Kembali ke Invoice</a>
  <a href="invoice_print.php?id=<?= $invoice_id ?>" class="btn btn-primary mt-3">Print Invoice</a>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>

    <!-- Footer -->
    <footer class="app-footer">
      <div class="float-end d-none d-sm-inline">This is the homepage</div>
      <strong>&copy; 2014-2024 <a href="https://adminlte.io" class="text-decoration-none">AdminLTE.io</a>.</strong> All rights reserved.
    </footer>

  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
  <script src="adminlte.js"></script>

  <script>
    OverlayScrollbars(document.querySelectorAll('.sidebar-wrapper'), { scrollbars: { autoHide: 'leave' } });
  </script>

</body>
</html>
