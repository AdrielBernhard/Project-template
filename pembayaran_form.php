<?php
include 'db.php';

// Validate invoice_id
if (!isset($_GET['invoice_id']) || !is_numeric($_GET['invoice_id'])) {
    header("Location: pembayaran.php?error=required");
    exit();
}

$invoice_id = intval($_GET['invoice_id']);

// Get invoice details
$result = $conn->query("SELECT invoice.*, customers.name AS customer_name,
                       (SELECT SUM(total_harga) FROM invoice_items WHERE invoice_id = $invoice_id) AS total_amount
                       FROM invoice 
                       JOIN customers ON invoice.customer_id = customers.id
                       WHERE invoice.id = $invoice_id");

if (!$result || $result->num_rows == 0) {
    header("Location: pembayaran.php?error=database");
    exit();
}

$invoice_details = $result->fetch_assoc();

// Get payment history
$payment_history = $conn->query("SELECT * FROM invoice_payments 
                                WHERE invoice_id = $invoice_id 
                                ORDER BY payment_date DESC, id DESC");

// Initialize form data
$form_data = [
    'payment_date' => date('Y-m-d'),
    'amount' => ''
];

// Success messages
$success_messages = [
    'payment' => 'Pembayaran berhasil dicatat',
    'delete' => 'Pembayaran berhasil dihapus'
];
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Form Pembayaran Invoice</title>
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
              <div class="col-sm-6"><h3 class="mb-0">Form Pembayaran Invoice</h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="pembayaran.php">Pembayaran</a></li>
                    <li class="breadcrumb-item active">Form Pembayaran</li>
                </ol>
              </div>
            </div>
          </div>
        </div>

        <div class="app-content">
          <div class="container-fluid">
            <?php if (isset($_GET['success'])): ?>
              <div class="alert alert-success alert-dismissible fade show mb-3">
                <?= $success_messages[$_GET['success']] ?? 'Operasi berhasil' ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
            <?php endif; ?>
            
            <div class="row">
              <div class="col-12">
                <!-- Invoice Summary Card -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Ringkasan Invoice</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <p><strong>Nama Invoice:</strong> <?= htmlspecialchars($invoice_details['invoice_name']) ?></p>
                                <p><strong>Customer:</strong> <?= htmlspecialchars($invoice_details['customer_name']) ?></p>
                            </div>
                            <div class="col-md-4">
                                <p><strong>Total Tagihan:</strong> Rp <?= number_format($invoice_details['total_amount'], 0, ',', '.') ?></p>
                                <p><strong>Total Dibayar:</strong> Rp <?= number_format($invoice_details['total_paid'], 0, ',', '.') ?></p>
                            </div>
                            <div class="col-md-4">
                                <p><strong>Sisa Tagihan:</strong> Rp <?= number_format($invoice_details['total_amount'] - $invoice_details['total_paid'], 0, ',', '.') ?></p>
                                <p><strong>Status:</strong> 
                                    <span class="badge bg-<?= $invoice_details['status'] == 'paid' ? 'success' : ($invoice_details['status'] == 'partial' ? 'warning' : 'danger') ?>">
                                        <?= ucfirst($invoice_details['status']) ?>
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Payment Form Card -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Form Pembayaran</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="controllers/PaymentController.php">
                            <input type="hidden" name="invoice_id" value="<?= $invoice_details['id'] ?>">
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Jumlah Pembayaran</label>
                                        <input type="number" name="amount" class="form-control" 
                                            value="<?= htmlspecialchars($form_data['amount']) ?>" 
                                            min="1" 
                                            max="<?= $invoice_details['total_amount'] - $invoice_details['total_paid'] ?>"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Pembayaran</label>
                                        <input type="date" name="payment_date" class="form-control" 
                                            value="<?= htmlspecialchars($form_data['payment_date']) ?>" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Simpan Pembayaran
                                </button>
                                <a href="invoice_detail.php?id=<?= $invoice_details['id'] ?>" class="btn btn-info">
                                    <i class="fas fa-file-invoice me-1"></i> Lihat Invoice
                                </a>
                                <a href="pembayaran.php" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-1"></i> Kembali
                                </a>
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