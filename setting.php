<?php
include 'db.php';

// Ambil data perusahaan
$company_query = $conn->query("SELECT * FROM company_settings LIMIT 1");
$company = $company_query->fetch_assoc();

// Jika tidak ada data, inisialisasi dengan nilai default
if (!$company) {
    $company = [
        'company_name' => 'Nama Perusahaan Anda',
        'address' => 'Jl. Contoh No. 123',
        'city' => 'Jakarta',
        'province' => 'DKI Jakarta',
        'postal_code' => '12345',
        'country' => 'Indonesia',
        'phone' => '02112345678',
        'email' => 'info@perusahaan.com'
    ];
}

// Ambil PIC aktif
$active_pic = $conn->query("SELECT * FROM pic WHERE status = 'on' LIMIT 1")->fetch_assoc();

// Update data perusahaan jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $company_name = $conn->real_escape_string($_POST['company_name']);
    $address = $conn->real_escape_string($_POST['address']);
    $city = $conn->real_escape_string($_POST['city']);
    $province = $conn->real_escape_string($_POST['province']);
    $postal_code = $conn->real_escape_string($_POST['postal_code']);
    $country = $conn->real_escape_string($_POST['country']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $email = $conn->real_escape_string($_POST['email']);

    // Update atau insert data perusahaan
    $stmt = $conn->prepare("
        INSERT INTO company_settings (id, company_name, address, city, province, postal_code, country, phone, email)
        VALUES (1, ?, ?, ?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE 
        company_name = VALUES(company_name),
        address = VALUES(address),
        city = VALUES(city),
        province = VALUES(province),
        postal_code = VALUES(postal_code),
        country = VALUES(country),
        phone = VALUES(phone),
        email = VALUES(email)
    ");
    
    $stmt->bind_param("ssssssss", $company_name, $address, $city, $province, $postal_code, $country, $phone, $email);
    
    if ($stmt->execute()) {
        $success_message = "Pengaturan perusahaan berhasil diperbarui.";
        // Refresh data
        $company = $conn->query("SELECT * FROM company_settings LIMIT 1")->fetch_assoc();
    } else {
        $error_message = "Gagal memperbarui pengaturan perusahaan.";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>AdminLTE 4 | Pengaturan Perusahaan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="AdminLTE 4 | Pengaturan Perusahaan" />
    <meta name="author" content="ColorlibHQ" />
    <meta name="description" content="Halaman pengaturan perusahaan" />
    
    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" />
    
    <!-- Third Party Plugins -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="adminlte.css" />
</head>
<body class="layout-fixed sidebar-expand-lg sidebar-mini sidebar-collapse bg-body-tertiary">
    <div class="app-wrapper">
        <?php include 'sidebar-navbar.html'; ?>
        
        <main class="app-main">
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6"><h3 class="mb-0">Pengaturan Perusahaan</h3></div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><a href="index.php">Pengaturan</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="app-content">
                <div class="container-fluid">
                    <!-- Status Messages -->
                    <?php if (isset($success_message)): ?>
                        <div class="alert alert-success alert-dismissible fade show">
                            <?= $success_message ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (isset($error_message)): ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <?= $error_message ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h3 class="card-title">Informasi Perusahaan</h3>
                                </div>
                                <div class="card-body">
                                    <form method="POST">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="company_name" class="form-label">Nama Perusahaan</label>
                                                    <input type="text" class="form-control" id="company_name" name="company_name" 
                                                           value="<?= htmlspecialchars($company['company_name']) ?>" required>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label for="address" class="form-label">Alamat</label>
                                                    <textarea class="form-control" id="address" name="address" rows="3" required><?= htmlspecialchars($company['address']) ?></textarea>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="city" class="form-label">Kota</label>
                                                            <input type="text" class="form-control" id="city" name="city" 
                                                                   value="<?= htmlspecialchars($company['city']) ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="province" class="form-label">Provinsi</label>
                                                            <input type="text" class="form-control" id="province" name="province" 
                                                                   value="<?= htmlspecialchars($company['province']) ?>" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="postal_code" class="form-label">Kode Pos</label>
                                                            <input type="text" class="form-control" id="postal_code" name="postal_code" 
                                                                   value="<?= htmlspecialchars($company['postal_code']) ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="country" class="form-label">Negara</label>
                                                            <input type="text" class="form-control" id="country" name="country" 
                                                                   value="<?= htmlspecialchars($company['country']) ?>" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label for="phone" class="form-label">Telepon</label>
                                                    <input type="tel" class="form-control" id="phone" name="phone" 
                                                           value="<?= htmlspecialchars($company['phone']) ?>" required>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="email" class="form-control" id="email" name="email" 
                                                           value="<?= htmlspecialchars($company['email']) ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h3 class="card-title">Person In Charge (PIC) Aktif</h3>
                                </div>
                                <div class="card-body">
                                    <?php if ($active_pic): ?>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Nama PIC</label>
                                                    <p class="form-control-static"><?= htmlspecialchars($active_pic['name']) ?></p>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">No. Telepon</label>
                                                    <p class="form-control-static"><?= htmlspecialchars($active_pic['phone']) ?></p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Email</label>
                                                    <p class="form-control-static"><?= htmlspecialchars($active_pic['email']) ?></p>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Status</label>
                                                    <p class="form-control-static">
                                                        <span class="badge bg-success">AKTIF</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <a href="pic.php" class="btn btn-secondary">Kelola PIC</a>
                                        </div>
                                    <?php else: ?>
                                        <div class="alert alert-warning">
                                            Tidak ada PIC yang aktif. Silakan <a href="pic.php">atur PIC</a> terlebih dahulu.
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="card mb-4">
                                <div class="card-header">
                                    <h3 class="card-title">Logo dan Tanda Tangan Dokumen</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-4">
                                                <h5>Logo Perusahaan (max 20MB)</h5>
                                                <?php if (!empty($company['logo_path']) && file_exists($company['logo_path'])): ?>
                                                    <img src="<?= $company['logo_path'] ?>" class="img-thumbnail mb-2" style="max-width: 300px; max-height: 200px;">
                                                <?php else: ?>
                                                    <div class="alert alert-info py-2">Belum ada dokumen</div>
                                                <?php endif; ?>
                                                <p class="text-muted small">Maksimal ukuran 20MB JPEG, PNG<br>Rekomendasi ukuran 300x200</p>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="mb-4">
                                                <h5>Tanda Tangan (max 20MB)</h5>
                                                <?php if (!empty($company['signature_path']) && file_exists($company['signature_path'])): ?>
                                                    <img src="<?= $company['signature_path'] ?>" class="img-thumbnail mb-2" style="max-width: 300px; max-height: 200px;">
                                                <?php else: ?>
                                                    <div class="alert alert-info py-2">Belum ada dokumen</div>
                                                <?php endif; ?>
                                                <p class="text-muted small">Maksimal ukuran 20MB JPEG, PNG<br>Rekomendasi ukuran 300x200</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="text-end">
                                        <a href="logo_signature.php" class="btn btn-primary">Ubah</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        
        <footer class="app-footer">
            <strong>Copyright &copy; 2014-2024 <a href="https://adminlte.io" class="text-decoration-none">AdminLTE.io</a>.</strong>
            All rights reserved.
        </footer>
    </div>
    
    <?php include 'script.php'; ?>
</body>
</html>