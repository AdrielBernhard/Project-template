<?php
include 'db.php';

// Validate ID invoice
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid invoice ID");
}
$invoice_id = intval($_GET['id']);

// Get invoice data
$result = $conn->query("SELECT invoice.*, customers.name AS customer_name 
                        FROM invoice 
                        JOIN customers ON invoice.customer_id = customers.id 
                        WHERE invoice.id = $invoice_id");
if (!$result || $result->num_rows == 0) {
    die("Invoice not found");
}
$invoice = $result->fetch_assoc();

// Get invoice items
$item_invoice = $conn->query("
    SELECT ii.*, i.name AS nama_item
    FROM invoice_items ii
    JOIN items i ON ii.item_id = i.id
    WHERE ii.invoice_id = $invoice_id
    " . (isset($_GET['search']) ? "AND i.name LIKE '%" . $conn->real_escape_string($_GET['search']) . "%'" : "") . "
    ORDER BY ii.id
");

// Success messages
$success_messages = [
    'add' => 'Item berhasil ditambahkan',
    'edit' => 'Item berhasil diperbarui',
    'delete' => 'Item berhasil dihapus'
];

$grand_total = 0;
if ($item_invoice->num_rows > 0) {
    // Simpan pointer awal
    $item_invoice->data_seek(0);
    while ($row = $item_invoice->fetch_assoc()) {
        $grand_total += $row['total_harga'];
    }
    // Kembalikan pointer ke awal untuk iterasi berikutnya
    $item_invoice->data_seek(0);
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Detail_Invoice</title>
    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="<?= $page_title ?>" />
    <meta name="author" content="Your Name" />
    <meta
      name="description"
      content="Item management page"
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
<body class="layout-fixed sidebar-expand-lg sidebar-mini sidebar-collapse bg-body-tertiary">
    <div class="app-wrapper">
        <?php include 'sidebar-navbar.html'; ?>

        <main class="app-main">
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6"><h3 class="mb-0">Detail Invoice</h3></div>
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
                    <div class="row">
                        <div class="col-12">
                            <!-- Status Messages -->
<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?= $success_messages[$_GET['success']] ?? 'Operasi berhasil' ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <?= ($_GET['error'] == 'delete') ? 'Gagal menghapus item' : 'Terjadi kesalahan' ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Invoice Info Card -->
<div class="card mb-4">
    <div class="card-header">
        <h3 class="card-title">Invoice Details</h3>
    </div>
    <div class="card-body">
        <p class="card-text">Invoice: <?= htmlspecialchars($invoice['invoice_name']) ?></p>
        <p class="card-text">Customer: <?= htmlspecialchars($invoice['customer_name']) ?></p>
        <p class="card-text">Tanggal: <?= htmlspecialchars($invoice['tanggal']) ?></p>
        <p class="card-text">Grand Total: Rp <?= number_format($grand_total, 0, ',', '.') ?></p>
    </div>
</div>

<!-- Notes and Terms Card -->
<div class="card mb-4">
    <div class="card-header">
        <h3 class="card-title">Additional Information</h3>
    </div>
    <div class="card-body">
        <?php if (!empty($invoice['note'])): ?>
            <div class="mb-4">
                <h5>Note</h5>
                <p><?= nl2br(htmlspecialchars($invoice['note'])) ?></p>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($invoice['terms_conditions'])): ?>
            <div>
                <h5>Terms and Conditions</h5>
                <p><?= nl2br(htmlspecialchars($invoice['terms_conditions'])) ?></p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Items Table Card -->
<div class="card">
    <div class="card-header d-flex align-items-center">
        <h3 class="card-title me-4 mb-0">Invoice Items</h3>
        <a href="invoice_detail_form.php?invoice_id=<?= $invoice_id ?>" class="btn btn-success">
            <i class="fas fa-plus me-1"></i> Tambah Item
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr class="align-middle">
                        <th style="width: 10px">#</th>
                        <th>Nama Item</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                        <th style="width: 170px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($item_invoice->num_rows > 0): ?>
                        <?php $counter = 1; ?>
                        <?php while ($row = $item_invoice->fetch_assoc()): ?>
                            <tr class="align-middle">
                                <td><?= $counter++ ?></td>
                                <td><?= htmlspecialchars($row['nama_item']) ?></td>
                                <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                                <td><?= $row['jumlah'] ?></td>
                                <td>Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="invoice_detail_form.php?invoice_id=<?= $invoice_id ?>&edit_item=<?= $row['id'] ?>" 
                                           class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit me-1"></i> Edit
                                        </a>
                                        <a href="controllers/InvoiceDetailController.php?delete_item=<?= $row['id'] ?>&invoice_id=<?= $invoice_id ?>" 
                                           class="btn btn-sm btn-danger" 
                                           onclick="return confirm('Yakin hapus item ini?')">
                                            <i class="fas fa-trash-alt me-1"></i> Hapus
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr class="align-middle">
                            <td colspan="6" class="text-center">Belum ada item</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer clearfix">
        <ul class="pagination pagination-sm m-0 float-end">
            <li class="page-item"><a class="page-link" href="#">«</a></li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">»</a></li>
        </ul>
    </div>
    <div class="card-footer clearfix">
        
        <div class="card-footer clearfix">
            <div class="float-end">
                <a href="invoice.php" class="btn btn-secondary me-2">
                    <i class="fas fa-arrow-left me-1"></i> Kembali ke Invoice
                </a>
                <a href="invoice_print.php?id=<?= $invoice_id ?>" class="btn btn-info me-2">
                    <i class="fas fa-print me-2"></i>Print Invoice
                </a>
                <a href="invoice_pdf.php?id=<?= $invoice_id ?>" class="btn btn-success">
                    <i class="fas fa-file-pdf me-2"></i>Download PDF
                </a>
            </div>
        </div>
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