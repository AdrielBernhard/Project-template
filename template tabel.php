<div class="card mb-4">
    <!-- Card Header dengan judul dan tombol Tambah -->
    <div class="card-header d-flex justify-content-start align-items-center">
        <h3 class="card-title mx-4"><b>Tabel Items</b></h3>
        <a href="Items_form.php" class="btn btn-success float-end">
            <i class="fas fa-plus me-0"></i> Tambah Items
        </a>
    </div>
    
    <!-- Card Body berisi tabel data -->
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr class="align-middle">
                    <th style="width: 10px">#</th>
                    <th>Reference No</th>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th style="width: 170px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($items)): ?>
                    <!-- Tampilan ketika tidak ada data -->
                    <tr class="align-middle">
                        <td colspan="5" class="text-center">Tidak ada item yang ditemukan</td>
                    </tr>
                <?php else: ?>
                    <!-- Loop melalui setiap item -->
                    <?php foreach ($items as $index => $item): ?>
                        <tr class="align-middle">
                            <td><?= $index + 1 ?></td> <!-- Nomor urut -->
                            <td><?= htmlspecialchars($item['ref_no']) ?></td> <!-- Reference No -->
                            <td><?= htmlspecialchars($item['name']) ?></td> <!-- Nama Item -->
                            <td>Rp <?= number_format($item['price'], 0, ',', '.') ?></td> <!-- Harga dengan format -->
                            <td>
                                <!-- Tombol aksi -->
                                <div class="d-flex gap-2">
                                    <!-- Tombol Edit -->
                                    <a href="Items_form.php?edit_id=<?= $item['id'] ?>" 
                                       class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit me-1"></i> Edit
                                    </a>
                                    <!-- Tombol Delete dengan konfirmasi -->
                                    <a href="controllers/ItemController.php?delete_item=<?= $item['id'] ?>" 
                                       class="btn btn-sm btn-danger" 
                                       onclick="return confirm('Apakah Anda yakin ingin menghapus item ini?')">
                                        <i class="fas fa-trash-alt me-1"></i> Hapus
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <!-- Card Footer dengan pagination -->
    <div class="card-footer clearfix">
        <ul class="pagination pagination-sm m-0 float-end">
            <li class="page-item"><a class="page-link" href="#">«</a></li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">»</a></li>
        </ul>
    </div>
</div>