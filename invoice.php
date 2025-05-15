<?php
include 'db.php';

// Handle tambah/edit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'] ?? '';
    $invoice_name = $_POST['invoice_name'];
    $customer_id = $_POST['customer_id'];
    $tanggal = $_POST['tanggal'];

    // Cek duplikat invoice_name saat insert
    $stmt = $conn->prepare("SELECT id FROM invoice WHERE invoice_name = ?");
    $stmt->bind_param("s", $invoice_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0 && !$id) {
        // Jika duplikat dan ini insert (bukan update), redirect ke invoice.php dengan error
        header("Location: invoice.php?error=duplicate");
        exit;
    }
    $stmt->close();

    if ($id) {
        $stmt = $conn->prepare("UPDATE invoice SET invoice_name = ?, customer_id = ?, tanggal = ? WHERE id = ?");
        $stmt->bind_param("sisi", $invoice_name, $customer_id, $tanggal, $id);
        $stmt->execute();
        $stmt->close();
        header("Location: invoice.php?success=edit");
    } else {
        $stmt = $conn->prepare("INSERT INTO invoice (invoice_name, customer_id, tanggal) VALUES (?, ?, ?)");
        $stmt->bind_param("sis", $invoice_name, $customer_id, $tanggal);
        $stmt->execute();
        $stmt->close();
        header("Location: invoice.php?success=add");
    }
    exit;
}

// Aktifkan error reporting saat pengembangan
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Handle delete
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);

    // Hapus detail invoice terlebih dahulu
    $stmt = $conn->prepare("DELETE FROM invoice_detail WHERE invoice_id = ?");
    if (!$stmt) {
        die("Prepare gagal (invoice_detail): " . $conn->error);
    }
    $stmt->bind_param("i", $delete_id);
    if (!$stmt->execute()) {
        die("Eksekusi gagal (invoice_detail): " . $stmt->error);
    }
    $stmt->close();

    // Hapus invoice
    $stmt = $conn->prepare("DELETE FROM invoice WHERE id = ?");
    if (!$stmt) {
        die("Prepare gagal (invoice): " . $conn->error);
    }
    $stmt->bind_param("i", $delete_id);
    if (!$stmt->execute()) {
        die("Eksekusi gagal (invoice): " . $stmt->error);
    }
    $stmt->close();

    // Redirect setelah sukses
    header("Location: invoice.php?success=delete");
    exit;
}

$search = $_GET['search'] ?? '';

// Ambil semua parameter pencarian
$search = $_GET['search'] ?? '';
$customer_id = $_GET['customer_id'] ?? '';
$date_from = $_GET['date_from'] ?? '';
$date_to = $_GET['date_to'] ?? '';

// Buat query dasar
$query = "SELECT invoice.*, customers.name AS customer_name 
          FROM invoice 
          JOIN customers ON invoice.customer_id = customers.id 
          WHERE 1=1";

$params = [];
$types = '';

// Tambahkan kondisi jika ada input
if (!empty($search)) {
    $query .= " AND (invoice.invoice_name LIKE ? OR customers.name LIKE ?)";
    $params[] = '%' . $search . '%';
    $params[] = '%' . $search . '%';
    $types .= 'ss';
}

if (!empty($customer_id)) {
    $query .= " AND invoice.customer_id = ?";
    $params[] = $customer_id;
    $types .= 'i';
}

if (!empty($date_from)) {
    $query .= " AND invoice.tanggal >= ?";
    $params[] = $date_from;
    $types .= 's';
}

if (!empty($date_to)) {
    $query .= " AND invoice.tanggal <= ?";
    $params[] = $date_to;
    $types .= 's';
}

$query .= " ORDER BY invoice.id DESC";

$stmt = $conn->prepare($query);

// Binding jika ada parameter
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$invoices = $stmt->get_result();


// Ambil data customer untuk form
$customers = mysqli_query($conn, "SELECT * FROM customers");

