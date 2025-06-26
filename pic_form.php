<?php
include 'db.php';

// Initialize PIC data from GET or database
$edit_pic = [
    'id' => isset($_GET['edit_id']) ? intval($_GET['edit_id']) : null,
    'name' => isset($_GET['name']) ? $_GET['name'] : '',
    'position' => isset($_GET['position']) ? $_GET['position'] : '',
    'email' => isset($_GET['email']) ? $_GET['email'] : '',
    'status' => isset($_GET['status']) ? $_GET['status'] : 'off'
];

// If we're editing and no GET parameters are set, get data from database
if (isset($_GET['edit_id']) && !isset($_GET['name'])) {
    $edit_id = intval($_GET['edit_id']);
    $stmt = $conn->prepare("SELECT * FROM pic WHERE id = ?");
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $db_pic = $result->fetch_assoc();
    $stmt->close();
    
    if ($db_pic) {
        $edit_pic = array_merge($edit_pic, $db_pic);
    }
}

$page_title = ($edit_pic['id'] !== null) ? 'Edit PIC' : 'Tambah PIC';
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
      content="PIC management page"
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
                  <li class="breadcrumb-item"><a href="pic.php">PIC</a></li>
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
            <!--begin::Row-->
            <div class="row">
    <div class="col-12">
        <div class="col-md-15 mx-auto">
            
            <!-- Back button -->
            <a href="pic.php" class="btn btn-secondary mb-3">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>

            <!-- Status Messages -->
            <?php if (isset($_GET['status']) && $_GET['status'] == 'duplicate'): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    Email sudah digunakan. Gunakan email yang berbeda.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- PIC Form -->
            <div class="card">
                <div class="card-header">
                    <h5>Detail PIC</h5>
                </div>
                <div class="card-body">
                    <form method="post" action="controllers/PICController.php">
                        <input type="hidden" name="id" value="<?= $edit_pic['id'] ?? '' ?>">
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   placeholder="Nama lengkap" required
                                   value="<?= htmlspecialchars($edit_pic['name']) ?>">
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">No. Telpon</label>
                            <input type="tel" class="form-control" id="phone" name="phone" 
                                  placeholder="Nomor telepon" required
                                  value="<?= htmlspecialchars($edit_pic['phone'] ?? '') ?>">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   placeholder="Alamat email" required
                                   value="<?= htmlspecialchars($edit_pic['email']) ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="status" name="status" 
                                       value="on" <?= ($edit_pic['status'] == 'on') ? 'checked' : '' ?>>
                                <label class="form-check-label" for="status">
                                    <?= ($edit_pic['status'] == 'on') ? 'Aktif' : 'Non-Aktif' ?>
                                </label>
                            </div>
                            <small class="text-muted">Hanya satu PIC yang bisa aktif pada satu waktu</small>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="pic.php" class="btn btn-secondary">Cancel</a>
                            <button type="submit" name="<?= isset($edit_pic['id']) ? 'update_pic' : 'add_pic' ?>" 
                                    class="btn btn-<?= isset($edit_pic['id']) ? 'success' : 'primary' ?> me-md-2">
                                <i class="fas fa-save"></i> <?= isset($edit_pic['id']) ? 'Update' : 'Save' ?>
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