<?php
include 'db.php';

// Initialize form data
$form_data = [
    'id' => $_GET['id'] ?? '',
    'invoice_name' => $_GET['invoice_name'] ?? '',
    'customer_id' => $_GET['customer_id'] ?? '',
    'tanggal' => $_GET['tanggal'] ?? date('Y-m-d'),
    'due_date' => $_GET['due_date'] ?? date('Y-m-d', strtotime('+7 days')) // Default 7 days from today
];

// If editing, get data from database
if (isset($_GET['edit'])) {
    $edit_id = intval($_GET['edit']);
    $stmt = $conn->prepare("SELECT * FROM invoice WHERE id = ?");
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $form_data = array_merge($form_data, $result->fetch_assoc());
    }
    $stmt->close();
}

// Get customers for dropdown
$customers = $conn->query("SELECT * FROM customers");

// Error messages
$error_messages = [
    'required' => 'Semua field harus diisi',
    'duplicate' => 'Nama Invoice sudah ada',
    'database' => 'Terjadi kesalahan database'
];
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title><?= $form_data['id'] ? 'Edit' : 'Tambah' ?> Invoice</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="adminlte.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
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
              <div class="col-sm-6"><h3 class="mb-0"><?= $form_data['id'] ? 'Edit' : 'Tambah' ?> Invoice</h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="invoice.php">Invoice</a></li>
                    <li class="breadcrumb-item active"><a href="invoice_form">Invoice_form</a></li>
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
            <!-- Error Messages -->
            <?php if (isset($_GET['error'])): ?>
              <div class="alert alert-danger alert-dismissible fade show mb-3">
                <?= $error_messages[$_GET['error']] ?? 'Terjadi kesalahan' ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
            <?php endif; ?>
            <!--begin::Row-->
            <div class="row">
              <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="controllers/InvoiceController.php">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($form_data['id']) ?>">
                            
                            <div class="mb-3">
                                <label class="form-label">Nama Invoice</label>
                                <input type="text" name="invoice_name" class="form-control" 
                                       value="<?= htmlspecialchars($form_data['invoice_name']) ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Customer</label>
                                <select name="customer_id" class="form-control" required>
                                    <option value="">Pilih Customer</option>
                                    <?php while ($customer = $customers->fetch_assoc()): ?>
                                        <option value="<?= $customer['id'] ?>" 
                                            <?= ($customer['id'] == $form_data['customer_id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($customer['name']) ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Tanggal</label>
                                <input type="date" name="tanggal" class="form-control" 
                                       value="<?= htmlspecialchars($form_data['tanggal']) ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Tanggal Jatuh Tempo</label>
                                <input type="date" name="due_date" class="form-control" 
                                      value="<?= htmlspecialchars($form_data['due_date']) ?>" required>
                            </div>
                            
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <?= $form_data['id'] ? 'Update' : 'Simpan' ?>
                                </button>
                                <a href="invoice.php" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.card -->
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
</html>