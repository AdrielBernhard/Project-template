<?php
include 'db.php';
// Validate invoice ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid invoice ID");
}
$invoice_id = intval($_GET['id']);

// Get invoice details
$invoice_query = $conn->query("SELECT invoice.*, customers.name AS customer_name, 
                             customers.ref_no AS customer_ref_no,
                             (SELECT SUM(total_harga) FROM invoice_items WHERE invoice_id = $invoice_id) AS total_amount
                             FROM invoice 
                             JOIN customers ON invoice.customer_id = customers.id
                             WHERE invoice.id = $invoice_id");

if (!$invoice_query || $invoice_query->num_rows == 0) {
    die("Invoice not found");
}
$invoice = $invoice_query->fetch_assoc();

// Get payment history
$payments_query = $conn->query("SELECT * FROM invoice_payments 
                               WHERE invoice_id = $invoice_id
                               ORDER BY payment_date DESC, id DESC");

// Calculate totals
$grand_total = $invoice['total_amount'] ?? 0;
$total_paid = $invoice['total_paid'] ?? 0;
$balance = $grand_total - $total_paid;
?>

<!doctype html>
<html lang="en">
  <!--begin::Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Tuggakan</title>
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

      <main class="app-main">
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Detail Invoice Lengkap</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item"><a href="invoice.php">Invoice</a></li>
                                <li class="breadcrumb-item active">Detail</li>
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

                    <div class="row">
                        <div class="col-md-12">
                            <!-- Invoice Header -->
                            <div class="invoice-header">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h2>INVOICE</h2>
                                        <p class="mb-1"><strong>No. Invoice:</strong> <?= htmlspecialchars($invoice['invoice_name']) ?></p>
                                        <p class="mb-1"><strong>Tanggal:</strong> <?= htmlspecialchars($invoice['tanggal']) ?></p>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <p class="mb-1"><strong>Status:</strong> 
                                            <span class="badge bg-<?= $invoice['status'] == 'paid' ? 'success' : ($invoice['status'] == 'partial' ? 'warning' : 'danger') ?>">
                                                <?= ucfirst($invoice['status']) ?>
                                            </span>
                                        </p>
                                        <p class="mb-1"><strong>Customer:</strong> <?= htmlspecialchars($invoice['customer_name']) ?></p>
                                        <p class="mb-1"><strong>Kode Customer:</strong> <?= htmlspecialchars($invoice['customer_ref_no']) ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Items Section -->
                        <div class="col-md-8">
                            <!-- Payment History -->
                            <!-- Payment History -->
<div class="card payment-card">
    <div class="card-header">
        <h3 class="card-title">Riwayat Pembayaran</h3>
    </div>
    <div class="card-body">
        <?php if ($payments_query->num_rows > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 5%">No</th>
                            <th>Tanggal Pembayaran</th>
                            <th>Jumlah Pembayaran</th>
                            <th style="width: 30%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $counter = 1;
                        while ($payment = $payments_query->fetch_assoc()): 
                            $payment_percentage = ($payment['amount'] / $grand_total) * 100;
                            $status_class = $payment['amount'] == $grand_total ? 'success' : 
                                          ($payment['amount'] > 0 ? 'warning' : 'danger');
                        ?>
                        <tr class="align-middle">
                            <td><?= $counter++ ?></td>
                            <td><?= htmlspecialchars($payment['payment_date']) ?></td>
                            <td>Rp <?= number_format($payment['amount'], 0, ',', '.') ?></td>
                            <td>
                                <a href="edit_payment.php?id=<?= $payment['id'] ?>" 
                                class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="delete_payment.php?id=<?= $payment['id'] ?>" 
                                class="btn btn-sm btn-danger" 
                                onclick="return confirm('Yakin ingin menghapus pembayaran ini?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </a>
                                <button class="btn btn-sm btn-primary" onclick="printPaymentHistory(<?= $payment['amount'] ?>, '<?= $payment['payment_date'] ?>')">
                                    <i class="fas fa-print me-1"></i> Cetak
                                </button>
                                <button class="btn btn-sm btn-success" onclick="downloadPDF(<?= $payment['amount'] ?>, '<?= $payment['payment_date'] ?>')">
                                    <i class="fas fa-file-pdf me-1"></i> PDF
                                </button>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-muted">Belum ada riwayat pembayaran</p>
        <?php endif; ?>
    </div>
</div>

<script>
function printPaymentHistory(paymentAmount = 0, paymentDate = '') {
    if (paymentAmount === 0) {
        paymentAmount = <?= $total_paid ?>;
        paymentDate = '<?= date('d/m/Y') ?>';
    }
    window.open('print_payment_history.php?invoice_id=<?= $invoice_id ?>&amount=' + paymentAmount + '&payment_date=' + encodeURIComponent(paymentDate), '_blank');
}

function downloadPDF(paymentAmount = 0, paymentDate = '') {
    if (paymentAmount === 0) {
        paymentAmount = <?= $total_paid ?>;
        paymentDate = '<?= date('d/m/Y') ?>';
    }
    window.location.href = 'generate_payment_pdf.php?invoice_id=<?= $invoice_id ?>&amount=' + paymentAmount + '&payment_date=' + encodeURIComponent(paymentDate);
}
</script>
                        </div>

                        <!-- Summary Section -->
                        <div class="col-md-4">
                            <div class="card mb-4 summary-card">
                                <div class="card-header">
                                    <h3 class="card-title">Ringkasan Pembayaran</h3>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <p><strong>Total Tagihan:</strong></p>
                                        <h4>Rp <?= number_format($grand_total, 0, ',', '.') ?></h4>
                                    </div>

                                    <div class="mb-3">
                                        <p><strong>Total Dibayar:</strong></p>
                                        <h4>Rp <?= number_format($total_paid, 0, ',', '.') ?></h4>
                                    </div>

                                    <div class="mb-3">
                                        <p><strong>Sisa Tagihan:</strong></p>
                                        <h4 class="<?= $balance > 0 ? 'text-danger' : 'text-success' ?>">
                                            Rp <?= number_format($balance, 0, ',', '.') ?>
                                        </h4>
                                    </div>

                                    <?php if ($balance > 0): ?>
                                        <a href="pembayaran_form.php?invoice_id=<?= $invoice_id ?>" class="btn btn-primary w-100">
                                            <i class="fas fa-money-bill-wave me-2"></i>Bayar Invoice
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>

                            
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between">
                                <a href="invoice.php" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Invoice
                                </a>
                                <div>
                                    <a href="invoice_print.php?id=<?= $invoice_id ?>" class="btn btn-info me-2">
                                        <i class="fas fa-print me-2"></i>Cetak Invoice
                                    </a>
                                    <a href="invoice_detail.php?id=<?= $invoice_id ?>" class="btn btn-primary">
                                        <i class="fas fa-file-invoice me-2"></i>Lihat Tampilan Singkat
                                    </a>
                                </div>
                            </div>
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
