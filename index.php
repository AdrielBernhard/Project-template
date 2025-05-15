<?php
include 'db.php';

$item_customer_count_query = "SELECT COUNT(*) AS total FROM item_customer";
$item_customer_result = mysqli_query($conn, $item_customer_count_query);
if ($item_customer_result) {
 $item_customer_data = mysqli_fetch_assoc($item_customer_result);
 $item_customer_count = $item_customer_data['total'] ?? 0;
} else {
 $item_customer_count = 0;
 echo "Error: " . mysqli_error($conn) . "<br>";
}

// Jumlah items
$item_count_query = "SELECT COUNT(*) AS total FROM items";
$item_result = mysqli_query($conn, $item_count_query);
if ($item_result) { // Periksa apakah query berhasil
    $item_data = mysqli_fetch_assoc($item_result);
    $item_count = $item_data['total'] ?? 0;
} else {
    $item_count = 0;
    echo "Error: " . mysqli_error($conn) . "<br>"; // Tampilkan error jika ada
}

// Jumlah customers
$customer_count_query = "SELECT COUNT(*) AS total FROM customers";
$customer_result = mysqli_query($conn, $customer_count_query);
if ($customer_result) {
    $customer_data = mysqli_fetch_assoc($customer_result);
    $customer_count = $customer_data['total'] ?? 0;
} else {
    $customer_count = 0;
    echo "Error: " . mysqli_error($conn) . "<br>";
}

// Jumlah suppliers
$supplier_count_query = "SELECT COUNT(*) AS total FROM suppliers";
$supplier_result = mysqli_query($conn, $supplier_count_query);
if ($supplier_result) {
    $supplier_data = mysqli_fetch_assoc($supplier_result);
    $supplier_count = $supplier_data['total'] ?? 0;
} else {
    $supplier_count = 0;
    echo "Error: " . mysqli_error($conn) . "<br>";
}

// Jumlah invoices
$invoice_count_query = "SELECT COUNT(*) AS total FROM invoice"; // Perhatikan nama tabelnya!
$invoice_result = mysqli_query($conn, $invoice_count_query);
if ($invoice_result) {
    $invoice_data = mysqli_fetch_assoc($invoice_result);
    $invoice_count = $invoice_data['total'] ?? 0;
} else {
    $invoice_count = 0;
    echo "Error: " . mysqli_error($conn) . "<br>";
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
              <div class="col-sm-6"><h3 class="mb-0">Dashboard</h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="index.php">Home</a></li>
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
              <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
                            <div class="small-box text-bg-primary">
                                <div class="inner">
                                    <h3><?= number_format($item_count) ?></h3>
                                    <p>Items</p>
                                </div>
                                <a href="items.php" class="small-box-footer text-white text-decoration-none">
                                    More info <i class="bi bi-link-45deg"></i>
                                    <span class="visually-hidden">about items</span>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
                            <div class="small-box text-bg-success">
                                <div class="inner">
                                    <h3><?= number_format($customer_count) ?></h3>
                                    <p>Customers</p>
                                </div>
                                <a href="customers.php" class="small-box-footer text-white text-decoration-none">
                                    More info <i class="bi bi-link-45deg"></i>
                                    <span class="visually-hidden">about customers</span>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
                            <div class="small-box text-bg-warning">
                                <div class="inner">
                                    <h3><?= number_format($supplier_count) ?></h3>
                                    <p>Suppliers</p>
                                </div>
                                <a href="suppliers.php" class="small-box-footer text-white text-decoration-none">
                                    More info <i class="bi bi-link-45deg"></i>
                                    <span class="visually-hidden">about suppliers</span>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
                            <div class="small-box text-bg-secondary">
                                <div class="inner">
                                    <h3><?= number_format($item_customer_count) ?></h3>
                                    <p>Item Customer</p>
                                </div>
                                <a href="item_customer.php" class="small-box-footer text-white text-decoration-none">
                                    More info <i class="bi bi-link-45deg"></i>
                                    <span class="visually-hidden">about item_customer</span>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
                            <div class="small-box text-bg-danger">
                                <div class="inner">
                                    <h3><?= number_format($invoice_count) ?></h3>
                                    <p>Invoices</p>
                                </div>
                                <a href="invoice.php" class="small-box-footer text-white text-decoration-none">
                                    More info <i class="bi bi-link-45deg"></i>
                                    <span class="visually-hidden">about invoices</span>
                                </a>
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
    <script src="../../../dist/js/adminlte.js"></script>
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
    <!--end::Script-->
  </body>
  <!--end::Body-->
</html>
