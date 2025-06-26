<?php
include 'db.php';

// Input validation and sanitization
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$customer_id = isset($_GET['customer_id']) ? (int)$_GET['customer_id'] : 0;
$date_from = isset($_GET['date_from']) ? $_GET['date_from'] : '';
$date_to = isset($_GET['date_to']) ? $_GET['date_to'] : '';

// Validate dates
if (!empty($date_from) && !DateTime::createFromFormat('Y-m-d', $date_from)) {
    $date_from = '';
}
if (!empty($date_to) && !DateTime::createFromFormat('Y-m-d', $date_to)) {
    $date_to = '';
}

// Base query with parameterized values
$query = "SELECT invoice.*, customers.name AS customer_name, customers.ref_no AS customer_ref_no 
          FROM invoice 
          JOIN customers ON invoice.customer_id = customers.id 
          WHERE 1=1";

$params = [];
$types = '';

// Add search conditions
if (!empty($search)) {
    $query .= " AND (invoice.invoice_name LIKE ? OR customers.name LIKE ? OR invoice.tanggal LIKE ? OR invoice.due_date LIKE ?)";
    $params[] = '%' . $search . '%';
    $params[] = '%' . $search . '%';
    $params[] = '%' . $search . '%';
    $params[] = '%' . $search . '%';
    $types .= 'ssss';
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

// Pagination
$per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $per_page;

$count_query = str_replace('SELECT invoice.*, customers.name AS customer_name, customers.ref_no AS customer_ref_no', 'SELECT COUNT(*) as total', $query);
$count_stmt = $conn->prepare($count_query);
if (!empty($params)) {
    $count_stmt->bind_param($types, ...$params);
}
$count_stmt->execute();
$total_rows = $count_stmt->get_result()->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $per_page);

$query .= " LIMIT ? OFFSET ?";
$params[] = $per_page;
$params[] = $offset;
$types .= 'ii';

// Execute query
$stmt = $conn->prepare($query);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$invoices = $stmt->get_result();

// Get customers for filter dropdown
$customers = $conn->query("SELECT * FROM customers ORDER BY name");

// Success messages
$success_messages = [
    'add' => 'Invoice berhasil ditambahkan',
    'edit' => 'Invoice berhasil diperbarui',
    'delete' => 'Invoice berhasil dihapus'
];
?>

<!doctype html>
<html lang="en">
  <!--begin::Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>AdminLTE 4 | Sidebar Mini</title>
    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="AdminLTE 4 | Sidebar Mini" />
    <meta name="author" content="ColorlibHQ" />
    <meta
      name="description"
      content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS."
    />
    <meta
      name="keywords"
      content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard"
    />
    <!--end::Primary Meta Tags-->
    <!--begin::Fonts-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
      integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q="
      crossorigin="anonymous"
    />
    <!--end::Fonts-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css"
      integrity="sha256-tZHrRjVqNSRyWg2wbppGnT833E/Ys0DHWGwT04GiqQg="
      crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(OverlayScrollbars)-->
    <!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
      integrity="sha256-9kPW/n5nn53j4WMRYAxe9c1rCY96Oogo/MKSVdKzPmI="
      crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(Bootstrap Icons)-->
    <!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="adminlte.css" />
    <!--end::Required Plugin(AdminLTE)-->
  </head>
  <!--end::Head-->
  <!--begin::Body-->
  <body class="layout-fixed sidebar-expand-lg sidebar-mini sidebar-collapse bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">

      <?php include 'sidebar-navbar.html'; ?>

      <!--begin::App Main-->
      <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6"><h3 class="mb-0">Invoice</h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                  <li class="breadcrumb-item active">Invoice</li>
                </ol>
              </div>
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-12">
                 <!-- Success Messages -->
                <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <?= $success_messages[$_GET['success']] ?? 'Operasi berhasil' ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Error Messages -->
                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <?= ($_GET['error'] == 'delete') ? 'Gagal menghapus invoice' : 'Terjadi kesalahan' ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                <!-- Default box -->
                <!-- Search Form -->
