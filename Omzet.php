<?php
include 'db.php';

// Query untuk ringkasan harian
$current_date = date('Y-m-d');
$query_daily = "
    SELECT 
        SUM(ii.total_harga) AS daily_revenue,
        COUNT(DISTINCT i.id) AS invoice_count
    FROM 
        invoice i
    JOIN 
        invoice_items ii ON i.id = ii.invoice_id
    WHERE 
        DATE(i.tanggal) = ?
";

$stmt_daily = $conn->prepare($query_daily);
$stmt_daily->bind_param("s", $current_date);
$stmt_daily->execute();
$daily_result = $stmt_daily->get_result();
$daily_data = $daily_result->fetch_assoc();

// Query untuk ringkasan mingguan
$current_week = date('W');
$query_weekly = "
    SELECT 
        SUM(ii.total_harga) AS weekly_revenue,
        COUNT(DISTINCT i.id) AS weekly_invoice_count
    FROM 
        invoice i
    JOIN 
        invoice_items ii ON i.id = ii.invoice_id
    WHERE 
        WEEK(i.tanggal) = WEEK(CURDATE())
    AND 
        YEAR(i.tanggal) = YEAR(CURDATE())
";

$weekly_result = $conn->query($query_weekly);
$weekly_data = $weekly_result->fetch_assoc();

// Query untuk ringkasan bulanan
$current_month = date('m');
$query_monthly = "
    SELECT 
        SUM(ii.total_harga) AS monthly_revenue,
        COUNT(DISTINCT i.id) AS monthly_invoice_count
    FROM 
        invoice i
    JOIN 
        invoice_items ii ON i.id = ii.invoice_id
    WHERE 
        MONTH(i.tanggal) = MONTH(CURDATE())
    AND 
        YEAR(i.tanggal) = YEAR(CURDATE())
";

$monthly_result = $conn->query($query_monthly);
$monthly_data = $monthly_result->fetch_assoc();
?>

<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Daily Revenue Report</title>
    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="Daily Revenue Report" />
    <meta name="author" content="Your Name" />
    <meta
      name="description"
      content="Daily revenue report showing total income per day"
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
    <style>
        .summary-card {
            transition: all 0.3s;
            border-left: 4px solid;
        }
        .daily-card {
            border-left-color: #0d6efd;
        }
        .weekly-card {
            border-left-color: #0dcaf0;
        }
        .monthly-card {
            border-left-color: #198754;
        }
    </style>
</head>
<body class="layout-fixed sidebar-expand-lg sidebar-mini sidebar-collapse bg-body-tertiary">
    <div class="app-wrapper">
        <?php include 'sidebar-navbar.html'; ?>

        <main class="app-main">
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Revenue Dashboard</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="app-content">
                <div class="container-fluid">
                   <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card daily-card summary-card">
                                <div class="card-header">
                                    <h3 class="card-title">Omzet Harian (<?= $current_date ?>)</h3>
                                    <div class="card-tools">
                                        <a href="daily_detail.php" class="btn me-2 btn-primary">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="p-3 text-center">
                                                <h5>Total Invoices</h5>
                                                <h2 class="text-primary"><?= $daily_data['invoice_count'] ?? 0 ?></h2>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="p-3 text-center">
                                                <h5>Total Omzet</h5>
                                                <h2 class="text-success"><?= isset($daily_data['daily_revenue']) ? number_format($daily_data['daily_revenue'], 2) : '0.00' ?></h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ringkasan Mingguan dan Bulanan -->
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="card weekly-card summary-card h-100">
                                <div class="card-header">
                                    <h3 class="card-title">Omzet Mingguan (Week <?= $current_week ?>)</h3>
                                    <div class="card-tools">
                                        <a href="weekly_detail.php" class="btn me-2 btn-info">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="p-3 text-center">
                                                <h5>Total Invoices</h5>
                                                <h3 class="text-primary"><?= $weekly_data['weekly_invoice_count'] ?? 0 ?></h3>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="p-3 text-center">
                                                <h5>Total Omzet</h5>
                                                <h3 class="text-success"><?= isset($weekly_data['weekly_revenue']) ? number_format($weekly_data['weekly_revenue'], 2) : '0.00' ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <div class="card monthly-card summary-card h-100">
                                <div class="card-header">
                                    <h3 class="card-title">Omzet Bulanan (<?= date('F Y') ?>)</h3>
                                    <div class="card-tools">
                                        <a href="monthly_detail.php" class="btn me-2 btn-success">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="p-3 text-center">
                                                <h5>Total Invoices</h5>
                                                <h3 class="text-primary"><?= $monthly_data['monthly_invoice_count'] ?? 0 ?></h3>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="p-3 text-center">
                                                <h5>Total Omzet</h5>
                                                <h3 class="text-success"><?= isset($monthly_data['monthly_revenue']) ? number_format($monthly_data['monthly_revenue'], 2) : '0.00' ?></h3>
                                            </div>
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