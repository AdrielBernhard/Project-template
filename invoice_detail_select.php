<?php
include 'db.php';

// Initialize form data
$form_data = [
    'invoice_id' => $_GET['invoice_id'] ?? ''
];

// Redirect to detail page if invoice is selected
if (!empty($form_data['invoice_id'])) {
    header("Location: invoice_detail_full.php?id=" . $form_data['invoice_id']);
    exit();
}

// Get invoices for dropdown
$invoices = $conn->query("SELECT invoice.*, customers.name AS customer_name 
                         FROM invoice 
                         JOIN customers ON invoice.customer_id = customers.id");
?>

<!doctype html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Tunggakan</title>
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
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
      integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q="
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css"
      integrity="sha256-tZHrRjVqNSRyWg2wbppGnT833E/Ys0DHWGwT04GiqQg="
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
      integrity="sha256-9kPW/n5nn53j4WMRYAxe9c1rCY96Oogo/MKSVdKzPmI="
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="adminlte.css" />
  </head>
  <body class="layout-fixed sidebar-expand-lg sidebar-mini sidebar-collapse bg-body-tertiary">
    <div class="app-wrapper">
      <?php include 'sidebar-navbar.html'; ?>

      <main class="app-main">
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Tunggakan</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item"><a href="invoice.php">Invoice</a></li>
                                <li class="breadcrumb-item active">Tunggakan</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="app-content">
                <div class="container-fluid">
                    <!-- Status Messages -->
                    <?php if (isset($_GET['success'])): ?>
                        <div class="alert alert-success alert-dismissible fade show mb-3">
                            <?= htmlspecialchars($_GET['success']) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Invoice Selection Card -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Pilih Invoice</h3>
                        </div>
                        <div class="card-body">
                            <form method="get" action="invoice_detail_select.php">
                                <div class="mb-3">
                                    <label class="form-label">Invoice</label>
                                    <select name="invoice_id" class="form-control" required 
                                        onchange="this.form.submit()">
                                        <option value="">Pilih Invoice</option>
                                        <?php while ($invoice = $invoices->fetch_assoc()): ?>
                                            <option value="<?= $invoice['id'] ?>">
                                                <?= htmlspecialchars($invoice['invoice_name']) ?> - 
                                                <?= htmlspecialchars($invoice['customer_name']) ?> - 
                                                Rp <?= number_format($invoice['total_amount'] ?? 0, 0, ',', '.') ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>

      <footer class="app-footer">
        <strong>
          Copyright &copy; 2014-2024&nbsp;
          <a href="https://adminlte.io" class="text-decoration-none">AdminLTE.io</a>.
        </strong>
        All rights reserved.
      </footer>
    </div>
    
    <?php include 'script.php'; ?>
  </body>
</html>