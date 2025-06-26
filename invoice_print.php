<?php
require __DIR__ . '/vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

// Database connection - menggunakan absolute path
include __DIR__ . '/db.php';

// Validate invoice ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid invoice ID");
}
$invoice_id = intval($_GET['id']);

// Fetch invoice data
$invoice_query = $conn->query("SELECT invoice.*, customers.name AS customer_name, 
                             customers.company_name AS customer_company, 
                             customers.company_address AS customer_address,
                             customers.city AS customer_city,
                             customers.country AS customer_country
                             FROM invoice 
                             JOIN customers ON invoice.customer_id = customers.id
                             WHERE invoice.id = $invoice_id");

if (!$invoice_query || $invoice_query->num_rows == 0) {
    die("Invoice not found");
}
$invoice = $invoice_query->fetch_assoc();

// Fetch invoice items
$items_query = $conn->query("SELECT invoice_items.*, items.name AS item_name
                            FROM invoice_items
                            JOIN items ON invoice_items.item_id = items.id
                            WHERE invoice_items.invoice_id = $invoice_id");

// Calculate totals
$grand_total = 0;
$items = [];
if ($items_query->num_rows > 0) {
    while ($row = $items_query->fetch_assoc()) {
        $grand_total += $row['total_harga'];
        $items[] = $row;
    }
}

// Fetch company settings
$company_query = $conn->query("SELECT * FROM company_settings LIMIT 1");
$company = $company_query->fetch_assoc();

// Fetch active PIC
$active_pic = $conn->query("SELECT * FROM pic WHERE status = 'on' LIMIT 1")->fetch_assoc();
$today = date('d F Y');

/**
 * Convert image to base64 using absolute path
 * @param string $path Path to image (relative or absolute)
 * @return string|false Base64 encoded image or false on failure
 */
function imageToBase64($path) {
    if (empty($path)) return false;
    
    // Convert relative path to absolute path
    if (!preg_match('/^\//', $path)) {
        $path = __DIR__ . '/' . ltrim($path, '/');
    }
    
    if (!file_exists($path)) {
        error_log("Image not found: " . $path);
        return false;
    }
    
    $mime_type = mime_content_type($path);
    if (strpos($mime_type, 'image/') !== 0) {
        error_log("Not an image file: " . $path);
        return false;
    }
    
    $image_data = file_get_contents($path);
    if ($image_data === false) {
        error_log("Failed to read image: " . $path);
        return false;
    }
    
    return 'data:' . $mime_type . ';base64,' . base64_encode($image_data);
}

// Convert images
$logoBase64 = imageToBase64($company['logo_path'] ?? '');
$signatureBase64 = imageToBase64($company['signature_path'] ?? '');

ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice <?= htmlspecialchars($invoice['invoice_name']) ?></title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 20px;
            line-height: 1.5;
            color: #333;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
        }
        .header-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .logo-container {
            border: 1px solid #ddd;
            padding: 10px;
            width: 150px;
            height: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f9f9f9;
        }
        .company-info-box {
            border: 1px solid #ddd;
            padding: 15px;
            width: calc(100% - 180px);
            background: #f9f9f9;
        }
        .invoice-title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin: 20px 0;
            color: #2c3e50;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th {
            background-color: #f2f2f2;
            text-align: left;
            padding: 10px;
            border: 1px solid #ddd;
        }
        td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .notes-section, .terms-section {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 20px;
            background: #f9f9f9;
        }
        .signature-section {
            text-align: right;
            margin-top: 50px;
        }
        .signature-container {
            border: 1px solid #ddd;
            width: 200px;
            height: 80px;
            margin: 0 auto 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f9f9f9;
        }
        .total-row {
            font-weight: bold;
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header Section -->
        <div class="header-section">
            <div class="logo-container">
                <?php if ($logoBase64): ?>
                    <img src="<?= $logoBase64 ?>" alt="Company Logo" style="max-height:80px;">
                <?php else: ?>
                    <div style="color:#999;">LOGO</div>
                <?php endif; ?>
            </div>
            
            <div class="company-info-box">
                <h3 style="margin-top:0;"><?= htmlspecialchars($company['company_name'] ?? 'Company Name') ?></h3>
                <p><?= htmlspecialchars($company['address'] ?? '123 Main Street') ?></p>
                <p><?= htmlspecialchars($company['city'] ?? 'City') ?>, <?= htmlspecialchars($company['province'] ?? 'State') ?> <?= htmlspecialchars($company['postal_code'] ?? 'ZIP') ?></p>
                <p>Tel: <?= htmlspecialchars($company['phone'] ?? '(123) 456-7890') ?> | Email: <?= htmlspecialchars($company['email'] ?? 'info@company.com') ?></p>
            </div>
        </div>

        <!-- Invoice Title -->
        <div class="invoice-title">INVOICE</div>
        
        <!-- Invoice Info -->
        <table>
            <tr>
                <td><strong>Invoice No:</strong> <?= htmlspecialchars($invoice['invoice_name']) ?></td>
                <td class="text-right"><strong>Date:</strong> <?= htmlspecialchars($invoice['tanggal']) ?></td>
            </tr>
        </table>

        <!-- Customer and PIC Info -->
        <table style="margin-bottom:30px;">
            <tr>
                <td style="width:50%;">
                    <h4 style="margin-bottom:5px;">BILL TO</h4>
                    <p><strong><?= htmlspecialchars($invoice['customer_name']) ?></strong></p>
                    <?php if (!empty($invoice['customer_company'])): ?>
                        <p><?= htmlspecialchars($invoice['customer_company']) ?></p>
                    <?php endif; ?>
                    <p><?= htmlspecialchars($invoice['customer_address']) ?></p>
                    <p><?= htmlspecialchars($invoice['customer_city']) ?>, <?= htmlspecialchars($invoice['customer_country']) ?></p>
                </td>
                
                <?php if ($active_pic): ?>
                <td style="width:50%;">
                    <h4 style="margin-bottom:5px;">CONTACT PERSON</h4>
                    <p><strong><?= htmlspecialchars($active_pic['name']) ?></strong></p>
                    <?php if (!empty($active_pic['position'])): ?>
                        <p><?= htmlspecialchars($active_pic['position']) ?></p>
                    <?php endif; ?>
                    <?php if (!empty($active_pic['phone'])): ?>
                        <p>Tel: <?= htmlspecialchars($active_pic['phone']) ?></p>
                    <?php endif; ?>
                    <?php if (!empty($active_pic['email'])): ?>
                        <p>Email: <?= htmlspecialchars($active_pic['email']) ?></p>
                    <?php endif; ?>
                </td>
                <?php endif; ?>
            </tr>
        </table>

        <!-- Items Table -->
        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th class="text-right">Unit Price</th>
                    <th class="text-right">Qty</th>
                    <th class="text-right">Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['item_name']) ?></td>
                    <td class="text-right">Rp <?= number_format($item['harga'], 0, ',', '.') ?></td>
                    <td class="text-right"><?= $item['jumlah'] ?></td>
                    <td class="text-right">Rp <?= number_format($item['total_harga'], 0, ',', '.') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td colspan="3" class="text-right"><strong>Total</strong></td>
                    <td class="text-right"><strong>Rp <?= number_format($grand_total, 0, ',', '.') ?></strong></td>
                </tr>
            </tfoot>
        </table>

        <!-- Notes -->
        <div class="notes-section">
            <h4 style="margin-top:0;">NOTES</h4>
            <p><?= !empty($invoice['note']) ? nl2br(htmlspecialchars($invoice['note'])) : 'Payment due within 14 days. Thank you for your business.' ?></p>
        </div>

        <!-- Terms -->
        <div class="terms-section">
            <h4 style="margin-top:0;">TERMS & CONDITIONS</h4>
            <p><?= !empty($invoice['terms_conditions']) 
                ? nl2br(htmlspecialchars($invoice['terms_conditions'])) 
                : '1. Payment is due within 14 days<br>
                   2. Late payments subject to 2% monthly interest<br>
                   3. Goods remain our property until paid in full' ?></p>
        </div>

        <!-- Signature -->
        <div class="signature-section">
            <div style="display:inline-block; text-align:center;">
                <p><?= htmlspecialchars($company['city'] ?? 'City') ?>, <?= $today ?></p>
                <div class="signature-container">
                    <?php if ($signatureBase64): ?>
                        <img src="<?= $signatureBase64 ?>" alt="Authorized Signature" style="max-height:70px;">
                    <?php else: ?>
                        <div style="color:#999;">SIGNATURE</div>
                    <?php endif; ?>
                </div>
                <p><?= htmlspecialchars($active_pic['name'] ?? 'Authorized Signature') ?></p>
                <p><?= htmlspecialchars($active_pic['position'] ?? 'Position') ?></p>
            </div>
        </div>
    </div>
</body>
</html>
<?php
$html = ob_get_clean();

// Configure Dompdf
$options = new Options();
$options->set('isRemoteEnabled', true);
$options->set('isHtml5ParserEnabled', true);
$options->set('isPhpEnabled', true);
$options->set('defaultFont', 'Helvetica');
$options->set('tempDir', sys_get_temp_dir());

$dompdf = new Dompdf($options);
$dompdf->setHttpContext(
    stream_context_create([
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        ]
    ])
);

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');

try {
    $dompdf->render();
    $dompdf->stream("invoice_{$invoice_id}.pdf", [
        'Attachment' => false,
        'compress' => true
    ]);
} catch (Exception $e) {
    die("Error generating PDF: " . $e->getMessage());
}
?>