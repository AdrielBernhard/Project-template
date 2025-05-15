<?php
include 'db.php';

$edit_customer = null;

// Check if we're editing an existing customer
if (isset($_GET['edit_id'])) {
    $edit_id = intval($_GET['edit_id']);
    $stmt = $conn->prepare("SELECT * FROM customers WHERE id = ?");
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $edit_customer = $result->fetch_assoc();
    $stmt->close();
}

$page_title = $edit_customer ? 'Edit Customer' : 'Tambah Customer';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .container {
            max-width: 800px;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h2 class="mb-4"><?= $page_title ?></h2>
        
        <!-- Back button -->
        <a href="customers.php" class="btn btn-secondary mb-4">
            <i class="fas fa-arrow-left"></i> Kembali ke Customers
        </a>

        <!-- Status Messages -->
        <?php if (isset($_GET['status']) && $_GET['status'] == 'duplicate'): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                Reference number already exists. Please use a different one.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Customer Form -->
        <div class="card">
            <div class="card-header">
                <h5>Detail Customer</h5>
            </div>
            <div class="card-body">
                <form method="post" action="controllers/CustomersController.php">
                    <input type="hidden" name="id" value="<?= $edit_customer['id'] ?? '' ?>">
                    
                    <div class="mb-3">
                        <label for="ref_no" class="form-label">Reference Number</label>
                        <input type="text" class="form-control" id="ref_no" name="ref_no" 
                               placeholder="Masukkan reference number" required
                               value="<?= htmlspecialchars($edit_customer['ref_no'] ?? '') ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Customer</label>
                        <input type="text" class="form-control" id="name" name="name" 
                               placeholder="Masukkan nama customer" required
                               value="<?= htmlspecialchars($edit_customer['name'] ?? '') ?>">
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" name="<?= $edit_customer ? 'update_customer' : 'add_customer' ?>" 
                                class="btn btn-<?= $edit_customer ? 'success' : 'primary' ?> me-md-2">
                            <i class="fas fa-save"></i> <?= $edit_customer ? 'Update' : 'Simpan' ?>
                        </button>
                        <a href="customers.php" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-dismiss alerts after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                new bootstrap.Alert(alert).close();
            });
        }, 5000);
    </script>
</body>
</html>