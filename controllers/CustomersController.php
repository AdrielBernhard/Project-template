<?php
include __DIR__ . '/../db.php';

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Add customer
if (isset($_POST['add_customer'])) {
    $ref_no = trim($_POST['ref_no']);
    $name = trim($_POST['name']);

    // Check for duplicate ref_no
    $stmt = $conn->prepare("SELECT id FROM customers WHERE ref_no = ?");
    $stmt->bind_param("s", $ref_no);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        header("Location: ../customers.php?status=duplicate");
        exit();
    }

    $stmt->close();

    // Insert data
    $stmt = $conn->prepare("INSERT INTO customers (ref_no, name) VALUES (?, ?)");
    $stmt->bind_param("ss", $ref_no, $name);
    
    if ($stmt->execute()) {
        header("Location: ../customers.php?status=added");
    } else {
        header("Location: ../customers.php?status=error");
    }
    exit();
}

// Update customer
if (isset($_POST['update_customer'])) {
    $id = intval($_POST['id']);
    $ref_no = trim($_POST['ref_no']);
    $name = trim($_POST['name']);

    // Check for duplicate ref_no excluding current ID
    $stmt = $conn->prepare("SELECT id FROM customers WHERE ref_no = ? AND id != ?");
    $stmt->bind_param("si", $ref_no, $id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        header("Location: ../Customers_form.php?edit_id=$id&status=duplicate");
        exit();
    }

    $stmt->close();

    // Update data
    $stmt = $conn->prepare("UPDATE customers SET ref_no = ?, name = ? WHERE id = ?");
    $stmt->bind_param("ssi", $ref_no, $name, $id);
    
    if ($stmt->execute()) {
        header("Location: ../customers.php?status=updated");
    } else {
        header("Location: ../Customers_form.php?edit_id=$id&status=error");
    }
    exit();
}

// Delete customer
if (isset($_GET['delete_customer'])) {
    $id = intval($_GET['delete_customer']);

    $stmt = $conn->prepare("DELETE FROM customers WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        header("Location: ../customers.php?status=deleted");
    } else {
        header("Location: ../customers.php?status=error");
    }
    exit();
}
?>