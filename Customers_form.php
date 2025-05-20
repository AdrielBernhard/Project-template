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

<!doctype html>
<html lang="en">
  <!--begin::Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?= $page_title ?></title>
    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="<?= $page_title ?>" />
    <meta name="author" content="Your Name" />
    <meta
      name="description"
      content="Customer management page"
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
              <div class="col-sm-6"><h3 class="mb-0"><?= $page_title ?></h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                  <li class="breadcrumb-item"><a href="customers.php">Customers</a></li>
                  <li class="breadcrumb-item active" aria-current="page"><?= $page_title ?></li>
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
            <!-- Status Messages -->
            <?php if (isset($_GET['status']) && $_GET['status'] == 'duplicate'): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    Reference number already exists. Please use a different one.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            <!--begin::Row-->
            <div class="row">
    <div class="col-12">
        <div class="col-md-15 mx-auto">
            
            <!-- Back button -->
            <a href="Customers.php" class="btn btn-secondary mb-3">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>

            <!-- Status Messages -->
            <?php if (isset($_GET['status']) && $_GET['status'] == 'duplicate'): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    Reference Sudah ada. Pakai yang berbeda.
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
                            <label for="ref_no" class="form-label">Ref_No</label>
                            <input type="text" class="form-control" id="ref_no" name="ref_no" 
                                   placeholder="Reference Number" required
                                   value="<?= htmlspecialchars($edit_customer['ref_no'] ?? '') ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   placeholder="Nama customer" required
                                   value="<?= htmlspecialchars($edit_customer['name'] ?? '') ?>">
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="customers.php" class="btn btn-secondary">Cancel</a>
                            <button type="submit" name="<?= $edit_customer ? 'update_customer' : 'add_customer' ?>" 
                                    class="btn btn-<?= $edit_customer ? 'success' : 'primary' ?> me-md-2">
                                <i class="fas fa-save"></i> <?= $edit_customer ? 'Update' : 'Save' ?>
                            </button>
                        </div>
                    </form>
                </div>
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