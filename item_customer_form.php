<?php
include 'db.php';

// Get data for dropdowns
$items = $conn->query("SELECT id, name FROM items")->fetch_all(MYSQLI_ASSOC);
$customers = $conn->query("SELECT id, name FROM customers")->fetch_all(MYSQLI_ASSOC);

// Initialize form data
$form_data = [
    'id' => isset($_GET['edit_id']) ? intval($_GET['edit_id']) : null,
    'item_id' => isset($_GET['item_id']) ? intval($_GET['item_id']) : '',
    'customer_id' => isset($_GET['customer_id']) ? intval($_GET['customer_id']) : '',
    'harga' => isset($_GET['harga']) ? floatval($_GET['harga']) : ''
];

// If editing and no GET parameters, get data from database
if (isset($_GET['edit_id']) && !isset($_GET['item_id'])) {
    $stmt = $conn->prepare("SELECT * FROM item_customer WHERE id = ?");
    $stmt->bind_param("i", $_GET['edit_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $form_data = array_merge($form_data, $result->fetch_assoc());
    }
    $stmt->close();
}

// Status messages
$status_messages = [
    'added' => 'Data berhasil ditambahkan',
    'updated' => 'Data berhasil diperbarui',
    'deleted' => 'Data berhasil dihapus',
    'duplicate' => 'Kombinasi item dan customer sudah ada',
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
    <div class="app-wrapper">
        <?php include 'sidebar-navbar.html'; ?>

        <main class="app-main">
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6"><h3 class="mb-0"><?= $form_data['id'] ? 'Edit' : 'Tambah' ?> Item Customer</h3></div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item"><a href="item_customer.php">Item Customer</a></li>
                                <li class="breadcrumb-item active"><?= $form_data['id'] ? 'Edit' : 'Tambah' ?></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="app-content">
                <div class="container-fluid">
                    <!-- Status Messages -->
                    <?php if (isset($_GET['status'])): ?>
                        <div class="alert alert-<?= $_GET['status'] == 'duplicate' ? 'danger' : ($_GET['status'] == 'error' ? 'danger' : 'success') ?> alert-dismissible fade show">
                            <?= htmlspecialchars($_GET['message'] ?? $status_messages[$_GET['status']] ?? '') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <strong>Form Item Customer</strong>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="controllers/ItemCustomerController.php">
                                        <input type="hidden" name="id" value="<?= $form_data['id'] ?>">

                                        <div class="mb-3">
                                            <label class="form-label">Item</label>
                                            <select name="item_id" class="form-control" required>
                                                <option value="">- Pilih Item -</option>
                                                <?php foreach ($items as $item): ?>
                                                    <option value="<?= $item['id'] ?>" <?= $form_data['item_id'] == $item['id'] ? 'selected' : '' ?>>
                                                        <?= htmlspecialchars($item['name']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Customer</label>
                                            <select name="customer_id" class="form-control" required>
                                                <option value="">- Pilih Customer -</option>
                                                <?php foreach ($customers as $customer): ?>
                                                    <option value="<?= $customer['id'] ?>" <?= $form_data['customer_id'] == $customer['id'] ? 'selected' : '' ?>>
                                                        <?= htmlspecialchars($customer['name']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Harga</label>
                                            <input type="number" name="harga" class="form-control" 
                                                placeholder="Kosongkan untuk menggunakan harga default item"
                                                value="<?= htmlspecialchars($form_data['harga']) ?>">
                                        </div>
                                        
                                        <div class="d-flex gap-2">
                                            <button type="submit" name="<?= $form_data['id'] ? 'update' : 'add' ?>" class="btn btn-primary">
                                                <?= $form_data['id'] ? 'Update Data' : 'Tambah Data' ?>
                                            </button>
                                            <a href="item_customer.php" class="btn btn-secondary">Kembali</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <footer class="app-footer">
            <!-- Footer content remains the same -->
        </footer>
    </div>

    <?php include 'script.php'; ?>
</body>
</html>