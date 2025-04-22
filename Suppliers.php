<!doctype html>
<html lang="en">
  <!--begin::Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Customers</title>
    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="Customers" />
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
    <!-- apexcharts -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css"
      integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0="
      crossorigin="anonymous"
    />
  </head>
  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
      <!--begin::Header-->
      <nav class="app-header navbar navbar-expand bg-body">
        <!--begin::Container-->
        <div class="container-fluid">
          <!--begin::Start Navbar Links-->
          <ul class="navbar-nav">
          <a href="index3.html" class="nav-link"><i></i> Home</a></li>
          <li class="nav-item"><a href="items.php" class="nav-link"><i></i> Items</a></li>
          <li class="nav-item"><a href="customers.php" class="nav-link"><i></i> Customers</a></li>
          <li class="nav-item"><a href="suppliers.php" class="nav-link"><i></i> Suppliers</a></li>
          <li class="nav-item"><a href="item_customer.php" class="nav-link"><i></i> Item Customer</a></li>
          <li class="nav-item"><a href="invoice.php" class="nav-link active"><i></i> Invoice</a></li>             
          </ul>
          <!--end::Start Navbar Links-->
          <!--begin::End Navbar Links-->
          <ul class="navbar-nav ms-auto">
            <!--begin::Navbar Search-->
            
            <!--end::Navbar Search-->
            <!--begin::Messages Dropdown Menu-->
            
            <!--begin::Fullscreen Toggle-->
            <li class="nav-item">
              <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
              </a>
            </li>
            <!--end::Fullscreen Toggle-->
            <!--begin::User Menu Dropdown-->
            
            <!--end::User Menu Dropdown-->
          </ul>
          <!--end::End Navbar Links-->
        </div>
        <!--end::Container-->
      </nav>
      <!--end::Header-->
      <!--begin::Sidebar-->
      <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <!--begin::Sidebar Brand-->
        <div class="sidebar-brand">
          <!--begin::Brand Link-->
          <a href="./index.html" class="brand-link">
            <!--begin::Brand Text-->
            <span class="brand-text fw-light"><a href="index3.html">Wevelope</a></span>
            <!--end::Brand Text-->
          </a>
          <!--end::Brand Link-->
        </div>
        <!--end::Sidebar Brand-->
        <!--begin::Sidebar Wrapper-->
        <div class="sidebar-wrapper">
          <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul
              class="nav sidebar-menu flex-column"
              data-lte-toggle="treeview"
              role="menu"
              data-accordion="false"
            >
              <li class="nav-item menu-open">
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="./index3.html" class="nav-link active">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Home</p>
                    </a>
                  </li>
                </ul>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="items.php" class="nav-link active">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Items</p>
                    </a>
                  </li>
                </ul>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="customers.php" class="nav-link active">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Customers</p>
                    </a>
                  </li>
                </ul>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="Suppliers.php" class="nav-link active">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Suppliers</p>
                    </a>
                  </li>
                </ul>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="item_customer.php" class="nav-link active">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>item_customer</p>
                    </a>
                  </li>
                </ul>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="Invoice.php" class="nav-link active">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Invoice</p>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
            <!--end::Sidebar Menu-->
          </nav>
        </div>
        <!--end::Sidebar Wrapper-->
      </aside>
      <!--end::Sidebar-->
      <!--begin::App Main-->
      <main class="app-main">
        <!--begin::App Content Header-->
<div class="app-content-header">
  <!--begin::Container-->
  <div class="container-fluid">
    <!--begin::Row-->
    <div class="row mb-3">
      <div class="col-sm-6"><h3 class="mb-0">Dashboard</h3></div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
          <li class="breadcrumb-item"><a href="index3.html">Home</a></li>
          <li class="breadcrumb-item"><a href="customers.php">Suppliers</a></li>
          <li class="breadcrumb-item active" aria-current="page"></li>
        </ol>
      </div>
    </div>
    <!--end::Row-->

    <!-- TABEL ITEMS -->
    <div class="row">
      <div class="col-lg-12">
        <div class="card mb-4">
          <div class="card-header border-0">
            <h3 class="card-title">Items</h3>
          </div>
          <div class="card-body table-responsive p-0">
            <table class="table table-striped align-middle">
              <thead>
                <tr>
                  <th>REF_NO</th>
                  <th>NAME</th>
                  <th>ACTION</th>
                </tr>
              </thead>
              <tbody>


              
              <?php
include 'db.php';

define('BASE_URL', '/Random/'); // Ganti sesuai folder kamu

