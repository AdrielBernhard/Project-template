<?php
include __DIR__ . '/../db.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Handle Add/Edit Invoice Detail
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['item_id'])) {
    $invoice_id = intval($_POST['invoice_id']);
    $item_id = intval($_POST['item_id']);
    $input_harga = isset($_POST['harga']) && $_POST['harga'] !== '' ? floatval($_POST['harga']) : null;
    $jumlah = intval($_POST['jumlah']);
    $id_item_invoice = $_POST['id_item_invoice'] ?? '';

    // Validate required fields
    if (empty($item_id) || empty($jumlah)) {
        header("Location: ../invoice_detail_form.php?error=required&invoice_id=$invoice_id&item_id=$item_id&harga=".urlencode($input_harga)."&jumlah=$jumlah");
        exit;
    }

    // Get price if not provided
    if (is_null($input_harga)) {
        $stmt = $conn->prepare("
            SELECT ic.harga 
            FROM item_customer ic
            JOIN invoice i ON ic.customer_id = i.customer_id
            WHERE ic.item_id = ? AND i.id = ?
            LIMIT 1
        ");
        $stmt->bind_param('ii', $item_id, $invoice_id);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($row = $res->fetch_assoc()) {
            $harga = (float) $row['harga'];
        } else {
            $stmt2 = $conn->prepare("SELECT price FROM items WHERE id = ? LIMIT 1");
            $stmt2->bind_param('i', $item_id);
            $stmt2->execute();
            $res2 = $stmt2->get_result();
            $harga = ($row2 = $res2->fetch_assoc()) ? (float) $row2['price'] : 0;
            $stmt2->close();
        }
        $stmt->close();
    } else {
        $harga = $input_harga;
    }

    $total_harga = $harga * $jumlah;

    // Save to database
    if ($id_item_invoice) {
        $stmt = $conn->prepare("UPDATE invoice_items SET item_id=?, harga=?, jumlah=?, total_harga=? WHERE id=?");
        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param('idiii', $item_id, $harga, $jumlah, $total_harga, $id_item_invoice);
    } else {
        $stmt = $conn->prepare("INSERT INTO invoice_items (invoice_id, item_id, harga, jumlah, total_harga) VALUES (?, ?, ?, ?, ?)");
        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param('iidii', $invoice_id, $item_id, $harga, $jumlah, $total_harga);
    }

    if ($stmt->execute()) {
        header("Location: ../invoice_detail.php?id=$invoice_id&success=" . ($id_item_invoice ? 'edit' : 'add'));
    } else {
        header("Location: ../invoice_detail_form.php?error=database&invoice_id=$invoice_id&item_id=$item_id&harga=".urlencode($harga)."&jumlah=$jumlah");
    }
    $stmt->close();
    exit;
}

// Handle Delete Invoice Item
if (isset($_GET['delete_item'])) {
    $delete_id = intval($_GET['delete_item']);
    $invoice_id = intval($_GET['invoice_id']);

    try {
        $stmt = $conn->prepare("DELETE FROM invoice_items WHERE id = ?");
        if ($stmt === false) throw new Exception("Prepare failed: " . $conn->error);
        $stmt->bind_param("i", $delete_id);
        
        if ($stmt->execute()) {
            header("Location: ../invoice_detail.php?id=$invoice_id&success=delete");
        } else {
            throw new Exception("Execute failed: " . $stmt->error);
        }
        $stmt->close();
    } catch (Exception $e) {
        header("Location: ../invoice_detail.php?id=$invoice_id&error=delete&message=" . urlencode($e->getMessage()));
    }
    exit;
}