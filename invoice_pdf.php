<?php
require 'vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

include 'db.php';

// Validate invoice ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid invoice ID");
}
$invoice_id = intval($_GET['id']);

// Get invoice details
$invoice_query = $conn->query("SELECT invoice.*, customers.name AS customer_name 
                             FROM invoice 
                             JOIN customers ON invoice.customer_id = customers.id
                             WHERE invoice.id = $invoice_id");

if (!$invoice_query || $invoice_query->num_rows == 0) {
    die("Invoice not found");
}
$invoice = $invoice_query->fetch_assoc();

// Get invoice items
$items_query = $conn->query("SELECT invoice_items.*, items.name AS item_name
                            FROM invoice_items
                            JOIN items ON invoice_items.item_id = items.id
                            WHERE invoice_items.invoice_id = $invoice_id");

// Calculate grand total
$grand_total = 0;
$items = [];
if ($items_query->num_rows > 0) {
    while ($row = $items_query->fetch_assoc()) {
        $grand_total += $row['total_harga'];
        $items[] = $row;
    }
}

$html = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice ' . htmlspecialchars($invoice['invoice_name']) . '</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .no-border { border: none; }
        h2 { text-align: center; text-decoration: underline; }
    </style>
</head>
<body>
    <h2>INVOICE</h2>

    <table class="no-border">
        <tr>
            <td class="no-border">
                <p><strong>Invoice No:</strong> ' . htmlspecialchars($invoice['invoice_name']) . '</p>
                <p><strong>Date:</strong> ' . htmlspecialchars($invoice['tanggal']) . '</p>
                <p><strong>Customer:</strong> ' . htmlspecialchars($invoice['customer_name']) . '</p>
            </td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th class="text-right">Price</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>';

foreach ($items as $item) {
    $html .= '
            <tr>
                <td>' . htmlspecialchars($item['item_name']) . '</td>
                <td class="text-right">Rp ' . number_format($item['harga'], 0, ',', '.') . '</td>
                <td class="text-right">' . $item['jumlah'] . '</td>
                <td class="text-right">Rp ' . number_format($item['total_harga'], 0, ',', '.') . '</td>
            </tr>';
}

$html .= '
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="text-right"><strong>Grand Total</strong></td>
                <td class="text-right"><strong>Rp ' . number_format($grand_total, 0, ',', '.') . '</strong></td>
            </tr>
        </tfoot>
    </table>

    <div style="margin-top: 50px; text-align: center;">
        <p>Thank you for your business!</p>
    </div>
</body>
</html>';

// Configure Dompdf
$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Force download the PDF
$dompdf->stream("invoice_" . $invoice['invoice_name'] . ".pdf", [
    'Attachment' => true
]);
?>