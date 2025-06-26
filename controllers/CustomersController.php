<?php
include __DIR__ . '/../db.php';

if (isset($_POST['add_customer'])) {
    $ref_no = trim($_POST['ref_no']);
    $name = trim($_POST['name']);
    $company_name = trim($_POST['company_name'] ?? '');
    $company_address = trim($_POST['company_address'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $country = trim($_POST['country'] ?? '');

    // Validasi input
    if (empty($ref_no) || empty($name)) {
        header("Location: ../Customers_form.php?status=error&message=Field tidak boleh kosong");
        exit();
    }

    // Check for duplicate ref_no
    $stmt = $conn->prepare("SELECT id FROM customers WHERE ref_no = ?");
    if (!$stmt) {
        header("Location: ../Customers_form.php?status=error&message=Database error");
        exit();
    }
    
    $stmt->bind_param("s", $ref_no);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        header("Location: ../Customers_form.php?status=duplicate&ref_no=".urlencode($ref_no)."&name=".urlencode($name));
        exit();
    }

    $stmt->close();

    // Insert data
    $stmt = $conn->prepare("INSERT INTO customers (ref_no, name, company_name, company_address, city, country) VALUES (?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        header("Location: ../Customers_form.php?status=error&message=Database error");
        exit();
    }
    
    $stmt->bind_param("ssssss", $ref_no, $name, $company_name, $company_address, $city, $country);
    
    if ($stmt->execute()) {
        header("Location: ../customers.php?status=added");
    } else {
        header("Location: ../Customers_form.php?status=error&message=Gagal menambahkan data&ref_no=".urlencode($ref_no)."&name=".urlencode($name));
    }
    $stmt->close();
    exit();
}

// Update customer
if (isset($_POST['update_customer'])) {
    $id = intval($_POST['id']);
    $ref_no = trim($_POST['ref_no']);
    $name = trim($_POST['name']);
    $company_name = trim($_POST['company_name'] ?? '');
    $company_address = trim($_POST['company_address'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $country = trim($_POST['country'] ?? '');

    // Check for duplicate ref_no excluding current ID
    $stmt = $conn->prepare("SELECT id FROM customers WHERE ref_no = ? AND id != ?");
    $stmt->bind_param("si", $ref_no, $id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Send back the entered data including edit_id
        header("Location: ../Customers_form.php?status=duplicate&edit_id=".$id."&ref_no=".urlencode($ref_no)."&name=".urlencode($name));
        exit();
    }

    $stmt->close();

    // Update data
    $stmt = $conn->prepare("UPDATE customers SET ref_no = ?, name = ?, company_name = ?, company_address = ?, city = ?, country = ? WHERE id = ?");
    $stmt->bind_param("ssssssi", $ref_no, $name, $company_name, $company_address, $city, $country, $id);
    
    if ($stmt->execute()) {
        header("Location: ../customers.php?status=updated");
    } else {
        header("Location: ../Customers_form.php?edit_id=".$id."&status=error&ref_no=".urlencode($ref_no)."&name=".urlencode($name));
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