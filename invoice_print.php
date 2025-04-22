<?php
include 'db.php'; // Sesuaikan kalau koneksi di tempat lain

// Ambil ID invoice dari URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Query invoice dan customer
$sql_invoice = mysqli_query($conn, "SELECT invoice.*, customers.name as customer_name 
FROM invoice 
INNER JOIN customers ON invoice.customer_id = customers.id
WHERE invoice.id = '$id'");

if (!$sql_invoice) {
    die('Error Query Invoice: ' . mysqli_error($conn));
}

$invoice = mysqli_fetch_assoc($sql_invoice);

// Query item detail
$sql_items = mysqli_query($conn, "SELECT invoice_items.*, items.name as item_name 
    FROM invoice_items 
    INNER JOIN items ON invoice_items.item_id = items.id 
    WHERE invoice_items.invoice_id = '$id'");

if (!$sql_items) {
    die('Error Query Items: ' . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Print Invoice</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    th, td {
      border: 1px solid #000;
      padding: 8px;
      text-align: center;
    }
    .no-border {
      border: none;
    }
  </style>
</head>
<body onload="window.print();">

  <h2 style="text-align: center;">INVOICE</h2>

  <table class="no-border">
    <tr>
      <td class="no-border" style="text-align: left;">
        <b>Kode Invoice:</b> <?= htmlspecialchars($invoice['invoice_name']); ?><br>
        <b>Tanggal:</b> <?= htmlspecialchars($invoice['tanggal']); ?><br>
        <b>Customer:</b> <?= htmlspecialchars($invoice['customer_name']); ?>
      </td>
    </tr>
  </table>

  <table>
    <thead>
      <tr>
        <th>Nama Barang</th>
        <th>Qty</th>
        <th>Harga</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
  <?php 
  $grand_total = 0;
  while($row = mysqli_fetch_assoc($sql_items)): 
      $grand_total += $row['total_harga'];
  ?>
  <tr>
    <td><?= htmlspecialchars($row['item_name']); ?></td>
    <td><?= $row['jumlah']; ?></td>
    <td><?= number_format($row['harga'], 0, ',', '.'); ?></td>
    <td><?= number_format($row['total_harga'], 0, ',', '.'); ?></td>
  </tr>
  <?php endwhile; ?>
</tbody>

    <tfoot>
      <tr>
        <td colspan="3" style="text-align: right;"><b>Total</b></td>
        <td><b><?= number_format($grand_total, 0, ',', '.'); ?></b></td>
      </tr>
    </tfoot>
  </table>

  <p style="text-align: center; margin-top: 50px;">
    Terima kasih atas pembelian Anda.
  </p>

</body>
</html>
