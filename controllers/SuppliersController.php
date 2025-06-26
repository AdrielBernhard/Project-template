<?php
include __DIR__ . '/../db.php';

// Tambah supplier
if (isset($_POST['add_supplier'])) {
    $ref_no = $_POST['ref_no'];
    $name = $_POST['name'];

    // Cek apakah ref_no sudah ada
    $check = $conn->prepare("SELECT id FROM suppliers WHERE ref_no = ?");
    $check->bind_param("s", $ref_no);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        // Kirim kembali data yang sudah diinput
        header("Location: ../Suppliers_form.php?status=duplicate&ref_no=".urlencode($ref_no)."&name=".urlencode($name));
        exit;
    }

    $check->close();

    $stmt = $conn->prepare("INSERT INTO suppliers (ref_no, name) VALUES (?, ?)");
    $stmt->bind_param("ss", $ref_no, $name);
    $stmt->execute();
    $stmt->close();

    header("Location: ../Suppliers.php?status=added");
    exit;
}

// Update supplier
if (isset($_POST['update_supplier'])) {
    $id = intval($_POST['id']);
    $ref_no = $_POST['ref_no'];
    $name = $_POST['name'];

    // Cek apakah ref_no sudah digunakan oleh supplier lain
    $check = $conn->prepare("SELECT id FROM suppliers WHERE ref_no = ? AND id != ?");
    $check->bind_param("si", $ref_no, $id);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        // Kirim kembali data yang sudah diinput termasuk edit_id
        header("Location: ../Suppliers_form.php?status=duplicate&edit_id=".$id."&ref_no=".urlencode($ref_no)."&name=".urlencode($name));
        exit;
    }

    $check->close();

    $stmt = $conn->prepare("UPDATE suppliers SET ref_no = ?, name = ? WHERE id = ?");
    $stmt->bind_param("ssi", $ref_no, $name, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: ../Suppliers.php?status=updated");
    exit;
}

// Hapus supplier
if (isset($_GET['delete_supplier'])) {
    $id = intval($_GET['delete_supplier']);
    $stmt = $conn->prepare("DELETE FROM suppliers WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: ../Suppliers.php?status=deleted");
    exit;
}