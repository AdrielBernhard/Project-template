<?php
require 'vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

include 'db.php';

// Validate invoice ID
if (!isset($_GET['invoice_id']) || !is_numeric($_GET['invoice_id'])) {
    die("Invalid invoice ID");
}
$invoice_id = intval($_GET['invoice_id']);
$payment_amount = isset($_GET['amount']) ? floatval($_GET['amount']) : 0;
$payment_date = isset($_GET['payment_date']) ? $_GET['payment_date'] : date('d/m/Y');

// Get invoice details
$invoice_query = $conn->query("SELECT invoice.*, customers.name AS customer_name 
                             FROM invoice 
                             JOIN customers ON invoice.customer_id = customers.id
                             WHERE invoice.id = $invoice_id");

if (!$invoice_query || $invoice_query->num_rows == 0) {
    die("Invoice not found");
}
$invoice = $invoice_query->fetch_assoc();

// Use the provided payment amount or fallback to total_paid
$display_amount = $payment_amount > 0 ? $payment_amount : ($invoice['total_paid'] ?? 0);

// Create HTML content
$html = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kwitansi Pembayaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .kwitansi {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            border: 1px solid #000;
            padding: 20px;
            box-sizing: border-box;
        }
        .kwitansi h1 {
            text-align: center;
            margin-bottom: 30px;
            text-decoration: underline;
        }
        .kwitansi-item {
            margin-bottom: 15px;
        }
        .kwitansi-item p {
            margin: 5px 0;
        }
        .total {
            margin-top: 30px;
            text-align: right;
            font-weight: bold;
        }
        .footer {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }
        .signature {
            text-align: center;
            margin-top: 60px;
        }
        .signature-line {
            width: 200px;
            border-top: 1px solid #000;
            margin: 0 auto;
            padding-top: 5px;
        }
    </style>
</head>
<body>
    <div class="kwitansi">
        <h1>KWITANSI</h1>
        
        <div class="kwitansi-item">
            <p>Telah diterima dari: ' . htmlspecialchars($invoice['customer_name']) . '</p>
            <p>Uang sejumlah: Rp ' . number_format($display_amount, 0, ',', '.') . '</p>
            <p>Untuk Pembayaran: Invoice ' . htmlspecialchars($invoice['invoice_name']) . '</p>
        </div>
        
        <div class="total">
            <p>Rp ' . number_format($display_amount, 0, ',', '.') . '</p>
            <p>(' . terbilang($display_amount) . ' rupiah)</p>
        </div>
        
        <div class="footer">
            <p>Tanggal: ' . htmlspecialchars($payment_date) . '</p>
            <div class="signature-line"></div>
            <p>Tanda Tangan</p>
        </div>
    </div>
</body>
</html>';

// Setup Dompdf
$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);

$dompdf->loadHtml($html);
$dompdf->setPaper('A5', 'portrait');
$dompdf->render();

// Output the generated PDF
$dompdf->stream('kwitansi_pembayaran_' . $invoice['invoice_name'] . '.pdf', array("Attachment" => true));

// Fungsi untuk mengubah angka menjadi terbilang
function terbilang($angka) {
    $angka = abs($angka);
    $bilangan = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $terbilang = "";
    
    if ($angka < 12) {
        $terbilang = " " . $bilangan[$angka];
    } elseif ($angka < 20) {
        $terbilang = terbilang($angka - 10) . " belas";
    } elseif ($angka < 100) {
        $terbilang = terbilang($angka / 10) . " puluh" . terbilang($angka % 10);
    } elseif ($angka < 200) {
        $terbilang = " seratus" . terbilang($angka - 100);
    } elseif ($angka < 1000) {
        $terbilang = terbilang($angka / 100) . " ratus" . terbilang($angka % 100);
    } elseif ($angka < 2000) {
        $terbilang = " seribu" . terbilang($angka - 1000);
    } elseif ($angka < 1000000) {
        $terbilang = terbilang($angka / 1000) . " ribu" . terbilang($angka % 1000);
    } elseif ($angka < 1000000000) {
        $terbilang = terbilang($angka / 1000000) . " juta" . terbilang($angka % 1000000);
    }
    
    return $terbilang;
}
?>