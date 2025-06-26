<?php
include 'db.php';

// Get invoices for dropdown (only unpaid or partially paid)
$invoices = $conn->query("SELECT invoice.*, customers.name AS customer_name 
                         FROM invoice 
                         JOIN customers ON invoice.customer_id = customers.id
                         WHERE invoice.status != 'paid'");

// Error messages
$error_messages = [
    'required' => 'Semua field harus diisi',
    'invalid_amount' => 'Jumlah pembayaran tidak valid',
    'exceed' => 'Jumlah pembayaran melebihi sisa tagihan',
    'database' => 'Terjadi kesalahan database'
];
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Pilih Invoice untuk Pembayaran</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="adminlte.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="layout-fixed sidebar-expand-lg sidebar-mini sidebar-collapse bg-body-tertiary">
    <div class="app-wrapper">
      <?php include 'sidebar-navbar.html'; ?>

      <main class="app-main">
        <div class="app-content-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6"><h3 class="mb-0">Pilih Invoice untuk Pembayaran</h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="invoice.php">Invoice</a></li>
                    <li class="breadcrumb-item active">Pilih Pembayaran</li>
                </ol>
              </div>
            </div>
          </div>
        </div>

        <div class="app-content">
          <div class="container-fluid">
            <?php if (isset($_GET['error'])): ?>
              <div class="alert alert-danger alert-dismissible fade show mb-3">
                <?= $error_messages[$_GET['error']] ?? 'Terjadi kesalahan' ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
            <?php endif; ?>
            
            <div class="row">
              <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Pilih Invoice</h3>
                    </div>
                    <div class="card-body">
                        <form method="get" action="pembayaran_form.php">
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