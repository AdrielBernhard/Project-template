<?php
include __DIR__ . '/../db.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Add
if (isset($_POST['add'])) {
    // Validate input
    $item_id = intval($_POST['item_id']);
    $customer_id = intval($_POST['customer_id']);
    $harga = isset($_POST['harga']) && $_POST['harga'] !== '' ? floatval($_POST['harga']) : null;

    if ($item_id <= 0 || $customer_id <= 0) {
        header("Location: ../item_customer_form.php?status=error&message=Data+tidak+valid&item_id=$item_id&customer_id=$customer_id&harga=".$_POST['harga'] ?? '');
        exit;
    }

    // If harga is empty, get the item's default price
    if ($harga === null) {
        $stmt = $conn->prepare("SELECT price FROM items WHERE id = ?");
        $stmt->bind_param("i", $item_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $harga = $result->fetch_assoc()['price'];
        } else {
            $harga = 0; // Default if item not found
        }
        $stmt->close();
    }

    // Insert data (duplicates allowed)
    $stmt = $conn->prepare("INSERT INTO item_customer (item_id, customer_id, harga) VALUES (?, ?, ?)");
    $stmt->bind_param("iid", $item_id, $customer_id, $harga);
    
    if ($stmt->execute()) {
        header("Location: ../item_customer.php?status=added");
    } else {
        header("Location: ../item_customer_form.php?status=error&message=Gagal+menambahkan+data&item_id=$item_id&customer_id=$customer_id&harga=".$_POST['harga'] ?? '');
    }
    $stmt->close();
    exit;
}

// Update
if (isset($_POST['update'])) {
    // Validate input
    $id = intval($_POST['id']);
    $item_id = intval($_POST['item_id']);
    $customer_id = intval($_POST['customer_id']);
    $harga = isset($_POST['harga']) && $_POST['harga'] !== '' ? floatval($_POST['harga']) : null;

    if ($id <= 0 || $item_id <= 0 || $customer_id <= 0) {
        header("Location: ../item_customer_form.php?status=error&message=Data+tidak+valid&edit_id=$id&item_id=$item_id&customer_id=$customer_id&harga=".$_POST['harga'] ?? '');
        exit;
    }

    // If harga is empty, get the item's default price
    if ($harga === null) {
        $stmt = $conn->prepare("SELECT price FROM items WHERE id = ?");
        $stmt->bind_param("i", $item_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $harga = $result->fetch_assoc()['price'];
        } else {
            $harga = 0; // Default if item not found
        }
        $stmt->close();
    }

    // Update data
    $stmt = $conn->prepare("UPDATE item_customer SET item_id=?, customer_id=?, harga=? WHERE id=?");
    $stmt->bind_param("iidi", $item_id, $customer_id, $harga, $id);
    
    if ($stmt->execute()) {
        header("Location: ../item_customer.php?status=updated");
    } else {
        header("Location: ../item_customer_form.php?status=error&message=Gagal+update+data&edit_id=$id&item_id=$item_id&customer_id=$customer_id&harga=".$_POST['harga'] ?? '');
    }
    $stmt->close();
    exit;
}

// Delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    
    if ($id <= 0) {
        header("Location: ../item_customer.php?status=error&message=ID+tidak+valid");
        exit;
    }

    $stmt = $conn->prepare("DELETE FROM item_customer WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        header("Location: ../item_customer.php?status=deleted");
    } else {
        header("Location: ../item_customer.php?status=error&message=Gagal+menghapus+data");
    }
    $stmt->close();
    exit;
}