// Cek kalau ada edit
$edit = null;
if (isset($_GET['edit'])) {
    $edit_id = intval($_GET['edit']);
    $stmt = $conn->prepare("SELECT * FROM invoice WHERE id = ?");
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $edit = $result->fetch_assoc();
    $stmt->close();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Invoice</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="adminlte.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">

<div class="app-wrapper">
    <!-- Header -->
    <nav class="app-header navbar navbar-expand bg-body">
        <div class="container-fluid">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                        <i class="bi bi-list"></i>
                    </a>
                </li>
                <li class="nav-item d-none d-md-block"><a href="index.php" class="nav-link">Home</a></li>
                <li class="nav-item"><a href="items.php" class="nav-link">Items</a></li>
                <li class="nav-item"><a href="customers.php" class="nav-link">Customers</a></li>
                <li class="nav-item"><a href="suppliers.php" class="nav-link">Suppliers</a></li>
                <li class="nav-item"><a href="item_customer.php" class="nav-link">Item Customer</a></li>
                <li class="nav-item"><a href="invoice.php" class="nav-link active">Invoice</a></li>
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
      <a href="index.php" class="brand-link"><span class="brand-text fw-light">Wevelope</span></a>
    </div>
    <div class="sidebar-wrapper">
      <nav class="mt-2">
        <ul class="nav sidebar-menu flex-column">
          <li class="nav-item"><a href="index.php" class="nav-link"><i class="nav-icon bi bi-circle"></i><p>Home</p></a></li>
          <li class="nav-item"><a href="items.php" class="nav-link"><i class="nav-icon bi bi-circle"></i><p>Items</p></a></li>
          <li class="nav-item"><a href="customers.php" class="nav-link"><i class="nav-icon bi bi-circle"></i><p>Customers</p></a></li>
          <li class="nav-item"><a href="suppliers.php" class="nav-link"><i class="nav-icon bi bi-circle"></i><p>Suppliers</p></a></li>
          <li class="nav-item"><a href="item_customer.php" class="nav-link"><i class="nav-icon bi bi-circle"></i><p>Item Customer</p></a></li>
          <li class="nav-item"><a href="invoice.php" class="nav-link"><i class="nav-icon bi bi-circle"></i><p>Invoice</p></a></li>
        </ul>
      </nav>
    </div>
  </aside>

    <!-- Main Content -->
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row mb-3">
                    <div class="col-sm-6"><h3 class="mb-0">Invoice</h3></div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item active"><a href="invoice.php">Invoice</a></li>
                        </ol>
                    </div>
                </div>

                <!-- Notifikasi -->
                <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php
                        if ($_GET['success'] === 'add') echo "Invoice berhasil ditambahkan!";
                        elseif ($_GET['success'] === 'edit') echo "Invoice berhasil diperbarui!";
                        elseif ($_GET['success'] === 'delete') echo "Invoice berhasil dihapus!";
                        ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['error']) && $_GET['error'] === 'duplicate'): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Nama Invoice sudah ada, silakan gunakan nama lain.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <!-- Form Pencarian Invoice -->
                <form method="GET" class="row g-3 mb-3 align-items-end">
  <div class="col-md-3">
    <input type="text" name="search" class="form-control" placeholder="Kata kunci..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
  </div>

  <div class="col-md-3">
    <select name="customer_id" class="form-control">
      <option value="">Pilih Customer</option>
      <?php mysqli_data_seek($customers, 0); while ($c = mysqli_fetch_assoc($customers)) : ?>
        <option value="<?= $c['id'] ?>" <?= (isset($_GET['customer_id']) && $_GET['customer_id'] == $c['id']) ? 'selected' : '' ?>>
          <?= htmlspecialchars($c['name']) ?>
        </option>
      <?php endwhile; ?>
    </select>
  </div>

  <div class="col-md-2">
    <input type="date" name="date_from" class="form-control" value="<?= htmlspecialchars($_GET['date_from'] ?? '') ?>">
  </div>

  <div class="col-auto d-flex align-items-center">
    <span>sampai</span>
  </div>

  <div class="col-md-2">
    <input type="date" name="date_to" class="form-control" value="<?= htmlspecialchars($_GET['date_to'] ?? '') ?>">
  </div>

  <div class="col-md-2 d-flex">
    <button class="btn btn-primary me-2" type="submit">Search</button>
    <a href="invoice.php" class="btn btn-secondary">Reset</a>
  </div>
</form>
                <!-- Form Tambah / Edit Invoice -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title"><?= $edit ? 'Edit Invoice' : 'Tambah Invoice' ?></h3>
                    </div>
                    <div class="card-body">
                        <form method="post" class="row g-3">
                            <input type="hidden" name="id" value="<?= $edit['id'] ?? '' ?>">
                            <div class="col-md-4">
                                <label>Nama Invoice</label>
                                <input type="text" name="invoice_name" class="form-control" value="<?= $edit['invoice_name'] ?? '' ?>" required>
                            </div>
                            <div class="col-md-4">
                            <label>Customer</label>
                                <select name="customer_id" class="form-control" required>
                                    <option value="">Pilih Customer</option>
                                    <?php mysqli_data_seek($customers, 0); while ($c = mysqli_fetch_assoc($customers)) : ?>
                                        <option value="<?= $c['id'] ?>" <?= ($edit['customer_id'] ?? '') == $c['id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($c['name']) ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Tanggal</label>
                                <input type="date" name="tanggal" class="form-control" value="<?= $edit['tanggal'] ?? date('Y-m-d') ?>" required>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary"><?= $edit ? 'Update' : 'Simpan' ?></button>
                                <?php if ($edit) : ?>
                                    <a href="invoice.php" class="btn btn-secondary">Batal Edit</a>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Tabel Daftar Invoice -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Invoice</h3>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Invoice</th>
                                    <th>Customer</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; while ($row = mysqli_fetch_assoc($invoices)) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($row['invoice_name']) ?></td>
                                    <td><?= htmlspecialchars($row['customer_name']) ?></td>
                                    <td><?= htmlspecialchars($row['tanggal']) ?></td>
                                    <td>
                                        <a href="?edit=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                        <a href="?delete=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Delete</a>
                                        <a href="invoice_detail.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-info">Detail</a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="app-footer">
        <div class="float-end d-none d-sm-inline">This is the homepage</div>
        <strong>Copyright &copy; 2014-2024 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    </footer>
</div>

<!-- AdminLTE JS -->
<script src="adminlte.js"></script>
<!-- Bootstrap 5 JS (buat alert dismissible) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
