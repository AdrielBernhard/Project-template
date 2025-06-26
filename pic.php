<?php
include 'db.php';

// Initialize variables
$keyword = isset($_GET['search']) ? trim($_GET['search']) : '';

// Get PICs data based on search
if ($keyword !== '') {
    $stmt = $conn->prepare("SELECT * FROM pic WHERE name LIKE ? OR position LIKE ? OR email LIKE ? ORDER BY id ASC");
    $like_keyword = '%' . $keyword . '%';
    $stmt->bind_param("sss", $like_keyword, $like_keyword, $like_keyword);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT * FROM pic ORDER BY id ASC");
}

$pics = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $pics[] = $row;
    }
}

// First, we need to create the PIC table if it doesn't exist
$conn->query("
    CREATE TABLE IF NOT EXISTS pic (
        id INT(11) NOT NULL AUTO_INCREMENT,
        name VARCHAR(100) NOT NULL,
        position VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        status ENUM('on','off') DEFAULT 'off',
        PRIMARY KEY (id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
");
?>

<!doctype html>
<html lang="en">
  <!--begin::Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>AdminLTE 4 | PIC Management</title>
    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="AdminLTE 4 | PIC Management" />
    <meta name="author" content="ColorlibHQ" />
    <meta
      name="description"
      content="PIC management system"
    />
    <!--end::Primary Meta Tags-->
    <!--begin::Fonts-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
      integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q="
      crossorigin="anonymous"
    />
    <!--end::Fonts-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css"
      integrity="sha256-tZHrRjVqNSRyWg2wbppGnT833E/Ys0DHWGwT04GiqQg="
      crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(OverlayScrollbars)-->
    <!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
      integrity="sha256-9kPW/n5nn53j4WMRYAxe9c1rCY96Oogo/MKSVdKzPmI="
      crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(Bootstrap Icons)-->
    <!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="adminlte.css" />
    <!--end::Required Plugin(AdminLTE)-->
  </head>
  <!--end::Head-->
  <!--begin::Body-->
  <body class="layout-fixed sidebar-expand-lg sidebar-mini sidebar-collapse bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
      <?php include 'sidebar-navbar.html'; ?>
      <!--begin::App Main-->
      <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6"><h3 class="mb-0">Person In Charge (PIC)</h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">PIC</li>
                </ol>
              </div>
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-lg-12">
               <!-- Status Messages -->  
                <?php if (isset($_GET['status'])): ?>
                    <div class="alert alert-<?= $_GET['status'] == 'duplicate' ? 'danger' : 'success' ?> alert-dismissible fade show">
                        <?php
                        $messages = [
                            'added' => 'PIC berhasil ditambah.',
                            'updated' => 'PIC berhasil diupdate.',
                            'deleted' => 'PIC berhasil dihapus.',
                            'duplicate' => 'Email sudah digunakan. Gunakan email yang berbeda.'
                        ];
                        echo $messages[$_GET['status']] ?? '';
                        ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <div class="card mb-4">
                  <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                      <h3 class="card-title">Search PIC</h3>
                    </div>
                  </div>
                  <div class="card-body">
                    <form method="GET" class="row g-3">
                      <div class="col-md-8">
                        <input type="text" name="search" class="form-control" 
                               placeholder="Cari berdasarkan nama, jabatan atau email..." 
                               value="<?= htmlspecialchars($keyword) ?>">
                      </div>
                      <div class="col-md-4">
                        <button type="submit" class="btn btn-primary me-2">
                          <i class="fas fa-search"></i> Search
                        </button>
                        <a href="pic.php" class="btn btn-secondary">
                          <i class="fas fa-sync-alt"></i> Reset
                        </a>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>

            <!-- PIC Table -->
            <div class="row">
              <div class="col-lg-12">
                <div class="card mb-4">
                  <div class="card-header d-flex align-items-center">
                  <h3 class="card-title me-4 mb-0">Daftar PIC</h3>
                  <a href="pic_form.php" class="btn btn-success float-end">
                    <i class="fas fa-plus me-0"></i> Tambah PIC
                  </a>
                  </div>
                  <div class="card-body">
                    <table class="table table-bordered">
                          <tr class="align-middle">
                              <th style="width: 10px">#</th>
                              <th>Nama</th>
                              <th>No. Telpon</th>
                              <th>Email</th>
                              <th style="width: 170px">Aksi</th>
                          </tr>
                      </thead>

                      <tbody>
                        <?php if (empty($pics)): ?>
                          <tr class="align-middle">
                            <td colspan="6" class="text-center">Tidak ada data PIC</td>
                          </tr>
                        <?php else: 
                          $counter = 1;
                          foreach ($pics as $pic): ?>
                            <tr class="align-middle">
                              <td><?= $counter++ ?></td>
                              <td><?= htmlspecialchars($pic['name']) ?></td>
                              <td><?= htmlspecialchars($pic['phone']) ?></td>
                              <td><?= htmlspecialchars($pic['email']) ?></td>
                              <td>
                                  <form method="post" action="controllers/PICController.php" style="display:inline;">
                                      <input type="hidden" name="update_status" value="1">
                                      <input type="hidden" name="id" value="<?= $pic['id'] ?>">
                                      <?php if ($pic['status'] == 'on'): ?>
                                          <input type="hidden" name="status" value="off">
                                          <button type="submit" class="btn btn-success btn-sm">ON</button>
                                      <?php else: ?>
                                          <input type="hidden" name="status" value="on">
                                          <button type="submit" class="btn btn-secondary btn-sm">OFF</button>
                                      <?php endif; ?>
                                  </form>
                              </td>
                              <td>
                                <div class="d-flex gap-2">
                                  <a href="pic_form.php?edit_id=<?= $pic['id'] ?>" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit me-1"></i> Edit
                                  </a>
                                  <a href="controllers/PICController.php?delete_pic=<?= $pic['id'] ?>"
                                    class="btn btn-sm btn-danger"
                                    onclick="return confirm('Yakin ingin menghapus PIC ini?')">
                                    <i class="fas fa-trash-alt me-1"></i> Delete
                                  </a>
                                </div>
                              </td>
                            </tr>
                          <?php endforeach;
                        endif; ?>
                      </tbody>
                    </table>
                  </div>
                  <!-- /.card-body -->
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
              </div>
            </div>
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content-->
      </main>
      <!--end::App Main-->
      <!--begin::Footer-->
      <footer class="app-footer">
        <!--begin::Copyright-->
        <strong>
          Copyright &copy; 2014-2024&nbsp;
          <a href="https://adminlte.io" class="text-decoration-none">AdminLTE.io</a>.
        </strong>
        All rights reserved.
        <!--end::Copyright-->
      </footer>
      <!--end::Footer-->
    </div>
    <!--end::App Wrapper-->
    <!--begin::Script-->

    <?php include 'script.php'; ?>
    
    <!--end::Script-->
  </body>
  <!--end::Body-->
</html>