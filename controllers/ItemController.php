<?php
include __DIR__ . '/../db.php';

// Tambah item
if (isset($_POST['add_item'])) {
    $ref_no = $_POST['ref_no'];
    $name = $_POST['name'];
    $price = floatval($_POST['price']);

    // Cek apakah ref_no sudah ada
    $check = $conn->prepare("SELECT id FROM items WHERE ref_no = ?");
    $check->bind_param("s", $ref_no);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        // Kirim kembali data yang sudah diinput
        header("Location: ../Items_form.php?status=duplicate&ref_no=".urlencode($ref_no)."&name=".urlencode($name)."&price=".urlencode($price));
        exit;
    }
    $check->close();

    $stmt = $conn->prepare("INSERT INTO items (ref_no, name, price) VALUES (?, ?, ?)");
    $stmt->bind_param("ssd", $ref_no, $name, $price);
    $stmt->execute();
    $stmt->close();

    header("Location: ../Items.php?status=added");
    exit;
}

// Update item
if (isset($_POST['update_item'])) {
    $id = intval($_POST['id']);
    $ref_no = $_POST['ref_no'];
    $name = $_POST['name'];
    $price = floatval($_POST['price']);

    // Cek apakah ref_no sudah digunakan oleh item lain
    $check = $conn->prepare("SELECT id FROM items WHERE ref_no = ? AND id != ?");
    $check->bind_param("si", $ref_no, $id);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        // Kirim kembali data yang sudah diinput termasuk edit_id
        header("Location: ../Items_form.php?status=duplicate&edit_id=".$id."&ref_no=".urlencode($ref_no)."&name=".urlencode($name)."&price=".urlencode($price));
        exit;
    }
    $check->close();

    $stmt = $conn->prepare("UPDATE items SET ref_no = ?, name = ?, price = ? WHERE id = ?");
    $stmt->bind_param("ssdi", $ref_no, $name, $price, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: ../Items.php?status=updated");
    exit;
}

// Hapus item
if (isset($_GET['delete_item'])) {
    $id = intval($_GET['delete_item']);
    $stmt = $conn->prepare("DELETE FROM items WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: ../Items.php?status=deleted");
    exit;
}