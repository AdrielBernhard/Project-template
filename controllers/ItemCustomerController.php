<?php
include '../db.php';

// Tambah
if (isset($_POST['add'])) {
  $stmt = $conn->prepare("INSERT INTO item_customer (item_id, customer_id, harga) VALUES (?, ?, ?)");
  $stmt->bind_param("iii", $_POST['item_id'], $_POST['customer_id'], $_POST['harga']);
  $stmt->execute();
  header("Location: ../item_customer.php?status=added");
  exit;
}

// Update
if (isset($_POST['update'])) {
  $stmt = $conn->prepare("UPDATE item_customer SET item_id=?, customer_id=?, harga=? WHERE id=?");
  $stmt->bind_param("iiii", $_POST['item_id'], $_POST['customer_id'], $_POST['harga'], $_POST['id']);
  $stmt->execute();
  header("Location: ../item_customer.php?status=updated");
  exit;
}

// Delete
if (isset($_GET['delete'])) {
  $stmt = $conn->prepare("DELETE FROM item_customer WHERE id = ?");
  $stmt->bind_param("i", $_GET['delete']);
  $stmt->execute();
  header("Location: ../item_customer.php?status=deleted");
  exit;
}
