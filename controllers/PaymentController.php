<?php
include '../db.php';

// Handle payment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $invoice_id = intval($_POST['invoice_id']);
    $amount = floatval($_POST['amount']);
    $payment_date = $_POST['payment_date'];
    
    // Validate input
    if (empty($invoice_id) || empty($amount) || empty($payment_date)) {
        header("Location: ../pembayaran_form.php?error=required&invoice_id=$invoice_id");
        exit;
    }
    
    // Get invoice details
    $stmt = $conn->prepare("SELECT 
                           (SELECT SUM(total_harga) FROM invoice_items WHERE invoice_id = ?) AS total_amount,
                           total_paid 
                           FROM invoice WHERE id = ?");
    $stmt->bind_param("ii", $invoice_id, $invoice_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $invoice = $result->fetch_assoc();
    
    // Validate amount
    $remaining = $invoice['total_amount'] - $invoice['total_paid'];
    if ($amount <= 0) {
        header("Location: ../pembayaran_form.php?error=invalid_amount&invoice_id=$invoice_id");
        exit;
    }
    
    if ($amount > $remaining) {
        header("Location: ../pembayaran_form.php?error=exceed&invoice_id=$invoice_id");
        exit;
    }
    
    // Start transaction
    $conn->begin_transaction();
    
    try {
        // Record payment
        $stmt = $conn->prepare("INSERT INTO invoice_payments (invoice_id, payment_date, amount) VALUES (?, ?, ?)");
        $stmt->bind_param("isd", $invoice_id, $payment_date, $amount);
        $stmt->execute();
        
        // Update invoice
        $new_total_paid = $invoice['total_paid'] + $amount;
        $status = ($new_total_paid >= $invoice['total_amount']) ? 'paid' : 'partial';
        
        $stmt = $conn->prepare("UPDATE invoice SET total_paid = ?, status = ? WHERE id = ?");
        $stmt->bind_param("dsi", $new_total_paid, $status, $invoice_id);
        $stmt->execute();
        
        $conn->commit();
        header("Location: ../invoice_detail.php?id=$invoice_id&success=Pembayaran berhasil dicatat");
        exit;
    } catch (Exception $e) {
        $conn->rollback();
        header("Location: ../pembayaran_form.php?error=database&invoice_id=$invoice_id");
        exit;
    }
}