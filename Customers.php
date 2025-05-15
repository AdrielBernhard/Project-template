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
          <!--begin::Start Navbar Links-->
          <!-- Header -->
    
        <div class="container-fluid">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                        <i class="bi bi-list"></i>
                    </a>
                </li>
                <li class="nav-item d-none d-md-block"><a href="index.php" class="nav-link">Home</a></li>
                <li class="nav-item"><a href="items.php" class="nav-link">Items</a></li>
                <li class="nav-item"><a href="customers.php" class="nav-link">Customers</a></li>
                <li class="nav-item"><a href="suppliers.php" class="nav-link">Suppliers</a></li>
                <li class="nav-item"><a href="item_customer.php" class="nav-link">Item Customer</a></li>
                <li class="nav-item"><a href="invoice.php" class="nav-link">Invoice</a></li>
            </ul>
        </div>
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
        <!--end::Container-->
      </nav>
      <!--end::Header-->
      <!--begin::Sidebar-->
      <!-- Sidebar -->
  <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
      <a href="index.php" class="brand-link"><span class="brand-text fw-light">Wevelope</span></a>
    </div>
    <div class="sidebar-wrapper">
      <nav class="mt-2">
        <ul class="nav sidebar-menu flex-column">
          <li class="nav-item"><a href="index.php" class="nav-link"><i class="nav-icon bi bi-circle"></i><p>Home</p></a></li>
          <li class="nav-item"><a href="items.php" class="nav-link"><i class="nav-icon bi bi-circle"></i><p>Items</p></a></li>
          <li class="nav-item"><a href="customers.php" class="nav-link active"><i class="nav-icon bi bi-circle"></i><p>Customers</p></a></li>
          <li class="nav-item"><a href="suppliers.php" class="nav-link"><i class="nav-icon bi bi-circle"></i><p>Suppliers</p></a></li>
          <li class="nav-item"><a href="item_customer.php" class="nav-link"><i class="nav-icon bi bi-circle"></i><p>Item Customer</p></a></li>
          <li class="nav-item"><a href="invoice.php" class="nav-link"><i class="nav-icon bi bi-circle"></i><p>Invoice</p></a></li>
        </ul>
      </nav>
    </div>
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
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item"><a href="customers.php">Customers</a></li>
          <li class="breadcrumb-item active" aria-current="page"></li>
        </ol>
      </div>
    </div>
    <!--end::Row-->

    <!-- Search Card -->
    <div class="row">
      <div class="col-lg-12">
        <div class="card mb-4">
          <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
              <h3 class="card-title">Customers</h3>
            </div>
          </div>
          <div class="card-body">
            <?php if (isset($_GET['status'])): ?>
              <div class="alert alert-<?= $_GET['status'] == 'duplicate' ? 'danger' : 'success' ?> alert-dismissible fade show mb-3">
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
                  case 'duplicate':
                    echo 'REF_NO sudah digunakan. Gunakan yang lain.';
                    break;
                }
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            <?php endif; ?>

            <form method="GET" class="row g-3">
              <div class="col-md-8">
                <input type="text" name="search" class="form-control" 
                       placeholder="Cari berdasarkan nama atau ref no..." 
                       value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
              </div>
              <div class="col-md-4">
                <button type="submit" class="btn btn-primary me-2">
                  <i class="bi bi-search"></i> Search
                </button>
                <a href="customers.php" class="btn btn-secondary">
                  <i class="bi bi-arrow-clockwise"></i> Reset
                </a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Customers Table -->
<div class="row">
  <div class="col-lg-12">
    <div class="card mb-4">
      <div class="card-header d-flex justify-content-start align-items-center">
        <h1 class="card-title mx-4"><b>Tabel Customers</b></h1>
        <a href="Customers_form.php" class="btn btn-success float-end">
          <i class="fas fa-plus me-0"></i> Tambah Items
        </a>
      </div>
      <div class="card-body">
        <table class="table table-bordered">
          <thead>
            <tr class="align-middle">
              <th style="width: 10px">#</th>
              <th>REF_NO</th>
              <th>NAME</th>
              <th style="width: 170px">ACTION</th>
            </tr>
          </thead>
          <tbody>
            <?php
            include 'db.php';

            $keyword = isset($_GET['search']) ? trim($_GET['search']) : '';

            if ($keyword !== '') {
              $stmt = $conn->prepare("SELECT * FROM customers WHERE name LIKE ? OR ref_no LIKE ? ORDER BY id ASC");
              $like_keyword = '%' . $keyword . '%';
              $stmt->bind_param("ss", $like_keyword, $like_keyword);
              $stmt->execute();
              $result = $stmt->get_result();
            } else {
              $result = $conn->query("SELECT * FROM customers ORDER BY id ASC");
            }

            if ($result->num_rows === 0): ?>
              <tr class="align-middle">
                <td colspan="4" class="text-center">Tidak ada data customer</td>
              </tr>
            <?php else: 
              $counter = 1;
              while ($customer = $result->fetch_assoc()): ?>
                <tr class="align-middle">
                  <td><?= $counter++ ?></td>
                  <td><?= htmlspecialchars($customer['ref_no']) ?></td>
                  <td><?= htmlspecialchars($customer['name']) ?></td>
                  <td>
                    <div class="d-flex gap-2">
                      <a href="Customers_form.php?edit_id=<?= $customer['id'] ?>" class="btn btn-sm btn-warning">
                        <i class="bi bi-pencil"></i> Edit
                      </a>
                      <a href="controllers/CustomersController.php?delete_customer=<?= $customer['id'] ?>"
                        class="btn btn-sm btn-danger"
                        onclick="return confirm('Yakin ingin menghapus customer ini?')">
                        <i class="bi bi-trash"></i> Delete
                      </a>
                    </div>
                  </td>
                </tr>
              <?php endwhile;
            endif; ?>
          </tbody>
        </table>
      </div>
      <!-- /.card-body -->
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
  </div>
</div>
  </div>
  <!--end::Container-->
</div>
<!--end::App Content Header-->

      </main>
      <!--end::App Main-->
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