// Ambil supplier untuk edit (jika ada)
$edit_supplier = null;
if (isset($_GET['edit_id'])) {
  $edit_id = intval($_GET['edit_id']);
  $stmt = $conn->prepare("SELECT * FROM suppliers WHERE id = ?");
  $stmt->bind_param("i", $edit_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $edit_supplier = $result->fetch_assoc();
  $stmt->close();
}

// Ambil semua suppliers (dengan pencarian jika ada)
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$suppliers = [];

if (!empty($search)) {
  $sql = "SELECT * FROM suppliers WHERE name LIKE ? OR ref_no LIKE ? ORDER BY id ASC";
  $stmt = $conn->prepare($sql);
  $like = "%$search%";
  $stmt->bind_param("ss", $like, $like);
  $stmt->execute();
  $result = $stmt->get_result();
} else {
  $result = $conn->query("SELECT * FROM suppliers ORDER BY id ASC");
}

while ($row = $result->fetch_assoc()) {
  $suppliers[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Suppliers Table</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<?php if (isset($_GET['status'])): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <?php
    switch ($_GET['status']) {
      case 'added':
        echo 'Customer berhasil ditambahkan.';
        break;
      case 'updated':
        echo 'Customer berhasil diperbarui.';
        break;
      case 'deleted':
        echo 'Customer berhasil dihapus.';
        break;
    }
    ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<form method="GET" class="mb-3">
  <div class="input-group">
    <input type="text" name="search" class="form-control" placeholder="Cari nama atau ref no..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
    <button class="btn btn-primary" type="submit">Search</button>
    <a href="<?= BASE_URL ?>Suppliers.php" class="btn btn-secondary">Reset</a>
  </div>
</form>


<?php if (isset($_GET['status']) && $_GET['status'] == 'duplicate'): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    REF_NO sudah digunakan. Harap gunakan yang lain.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<div class="container">
  <h2 class="mb-4"><?= $edit_supplier ? 'Edit Supplier' : 'Tambah Supplier' ?></h2>

  <form method="post" action="controllers/SuppliersController.php">

    <input type="hidden" name="id" value="<?= $edit_supplier['id'] ?? '' ?>">
    <div class="mb-3">
      <input type="text" name="ref_no" class="form-control mb-2" placeholder="REF_NO" required
             value="<?= $edit_supplier['ref_no'] ?? '' ?>">
      <input type="text" name="name" class="form-control mb-2" placeholder="NAME" required
             value="<?= $edit_supplier['name'] ?? '' ?>">
      <button type="submit" name="<?= $edit_supplier ? 'update_supplier' : 'add_supplier' ?>" class="btn btn-<?= $edit_supplier ? 'success' : 'primary' ?>">
        <?= $edit_supplier ? 'Update' : 'Tambah' ?>
      </button>
      <?php if ($edit_supplier): ?>
        <a href="<?= BASE_URL ?>suppliers.php" class="btn btn-secondary ms-2">Batal</a>
      <?php endif; ?>
    </div>
  </form>

        <tbody>
          <?php foreach ($suppliers as $supplier): ?>
          <tr>
            <td><?= htmlspecialchars($supplier['ref_no']) ?></td>
            <td><?= htmlspecialchars($supplier['name']) ?></td>
            <td>
              <a href="<?= BASE_URL ?>suppliers.php?edit_id=<?= $supplier['id'] ?>" class="btn btn-sm btn-warning me-1">Edit</a>
              <a href="controllers/SuppliersController.php?delete_supplier=<?= $supplier['id'] ?>"
   class="btn btn-sm btn-danger"
   onclick="return confirm('Yakin ingin menghapus supplier ini?')">Delete</a>

            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <!-- END TABEL ITEMS -->
    
  </div>
  <!--end::Container-->
</div>
<!--end::App Content Header-->

        
        
      </main>
      <!--end::App Main-->
      <!--begin::Footer-->
      <footer class="app-footer">
        <!--begin::To the end-->
        <div class="float-end d-none d-sm-inline">This is the homepage</div>
        <!--end::To the end-->
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
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <script
      src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js"
      integrity="sha256-dghWARbRe2eLlIJ56wNB+b760ywulqK3DzZYEpsg2fQ="
      crossorigin="anonymous"
    ></script>
    <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
      crossorigin="anonymous"
    ></script>
    <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
      integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
      crossorigin="anonymous"
    ></script>
    <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
    <script src="adminlte.js"></script>
    <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
    <script>
      const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
      const Default = {
        scrollbarTheme: 'os-theme-light',
        scrollbarAutoHide: 'leave',
        scrollbarClickScroll: true,
      };
      document.addEventListener('DOMContentLoaded', function () {
        const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
        if (sidebarWrapper && typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== 'undefined') {
          OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
            scrollbars: {
              theme: Default.scrollbarTheme,
              autoHide: Default.scrollbarAutoHide,
              clickScroll: Default.scrollbarClickScroll,
            },
          });
        }
      });
    </script>
    <!--end::OverlayScrollbars Configure-->
    <!-- OPTIONAL SCRIPTS -->
    <!-- apexcharts -->
    <script
      src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js"
      integrity="sha256-+vh8GkaU7C9/wbSLIcwq82tQ2wTf44aOHA8HlBMwRI8="
      crossorigin="anonymous"
    ></script>
    <!--end::Script-->
  </body>
  <!--end::Body-->
</html>
