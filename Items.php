<?php
include 'db.php';

define('BASE_URL', '/Random/'); // Ubah sesuai nama folder kamu di localhost

// Search functionality
$keyword = isset($_GET['search']) ? trim($_GET['search']) : '';
$items = [];

if ($keyword !== '') {
    $stmt = $conn->prepare("SELECT * FROM items WHERE name LIKE ? OR ref_no LIKE ? ORDER BY id ASC");
    $like_keyword = '%' . $keyword . '%';
    $stmt->bind_param("ss", $like_keyword, $like_keyword);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT * FROM items ORDER BY id ASC");
}

while ($row = $result->fetch_assoc()) {
    $items[] = $row;
}

// Ambil item untuk edit (jika ada)
$edit_item = null;
if (isset($_GET['edit_id'])) {
    $edit_id = intval($_GET['edit_id']);
    $stmt = $conn->prepare("SELECT * FROM items WHERE id = ?");
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $edit_item = $result->fetch_assoc();
    $stmt->close();
}

$keyword = isset($_GET['search']) ? trim($_GET['search']) : '';

if ($keyword !== '') {
    $stmt = $conn->prepare("SELECT * FROM items WHERE name LIKE ? OR ref_no LIKE ? ORDER BY id ASC");
    $like_keyword = '%' . $keyword . '%';
    $stmt->bind_param("ss", $like_keyword, $like_keyword);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT * FROM items ORDER BY id ASC");
}

$items = [];
while ($row = $result->fetch_assoc()) {
    $items[] = $row;
}
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
              <div class="col-sm-6"><h3 class="mb-0">Items</h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page"><a href="Items.php">Items</a></li>
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
                
                <!-- Status Messages -->  
                <?php if (isset($_GET['status'])): ?>
                    <div class="alert alert-<?= $_GET['status'] == 'duplicate' ? 'danger' : 'success' ?> alert-dismissible fade show">
                        <?php
                        $messages = [
                            'added' => 'Item berhasil ditambah.',
                            'updated' => 'Item berhasil diudate.',
                            'deleted' => 'Item berhasil dihapus.',
                            'duplicate' => 'Reference number sudah ada. Pakai reference number yang berbeda.'
                        ];
                        echo $messages[$_GET['status']] ?? '';
                        ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Default box -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Search Items</h3>
                    </div>
                    <div class="card-body">
                        <form method="GET" class="row g-3">
                            <div class="col-md-8">
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Cari berdasarkan nama atau ref no..." 
                                       value="<?= htmlspecialchars($keyword) ?>">
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="fas fa-search"></i> Search
                                </button>
                                <a href="Items.php" class="btn btn-secondary">
                                    <i class="fas fa-sync-alt"></i> Reset
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Items Table -->
                <div class="card mb-4">
                <div class="card-header d-flex align-items-center">
                <h3 class="card-title me-4 mb-0">Tabel Items</h3>
                <a href="Items_form.php" class="btn btn-success float-end">
                  <i class="fas fa-plus me-0"></i> Tambah Items
                </a>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr class="align-middle">
                    <th style="width: 10px">#</th>
                    <th>Ref_No</th>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th style="width: 170px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($items)): ?>
                    <tr class="align-middle">
                        <td colspan="5" class="text-center">tidak ada item ysng ditemukan</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($items as $index => $item): ?>
                        <tr class="align-middle">
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($item['ref_no']) ?></td>
                            <td><?= htmlspecialchars($item['name']) ?></td>
                            <td>Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                            <td>
                            <div class="d-flex gap-2">
                                    <a href="Items_form.php?edit_id=<?= $item['id'] ?>" 
                                       class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit me-1"></i> Edit
                                    </a>
                                    <a href="controllers/ItemController.php?delete_item=<?= $item['id'] ?>" 
                                       class="btn btn-sm btn-danger" 
                                       onclick="return confirm('Yakin ingin menghapus customer ini?')">
                                        <i class="fas fa-trash-alt me-1"></i> Delete
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
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
  <!--end::Body-->
</html>
