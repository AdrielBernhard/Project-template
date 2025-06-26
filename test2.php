
                <!-- Status Messages -->  
                <?php if (isset($_GET['status'])): ?>
                    <div class="alert alert-<?= $_GET['status'] == 'duplicate' ? 'danger' : 'success' ?> alert-dismissible fade show">
                        <?php
                        $messages = [
                            'added' => 'Item berhasil ditambah.',
                            'updated' => 'Item berhasil diudate.',
                            'deleted' => 'Item berhasil dihapus.',
                            'duplicate' => 'Reference number sudah ada. Pakai reference number yang berbeda.'
                        ];
                        echo $messages[$_GET['status']] ?? '';
                        ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Default box -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Search Items</h3>
                    </div>
                    <div class="card-body">
                        <form method="GET" class="row g-3">
                            <div class="col-md-8">
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Cari berdasarkan nama atau ref no..." 
                                       value="<?= htmlspecialchars($keyword) ?>">
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="fas fa-search"></i> Search
                                </button>
                                <a href="Items.php" class="btn btn-secondary">
                                    <i class="fas fa-sync-alt"></i> Reset
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                                <div class="card mb-4">
                  <div class="card-header">
                    <h3 class="card-title me-4 mb-0">Tabel Items</h3>
                    <a href="Items_form.php" class="btn btn-success float-end">
                      <i class="fas fa-plus me-0"></i> Tambah Items
                    </a>
                  <div class="card-body">
                    <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th style="width: 10px" >No</th>
                        <th>Ref No</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th style="width: 170px">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $no = $offset + 1; ?>
                      <?php while ($row = mysqli_fetch_assoc($query)) : ?>
                        <tr>
                          <td><?= $no++; ?></td>
                          <td><?= $row['ref_no']; ?></td>
                          <td><?= $row['name']; ?></td>
                          <td><?= number_format($row['price']); ?></td>
                          <td>
                            <a href="edit_item.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="hapus_item.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                          </td>
                        </tr>
                      <?php endwhile; ?>
                    </tbody>
                  </table>
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer clearfix">
                    <ul class="pagination pagination-sm m-0 float-end">
                      <!-- Tombol « -->
                      <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                          <a class="page-link" href="?page=<?= $page - 1; ?>">«</a>
                      </li>

                      <!-- Nomor halaman -->
                      <?php for ($i = 1; $i <= $totalPage; $i++) : ?>
                          <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                          <a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a>
                          </li>
                      <?php endfor; ?>

                      <!-- Tombol » -->
                      <li class="page-item <?= ($page >= $totalPage) ? 'disabled' : '' ?>">
                          <a class="page-link" href="?page=<?= $page + 1; ?>">»</a>
                      </li>
                    </ul>
                  </div>
                </div>