
<?php include 'db.php'; ?>
<?php include 'template/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $conn->prepare("INSERT INTO suppliers (ref_no, name) VALUES (?, ?)");
    $stmt->bind_param("ss", $_POST['ref_no'], $_POST['name']);
    $stmt->execute();
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM suppliers WHERE id = $id");
}

$result = $conn->query("SELECT * FROM suppliers");
?>

<h2>Suppliers</h2>
<form method="POST" class="mb-4">
  <div class="row">
    <div class="col"><input name="ref_no" class="form-control" placeholder="Ref No" required></div>
    <div class="col"><input name="name" class="form-control" placeholder="Name" required></div>
    <div class="col"><button class="btn btn-primary">Add</button></div>
  </div>
</form>

<table class="table table-bordered">
  <thead><tr><th>ID</th><th>Ref No</th><th>Name</th><th>Action</th></tr></thead>
  <tbody>
    <?php while($item = $result->fetch_assoc()): ?>
      <tr>
        <td><?= $item['id'] ?></td>
        <td><?= $item['ref_no'] ?></td>
        <td><?= $item['name'] ?></td>
        <td><a href="?delete=<?= $item['id'] ?>" class="text-danger"><i class="fas fa-trash"></i></a></td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>

<?php include 'template/footer.php'; ?>