<div class="card mb-4">
    <div class="card-header">
        <h3 class="card-title">Search Items</h3>
    </div>
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control" placeholder="Cari (Nama, Customer, Tanggal)..." value="<?= htmlspecialchars($search) ?>">
            </div>
            <div class="col-md-3">
                <select name="customer_id" class="form-control">
                    <option value="">Semua Customer</option>
                    <?php while ($customer = $customers->fetch_assoc()): ?>
                        <option value="<?= $customer['id'] ?>" <?= ($customer['id'] == $customer_id) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($customer['name']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" name="date_from" class="form-control" placeholder="Dari Tanggal" value="<?= htmlspecialchars($date_from) ?>">
            </div>
            <div class="col-md-2">
                <input type="date" name="date_to" class="form-control" placeholder="Sampai Tanggal" value="<?= htmlspecialchars($date_to) ?>">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Cari</button>
                <a href="invoice.php" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header d-flex align-items-center">
        <h3 class="card-title me-4 mb-0">Tabel Invoice</h3>
        <a href="invoice_form.php" class="btn btn-success float-end">
            <i class="fas fa-plus me-0"></i> Tambah Invoice
        </a>
    </div>
    
    <!-- Card Body berisi tabel data -->
    <div class="card-body">
        <table class="table table-bordered">
    <thead>
        <tr class="align-middle">
            <th style="width: 10px">#</th>
            <th>Nama Invoice</th>
            <th>Code Customer</th>
            <th>Customer</th>
            <th>Grand Total</th>
            <th>Status</th>
            <th>Tanggal</th>
            <th>Jatuh Tempo</th>
            <th style="width: 250px">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; while ($invoice = $invoices->fetch_assoc()): 
            // Hitung grand total untuk invoice ini
            $grand_total_query = $conn->query("SELECT SUM(total_harga) AS grand_total FROM invoice_items WHERE invoice_id = {$invoice['id']}");
            $grand_total_row = $grand_total_query->fetch_assoc();
            $grand_total = $grand_total_row['grand_total'] ?? 0;
        ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($invoice['invoice_name']) ?></td>
                <td><?= htmlspecialchars($invoice['customer_ref_no']) ?></td>
                <td><?= htmlspecialchars($invoice['customer_name']) ?></td>
                <td>Rp <?= number_format($grand_total, 0, ',', '.') ?></td>
                <td>
                    <span class="badge bg-<?= $invoice['status'] == 'paid' ? 'success' : ($invoice['status'] == 'partial' ? 'warning' : 'danger') ?>">
                        <?= ucfirst($invoice['status']) ?>
                    </span>
                </td>
                <td><?= date('m-d-Y', strtotime(htmlspecialchars($invoice['tanggal']))) ?></td>
                <td><?= date('m-d-Y', strtotime(htmlspecialchars($invoice['due_date']))) ?></td>
                
                <td>
                  <a href="invoice_form.php?edit=<?= $invoice['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                  <a href="controllers/InvoiceController.php?delete=<?= $invoice['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</a>
                  <a href="invoice_detail.php?id=<?= $invoice['id'] ?>" class="btn btn-sm btn-info">Detail</a>
                  <a href="invoice_detail_full.php?id=<?= $invoice['id'] ?>" class="btn btn-sm btn-success">Lengkap</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
    </div>
    
    <!-- Card Footer dengan pagination -->
    <div class="card-footer clearfix">
        <ul class="pagination pagination-sm m-0 float-end">
            <li class="page-item"><a class="page-link" href="#">«</a></li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">»</a></li>
        </ul>
    </div>
</div>
              </div>
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content-->
      </main>
      <!--end::App Main-->
      <!--begin::Footer-->
      <footer class="app-footer">
        <!--begin::Copyright-->
        <strong>
          Copyright &copy; 2014-2024&nbsp;
          <a href="https://adminlte.io" class="text-decoration-none">AdminLTE.io</a>.
        </strong>
        All rights reserved.
        <!--end::Copyright-->
      </footer>
      <!--end::Footer-->
    </div>
    <!--end::App Wrapper-->
    <!--begin::Script-->
    
    <?php include 'script.php'; ?>

    <!--end::Script-->
  </body>
  <!--end::Body-->
</html>
