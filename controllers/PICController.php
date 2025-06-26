<?php
include '../db.php';

// Add new PIC
if (isset($_POST['add_pic'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $email = $conn->real_escape_string($_POST['email']);
    $status = isset($_POST['status']) && $_POST['status'] == 'on' ? 'on' : 'off';
    
    // Check if email already exists
    $check = $conn->query("SELECT id FROM pic WHERE email = '$email'");
    if ($check->num_rows > 0) {
        header("Location: ../pic_form.php?status=duplicate");
        exit();
    }
    
    // If setting to 'on', turn off all other PICs
    if ($status == 'on') {
        $conn->query("UPDATE pic SET status = 'off'");
    }
    
    $stmt = $conn->prepare("INSERT INTO pic (name, phone, email, status) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $phone, $email, $status);
    
    if ($stmt->execute()) {
        header("Location: ../pic.php?status=added");
    } else {
        header("Location: ../pic_form.php?status=error");
    }
    exit();
}

// Update PIC
if (isset($_POST['update_pic'])) {
    $id = intval($_POST['id']);
    $name = $conn->real_escape_string($_POST['name']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $email = $conn->real_escape_string($_POST['email']);
    $status = isset($_POST['status']) && $_POST['status'] == 'on' ? 'on' : 'off';
    
    // Check if email already exists (excluding current PIC)
    $check = $conn->query("SELECT id FROM pic WHERE email = '$email' AND id != $id");
    if ($check->num_rows > 0) {
        header("Location: ../pic_form.php?edit_id=$id&status=duplicate");
        exit();
    }
    
    // If setting to 'on', turn off all other PICs
    if ($status == 'on') {
        $conn->query("UPDATE pic SET status = 'off' WHERE id != $id");
    }
    
    $stmt = $conn->prepare("UPDATE pic SET name = ?, phone = ?, email = ?, status = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $name, $phone, $email, $status, $id);
    
    if ($stmt->execute()) {
        header("Location: ../pic.php?status=updated");
    } else {
        header("Location: ../pic_form.php?edit_id=$id&status=error");
    }
    exit();
}

// Delete PIC
if (isset($_GET['delete_pic'])) {
    $id = intval($_GET['delete_pic']);
    $conn->query("DELETE FROM pic WHERE id = $id");
    header("Location: ../pic.php?status=deleted");
    exit();
}
// Update PIC Status
if (isset($_POST['update_status'])) {
    $id = intval($_POST['id']);
    $status = $_POST['status'] == 'on' ? 'on' : 'off';
    
    // Jika mengaktifkan PIC, nonaktifkan semua PIC lain
    if ($status == 'on') {
        $conn->query("UPDATE pic SET status = 'off'");
    }
    
    // Update status PIC yang dipilih
    $stmt = $conn->prepare("UPDATE pic SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);
    
    if ($stmt->execute()) {
        header("Location: ../pic.php?status=updated");
    } else {
        header("Location: ../pic.php?status=error");
    }
    exit();
}