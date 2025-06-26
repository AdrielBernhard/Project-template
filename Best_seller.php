<?php
include 'db.php';

// Query to get top 10 most used items
$query = "
    SELECT 
        i.id,
        i.ref_no,
        i.name AS item_name,
        SUM(ii.jumlah) AS total_quantity,
        COUNT(DISTINCT ii.invoice_id) AS invoice_count
    FROM 
        invoice_items ii
    JOIN 
        items i ON ii.item_id = i.id
    GROUP BY 
        i.id, i.ref_no, i.name
    ORDER BY 
        total_quantity DESC
    LIMIT 10
";

$result = $conn->query($query);
?>

<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Top Items Report</title>
    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="Top Items Report" />
    <meta name="author" content="Your Name" />
    <meta
      name="description"
      content="Top 10 most used items report"
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
                        <div class="col-sm-6"><h3 class="mb-0">Best Seller</h3></div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item active">Top Items</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="app-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <!-- Report Card -->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Top 10 Items by Usage Quantity</h3>
                                    <div class="card-tools">
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Item Reference</th>
                                                    <th>Item Name</th>
                                                    <th>Total Quantity</th>
                                                    <th>Used in Invoices</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if ($result->num_rows > 0): ?>
                                                    <?php $counter = 1; ?>
                                                    <?php while ($row = $result->fetch_assoc()): ?>
                                                        <tr class="align-middle">
                                                            <td><?= $counter++ ?></td>
                                                            <td><?= htmlspecialchars($row['ref_no']) ?></td>
                                                            <td><?= htmlspecialchars($row['item_name']) ?></td>
                                                            <td><?= number_format($row['total_quantity'], 0) ?></td>
                                                            <td><?= number_format($row['invoice_count'], 0) ?></td>
                                                        </tr>
                                                    <?php endwhile; ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="6" class="text-center">No items found</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <small class="text-muted">Report generated on <?= date('Y-m-d H:i:s') ?></small>
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