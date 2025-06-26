<?php
include 'db.php';

// Get data for dropdowns (if needed)
$items = $conn->query("SELECT id, name FROM items")->fetch_all(MYSQLI_ASSOC);
$customers = $conn->query("SELECT id, name FROM customers")->fetch_all(MYSQLI_ASSOC);

// Search functionality
$search = $_GET['search'] ?? '';
$whereClause = '';

if (!empty($search)) {
    $search = $conn->real_escape_string($search);
    $whereClause = "WHERE i.name LIKE '%$search%' OR c.name LIKE '%$search%'";
}

// Get item_customer data
$data = $conn->query("
    SELECT ic.id, i.name AS item_name, c.name AS customer_name, ic.harga
    FROM item_customer ic
    JOIN items i ON ic.item_id = i.id
    JOIN customers c ON ic.customer_id = c.id
    $whereClause
    ORDER BY ic.id ASC
")->fetch_all(MYSQLI_ASSOC);

// Status messages
$status_messages = [
    'added' => 'Data berhasil ditambahkan',
    'updated' => 'Data berhasil diperbarui',
    'deleted' => 'Data berhasil dihapus',
    'error' => 'Terjadi kesalahan'
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
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6"><h3 class="mb-0">Item Customer</h3></div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item active">Item Customer</li>
                            </ol>
                        </div>
                    </div>

                    <!-- Status Messages -->
                    <?php if (isset($_GET['status'])): ?>
                        <div class="alert alert-<?= $_GET['status'] == 'error' ? 'danger' : 'success' ?> alert-dismissible fade show">
                            <?= htmlspecialchars($_GET['message'] ?? $status_messages[$_GET['status']] ?? '') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="app-content">
                <div class="container-fluid">
                    <!-- Search Section -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Search Item Customer</h3>
                        </div>
                        <div class="card-body">
                            <form method="GET" class="row g-3">
                                <div class="col-md-8">
                                    <input type="text" name="search" class="form-control" 
                                           placeholder="Cari berdasarkan item atau customer..." 
                                           value="<?= htmlspecialchars($search) ?>">
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary me-2">
                                        <i class="fas fa-search"></i> Search
                                    </button>
                                    <a href="item_customer.php" class="btn btn-secondary">
                                        <i class="fas fa-sync-alt"></i> Reset
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Items Customer Table -->
                    <div class="card mb-4">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="card-title me-4 mb-0">Tabel Item Customer</h3>
                            <a href="item_customer_form.php" class="btn btn-success float-end">
                                <i class="fas fa-plus me-0"></i> Tambah Item Customer
                            </a>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="align-middle">
                                        <th style="width: 10px">#</th>
                                        <th>Item</th>
                                        <th>Customer</th>
                                        <th>Harga</th>
                                        <th style="width: 170px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($data)): ?>
                                        <tr class="align-middle">
                                            <td colspan="5" class="text-center">Tidak ada data item customer yang ditemukan</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($data as $index => $row): ?>
                                            <tr class="align-middle">
                                                <td><?= $index + 1 ?></td>
                                                <td><?= htmlspecialchars($row['item_name']) ?></td>
                                                <td><?= htmlspecialchars($row['customer_name']) ?></td>
                                                <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <a href="item_customer_form.php?edit_id=<?= $row['id'] ?>" 
                                                           class="btn btn-sm btn-warning">
                                                            <i class="fas fa-edit me-1"></i> Edit
                                                        </a>
                                                        <a href="controllers/ItemCustomerController.php?delete=<?= $row['id'] ?>" 
                                                           class="btn btn-sm btn-danger" 
                                                           onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                            <i class="fas fa-trash-alt me-1"></i> Delete
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
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
