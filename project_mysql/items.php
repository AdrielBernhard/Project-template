
<?php include 'db.php'; ?>
<?php include 'template/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $conn->prepare("INSERT INTO items (ref_no, name, price) VALUES (?, ?, ?)");
    $stmt->bind_param("ssd", $_POST['ref_no'], $_POST['name'], $_POST['price']);
    $stmt->execute();
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM items WHERE id = $id");
}

$result = $conn->query("SELECT * FROM items");
?>

<h2>Items</h2>
<form method="POST" class="mb-4">
  <div class="row">
    <div class="col"><input name="ref_no" class="form-control" placeholder="Ref No" required></div>
    <div class="col"><input name="name" class="form-control" placeholder="Name" required></div>
    <div class="col"><input name="price" class="form-control" type="number" step="0.01" placeholder="Price" required></div>
    <div class="col"><button class="btn btn-primary">Add</button></div>
  </div>
</form>

<table class="table table-bordered">
  <thead><tr><th>ID</th><th>Ref No</th><th>Name</th><th>Price</th><th>Action</th></tr></thead>
  <tbody>
    <?php while($item = $result->fetch_assoc()): ?>
      <tr>
        <td><?= $item['id'] ?></td>
        <td><?= $item['ref_no'] ?></td>
        <td><?= $item['name'] ?></td>
        <td><?= $item['price'] ?></td>
        <td><a href="?delete=<?= $item['id'] ?>" class="text-danger"><i class="fas fa-trash"></i></a></td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>

<?php include 'template/footer.php'; ?>
