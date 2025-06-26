<?php
include __DIR__ . '/../db.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session for CSRF protection
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verify CSRF token for POST requests
function verifyCsrfToken() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            http_response_code(403);
            die('Invalid CSRF token');
        }
    }
}

// Generate CSRF token
function generateCsrfToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Handle Add/Edit Invoice
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['item_id'])) {
    verifyCsrfToken();
    
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $invoice_name = trim($_POST['invoice_name'] ?? '');
    $customer_id = isset($_POST['customer_id']) ? (int)$_POST['customer_id'] : 0;
    $tanggal = $_POST['tanggal'] ?? '';
    $due_date = $_POST['due_date'] ?? '';
    $note = $_POST['note'] ?? '';
    $terms_conditions = $_POST['terms_conditions'] ?? '';
    
    // Validate required fields
    $errors = [];
    
    // Validate invoice name
    if (empty($invoice_name)) {
        $errors[] = 'invoice_name';
    }
    
    // Validate customer
    if (empty($customer_id)) {
        $errors[] = 'customer_id';
    }
    
    // Validate invoice date
    if (empty($tanggal)) {
        $errors[] = 'tanggal';
    } elseif (!DateTime::createFromFormat('Y-m-d', $tanggal)) {
        $errors[] = 'tanggal_format';
    }
    
    // Validate due date with fallback to 7 days from invoice date
    if (empty($due_date)) {
        // If empty, set to 7 days from invoice date if available, or 7 days from today
        $due_date = !empty($tanggal) ? date('Y-m-d', strtotime($tanggal . ' +7 days')) 
                    : date('Y-m-d', strtotime('+7 days'));
    } elseif (!DateTime::createFromFormat('Y-m-d', $due_date)) {
        $errors[] = 'due_date_format';
    }
    
    if (!empty($errors)) {
        $errorParams = implode(',', $errors);
        header("Location: ../invoice_form.php?error=validation&fields=$errorParams&id=$id");
        exit;
    }

    // Check for duplicate invoice name
    $stmt = $conn->prepare("SELECT id FROM invoice WHERE invoice_name = ? AND id != ?");
    $stmt->bind_param('si', $invoice_name, $id);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        header("Location: ../invoice_form.php?error=duplicate&id=$id");
        exit;
    }

    // Start transaction
    $conn->begin_transaction();
    
    try {
        // Save to database
        if ($id) {
            $stmt = $conn->prepare("UPDATE invoice SET 
                invoice_name=?, 
                customer_id=?, 
                tanggal=?, 
                due_date=?,
                note=?,
                terms_conditions=?
                WHERE id=?");
            $stmt->bind_param('sissssi', $invoice_name, $customer_id, $tanggal, $due_date, $note, $terms_conditions, $id);
        } else {
            $stmt = $conn->prepare("INSERT INTO invoice 
                (invoice_name, customer_id, tanggal, due_date, note, terms_conditions) 
                VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param('sissss', $invoice_name, $customer_id, $tanggal, $due_date, $note, $terms_conditions);
        }

        if (!$stmt->execute()) {
            throw new Exception("Database error: " . $stmt->error);
        }
        
        $conn->commit();
        header("Location: ../invoice.php?success=" . ($id ? 'edit' : 'add'));
    } catch (Exception $e) {
        $conn->rollback();
        error_log("Invoice save error: " . $e->getMessage());
        header("Location: ../invoice_form.php?error=database&id=$id");
    }
    exit;
}

// Handle Delete Invoice
if (isset($_GET['delete'])) {
    verifyCsrfToken();
    
    $delete_id = (int)$_GET['delete'];
    $conn->begin_transaction();

    try {
        // Delete invoice items first
        $stmt = $conn->prepare("DELETE FROM invoice_items WHERE invoice_id = ?");
        if ($stmt === false) throw new Exception("Prepare failed: " . $conn->error);
        $stmt->bind_param("i", $delete_id);
        if (!$stmt->execute()) throw new Exception("Execute failed: " . $stmt->error);
        $stmt->close();

        // Then delete invoice
        $stmt = $conn->prepare("DELETE FROM invoice WHERE id = ?");
        if ($stmt === false) throw new Exception("Prepare failed: " . $conn->error);
        $stmt->bind_param("i", $delete_id);
        if (!$stmt->execute()) throw new Exception("Execute failed: " . $stmt->error);
        $stmt->close();

        $conn->commit();
        header("Location: ../invoice.php?success=delete");
    } catch (Exception $e) {
        $conn->rollback();
        error_log("Invoice delete error: " . $e->getMessage());
        header("Location: ../invoice.php?error=delete&message=" . urlencode($e->getMessage()));
    }
    exit;
}