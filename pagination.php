<?php if (isset($page) && isset($totalPage)) : ?>
<ul class="pagination pagination-sm m-0 float-end">
  <!-- Tombol Sebelumnya -->
  <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
    <a class="page-link" href="?page=<?= max(1, $page - 1); ?>">«</a>
  </li>

  <!-- Nomor Halaman -->
  <?php for ($i = 1; $i <= $totalPage; $i++) : ?>
    <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
      <a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a>
    </li>
  <?php endfor; ?>

  <!-- Tombol Berikutnya -->
  <li class="page-item <?= ($page >= $totalPage) ? 'disabled' : '' ?>">
    <a class="page-link" href="?page=<?= min($totalPage, $page + 1); ?>">»</a>
  </li>
</ul>
<?php endif; ?>
