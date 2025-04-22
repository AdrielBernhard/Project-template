<?php
include '../db.php';

// Tampilkan semua error (debug)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Tambah customer
if (isset($_POST['add_customer'])) {
    $ref_no = trim($_POST['ref_no']);
    $name = trim($_POST['name']);

    // Cek duplikat ref_no
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
    $stmt->execute();
    $stmt->close();

    header("Location: ../customers.php?status=added");
    exit();
}

// Update customer
if (isset($_POST['update_customer'])) {
    $id = intval($_POST['id']);
    $ref_no = trim($_POST['ref_no']);
    $name = trim($_POST['name']);

    // Cek duplikat ref_no untuk selain ID ini
    $stmt = $conn->prepare("SELECT id FROM customers WHERE ref_no = ? AND id != ?");
    $stmt->bind_param("si", $ref_no, $id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        header("Location: ../customers.php?status=duplicate&edit_id=$id");
        exit();
    }

    $stmt->close();

    // Update data
    $stmt = $conn->prepare("UPDATE customers SET ref_no = ?, name = ? WHERE id = ?");
    $stmt->bind_param("ssi", $ref_no, $name, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: ../customers.php?status=updated");
    exit();
}

// Delete customer
if (isset($_GET['delete_customer'])) {
    $id = intval($_GET['delete_customer']);

    $stmt = $conn->prepare("DELETE FROM customers WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: ../customers.php?status=deleted");
    exit();
}
?>
