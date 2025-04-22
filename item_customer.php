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
          <li class="breadcrumb-item"><a href="item_customer.php">Item_Customer</a></li>
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
              
              <tbody>
              <!-- potongan kode dari bagian dalam <main> -->

<!--begin::App Content Header-->
<div class="app-content-header">
  <div class="container-fluid">
    <div class="row mb-3">
      <div class="col-sm-6"><h3 class="mb-0">Data Item Customer</h3></div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
        </ol>
      </div>  
    </div>

    <?php
    include 'db.php';

    // Data untuk dropdown
    $items = $conn->query("SELECT id, name FROM items")->fetch_all(MYSQLI_ASSOC);
    $customers = $conn->query("SELECT id, name FROM customers")->fetch_all(MYSQLI_ASSOC);

    // Mode edit
    $edit = null;
    if (isset($_GET['edit_id'])) {
        $stmt = $conn->prepare("SELECT * FROM item_customer WHERE id = ?");
        $stmt->bind_param("i", $_GET['edit_id']);
        $stmt->execute();
        $edit = $stmt->get_result()->fetch_assoc();
        $stmt->close();
    }

    // Tampilkan data item_customer
    $data = $conn->query("
        SELECT ic.id, i.name AS item_name, c.name AS customer_name, ic.harga
        FROM item_customer ic
        JOIN items i ON ic.item_id = i.id
        JOIN customers c ON ic.customer_id = c.id
        ORDER BY ic.id ASC
    ")->fetch_all(MYSQLI_ASSOC);

    $search = $_GET['search'] ?? '';
    $whereClause = '';
    
    if (!empty($search)) {
        $search = $conn->real_escape_string($search);
        $whereClause = "WHERE i.name LIKE '%$search%' OR c.name LIKE '%$search%'";
    }
    
    $data = $conn->query("
        SELECT ic.id, i.name AS item_name, c.name AS customer_name, ic.harga
        FROM item_customer ic
        JOIN items i ON ic.item_id = i.id
        JOIN customers c ON ic.customer_id = c.id
        $whereClause
        ORDER BY ic.id ASC
    ")->fetch_all(MYSQLI_ASSOC);
     
?>


<form method="GET" class="mb-3">
  <div class="input-group">
    <input type="text" name="search" class="form-control" placeholder="Cari item atau customer..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
    <button class="btn btn-primary" type="submit">Search</button>
    <a href="item_customer.php" class="btn btn-secondary">Reset</a>
  </div>
</form>


    <div class="row">
      <div class="col-lg-12">
        <div class="card mb-4">
          <div class="card-header"><strong><?= $edit ? 'Edit' : 'Tambah' ?> Data</strong></div>
          <div class="card-body">
            <form method="POST" action="controllers/ItemCustomerController.php">
              <input type="hidden" name="id" value="<?= $edit['id'] ?? '' ?>">

              <div class="mb-3">
                <label class="form-label">Item</label>
                <select name="item_id" class="form-control" required>
                  <option value="">- Pilih Item -</option>
                  <?php foreach ($items as $item): ?>
                    <option value="<?= $item['id'] ?>" <?= isset($edit['item_id']) && $edit['item_id'] == $item['id'] ? 'selected' : '' ?>>
                      <?= htmlspecialchars($item['name']) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="mb-3">
                <label class="form-label">Customer</label>
                <select name="customer_id" class="form-control" required>
                  <option value="">- Pilih Customer -</option>
                  <?php foreach ($customers as $customer): ?>
                    <option value="<?= $customer['id'] ?>" <?= isset($edit['customer_id']) && $edit['customer_id'] == $customer['id'] ? 'selected' : '' ?>>
                      <?= htmlspecialchars($customer['name']) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="mb-3">
                <label class="form-label">Harga</label>
                <input type="number" name="harga" class="form-control" required value="<?= $edit['harga'] ?? '' ?>">
              </div>

              <button type="submit" name="<?= $edit ? 'update' : 'add' ?>" class="btn btn-primary">
                <?= $edit ? 'Update' : 'Tambah' ?>
              </button>
              <?php if ($edit): ?>
                <a href="item_customer.php" class="btn btn-secondary ms-2">Batal</a>
              <?php endif; ?>
            </form>
          </div>
        </div>
      </div>

      <div class="col-lg-6">
          <div class="card-body table-responsive p-0">
            <table class="table table-striped align-middle">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Item</th>
                  <th>Customer</th>
                  <th>Harga</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($data as $row): ?>
                  <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['item_name']) ?></td>
                    <td><?= htmlspecialchars($row['customer_name']) ?></td>
                    <td><?= number_format($row['harga']) ?></td>
                    <td>
                      <a href="item_customer.php?edit_id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                      <a href="controllers/ItemCustomerController.php?delete=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

  </div>
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
