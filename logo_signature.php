<?php
include 'db.php';

// Get company data
$company_query = $conn->query("SELECT * FROM company_settings LIMIT 1");
$company = $company_query->fetch_assoc();

// Handle file uploads
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $upload_errors = [];
    $success_messages = [];
    
    // Directory for uploads
    $upload_dir = 'uploads/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    
    // Process logo upload
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] == UPLOAD_ERR_OK) {
        $logo = $_FILES['logo'];
        $logo_ext = pathinfo($logo['name'], PATHINFO_EXTENSION);
        $logo_name = 'logo_' . time() . '.' . $logo_ext;
        $logo_path = $upload_dir . $logo_name;
        
        // Validate logo
        $allowed_types = ['jpg', 'jpeg', 'png'];
        $max_size = 20 * 1024 * 1024; // 20MB
        
        if (!in_array(strtolower($logo_ext), $allowed_types)) {
            $upload_errors[] = "Format logo harus JPEG atau PNG.";
        } elseif ($logo['size'] > $max_size) {
            $upload_errors[] = "Ukuran logo maksimal 20MB.";
        } elseif (move_uploaded_file($logo['tmp_name'], $logo_path)) {
            // Delete old logo if exists
            if (!empty($company['logo_path']) && file_exists($company['logo_path'])) {
                unlink($company['logo_path']);
            }
            
            // Update database
            $conn->query("UPDATE company_settings SET logo_path = '$logo_path' WHERE id = 1");
            $success_messages[] = "Logo berhasil diunggah.";
            $company['logo_path'] = $logo_path;
        } else {
            $upload_errors[] = "Gagal mengunggah logo.";
        }
    }
    
    // Process signature upload
    if (isset($_FILES['signature']) && $_FILES['signature']['error'] == UPLOAD_ERR_OK) {
        $signature = $_FILES['signature'];
        $signature_ext = pathinfo($signature['name'], PATHINFO_EXTENSION);
        $signature_name = 'signature_' . time() . '.' . $signature_ext;
        $signature_path = $upload_dir . $signature_name;
        
        // Validate signature
        $allowed_types = ['jpg', 'jpeg', 'png'];
        $max_size = 20 * 1024 * 1024; // 20MB
        
        if (!in_array(strtolower($signature_ext), $allowed_types)) {
            $upload_errors[] = "Format tanda tangan harus JPEG atau PNG.";
        } elseif ($signature['size'] > $max_size) {
            $upload_errors[] = "Ukuran tanda tangan maksimal 20MB.";
        } elseif (move_uploaded_file($signature['tmp_name'], $signature_path)) {
            // Delete old signature if exists
            if (!empty($company['signature_path']) && file_exists($company['signature_path'])) {
                unlink($company['signature_path']);
            }
            
            // Update database
            $signature_text = $conn->real_escape_string($_POST['signature_name']);
            $conn->query("UPDATE company_settings SET signature_path = '$signature_path', signature_name = '$signature_text' WHERE id = 1");
            $success_messages[] = "Tanda tangan berhasil diunggah.";
            $company['signature_path'] = $signature_path;
            $company['signature_name'] = $signature_text;
        } else {
            $upload_errors[] = "Gagal mengunggah tanda tangan.";
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>AdminLTE 4 | Logo & Tanda Tangan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="AdminLTE 4 | Logo & Tanda Tangan" />
    <meta name="author" content="ColorlibHQ" />
    <meta name="description" content="Halaman pengaturan logo dan tanda tangan" />
    
    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" />
    
    <!-- Third Party Plugins -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="adminlte.css" />
    
    <style>
        .upload-preview {
            max-width: 300px;
            max-height: 200px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            padding: 5px;
        }
        .upload-section {
            border: 1px dashed #ccc;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body class="layout-fixed sidebar-expand-lg sidebar-mini sidebar-collapse bg-body-tertiary">
    <div class="app-wrapper">
        <?php include 'sidebar-navbar.html'; ?>
        
        <main class="app-main">
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6"><h3 class="mb-0">Logo & Tanda Tangan Dokumen</h3></div>
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
                    <?php if (!empty($upload_errors)): ?>
                        <?php foreach ($upload_errors as $error): ?>
                            <div class="alert alert-danger alert-dismissible fade show">
                                <?= $error ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    
                    <?php if (!empty($success_messages)): ?>
                        <?php foreach ($success_messages as $message): ?>
                            <div class="alert alert-success alert-dismissible fade show">
                                <?= $message ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h3 class="card-title">Logo dan Tanda Tangan Dokumen</h3>
                                </div>
                                <div class="card-body">
                                    <form method="POST" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="upload-section">
                                                    <h4>Logo Perusahaan (max 20MB)</h4>
                                                    
                                                    <?php if (!empty($company['logo_path']) && file_exists($company['logo_path'])): ?>
                                                        <img src="<?= $company['logo_path'] ?>" class="upload-preview" id="logo-preview">
                                                    <?php else: ?>
                                                        <div class="alert alert-info">Belum ada dokumen</div>
                                                        <img src="" class="upload-preview d-none" id="logo-preview">
                                                    <?php endif; ?>
                                                    
                                                    <p>Maksimal ukuran 20MB JPEG, PNG<br>Rekomendasi ukuran 300x200</p>
                                                    
                                                    <div class="mb-3">
                                                        <input type="file" class="form-control" id="logo" name="logo" accept="image/jpeg,image/png">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="upload-section">
                                                    <h4>Tanda Tangan (max 20MB)</h4>
                                                    
                                                    <?php if (!empty($company['signature_path']) && file_exists($company['signature_path'])): ?>
                                                        <img src="<?= $company['signature_path'] ?>" class="upload-preview" id="signature-preview">
                                                    <?php else: ?>
                                                        <div class="alert alert-info">Belum ada dokumen</div>
                                                        <img src="" class="upload-preview d-none" id="signature-preview">
                                                    <?php endif; ?>
                                                    
                                                    <p>Maksimal ukuran 20MB JPEG, PNG<br>Rekomendasi ukuran 300x200</p>
                                                    
                                                    <div class="mb-3">
                                                        <input type="file" class="form-control" id="signature" name="signature" accept="image/jpeg,image/png">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="setting.php" class="btn btn-secondary">Kembali</a>
                                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                        </div>
                                    </form>
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
    
    <script>
        // Preview image before upload
        document.getElementById('logo').addEventListener('change', function(e) {
            const preview = document.getElementById('logo-preview');
            const file = e.target.files[0];
            
            if (file) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                }
                
                reader.readAsDataURL(file);
            }
        });
        
        document.getElementById('signature').addEventListener('change', function(e) {
            const preview = document.getElementById('signature-preview');
            const file = e.target.files[0];
            
            if (file) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                }
                
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>