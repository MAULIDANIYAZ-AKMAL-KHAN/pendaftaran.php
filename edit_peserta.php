<?php
include "koneksi.php";

$password_rahasia = "admin2KUL";

// 1. Cek Akses Admin
if (!isset($_GET['pass']) || $_GET['pass'] !== $password_rahasia) {
    die("<h1 style='text-align:center; color:white; margin-top:100px; font-family:sans-serif;'>⛔ Akses Ditolak!</h1>");
}

// 2. Ambil data lama berdasarkan ID
$id = mysqli_real_escape_string($koneksi, $_GET['id']);
$data = mysqli_query($koneksi, "SELECT * FROM peserta WHERE id_peserta='$id'");
$d = mysqli_fetch_array($data);

if (!$d) {
    die("<h1 style='text-align:center; color:white; margin-top:100px;'>Data tidak ditemukan!</h1>");
}

// 3. Logika Update Data
if(isset($_POST['update'])){
    $nama      = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $email     = mysqli_real_escape_string($koneksi, $_POST['email']);
    $tgl_lahir = mysqli_real_escape_string($koneksi, $_POST['tgl_lahir']);
    $gender    = mysqli_real_escape_string($koneksi, $_POST['gender']);
    $lomba     = mysqli_real_escape_string($koneksi, $_POST['lomba']);
    $sekolah   = mysqli_real_escape_string($koneksi, $_POST['sekolah']);
    $whatsapp  = mysqli_real_escape_string($koneksi, $_POST['whatsapp']);
    $alamat    = mysqli_real_escape_string($koneksi, $_POST['alamat']);

    $query = "UPDATE peserta SET 
              nama='$nama', email='$email', tgl_lahir='$tgl_lahir', 
              gender='$gender', lomba='$lomba', sekolah='$sekolah', 
              whatsapp='$whatsapp', alamat='$alamat' 
              WHERE id_peserta='$id'";

    if(mysqli_query($koneksi, $query)){
        echo "<script>alert('Data Angler Berhasil Diperbarui!'); window.location.href='admin.php?pass=$password_rahasia';</script>";
    } else {
        echo "<script>alert('Gagal Update!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile Angler - Executive Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --primary-dark: #0f2027;
            --accent-green: #2ecc71;
            --soft-bg: #f4f7f6;
        }

        /* --- ANIMASI PERPINDAHAN HALAMAN --- */
        #preloader {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background-color: #0f2027;
            display: flex; justify-content: center; align-items: center;
            z-index: 9999;
            transition: opacity 0.8s ease, visibility 0.8s;
        }
        
        .loader {
            width: 50px; height: 50px;
            border: 5px solid var(--accent-green);
            border-bottom-color: transparent;
            border-radius: 50%;
            animation: rotation 1s linear infinite;
        }

        @keyframes rotation {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .fade-in-page {
            animation: fadeIn 1.2s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        /* ---------------------------------- */

        body { 
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), 
                        url('https://images.unsplash.com/photo-1544551763-46a013bb70d5?auto=format&fit=crop&w=1920&q=80'); 
            background-size: cover; 
            background-attachment: fixed; 
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            overflow-x: hidden;
            transition: opacity 0.5s ease; /* Penting untuk efek fade-out */
        }

        .card { 
            border: none; 
            border-radius: 25px; 
            background: rgba(255, 255, 255, 0.98); 
            box-shadow: 0 40px 80px rgba(0,0,0,0.5);
            overflow: hidden;
        }

        .card-header { 
            background: linear-gradient(135deg, #0f2027, #203a43); 
            color: white; 
            border: none;
            padding: 30px !important;
            border-bottom: 4px solid var(--accent-green);
        }

        .form-label {
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #555;
            margin-bottom: 8px;
        }

        .form-control, .form-select {
            border-radius: 12px;
            padding: 12px 15px;
            border: 1px solid #ddd;
            background: var(--soft-bg);
            transition: 0.3s;
        }

        .form-control:focus, .form-select:focus {
            background: #fff;
            border-color: var(--accent-green);
            box-shadow: 0 0 0 4px rgba(46, 204, 113, 0.1);
        }

        .btn-update { 
            background: var(--accent-green); 
            color: white; 
            border-radius: 15px; 
            font-weight: 800;
            padding: 15px;
            letter-spacing: 1px;
            border: none;
            transition: 0.3s;
            box-shadow: 0 10px 20px rgba(46, 204, 113, 0.3);
        }

        .btn-update:hover {
            background: #27ae60;
            transform: translateY(-2px);
            box-shadow: 0 15px 25px rgba(46, 204, 113, 0.4);
            color: white;
        }

        .btn-back {
            color: #888;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: 0.3s;
            display: inline-block;
            cursor: pointer;
        }

        .btn-back:hover { color: #333; }

        .footer-text {
            color: rgba(255,255,255,0.5);
            font-size: 0.8rem;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div id="preloader">
    <div class="text-center">
        <div class="loader mb-3"></div>
        <div class="text-white fw-bold small text-uppercase" style="letter-spacing: 3px;">Membuka Editor...</div>
    </div>
</div>

<div class="container py-5 fade-in-page">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header text-center">
                    <div class="mb-2">
                        <i class="fas fa-user-edit fa-2x text-success"></i>
                    </div>
                    <h3 class="fw-bold mb-1">EDITOR DATA ANGLER</h3>
                    <p class="mb-0 opacity-75 small text-uppercase" style="letter-spacing: 2px;">
                        Modify Participant Information #<?= $d['id_peserta']; ?>
                    </p>
                </div>
                <div class="card-body p-4 p-md-5">
                    <form method="POST" action="">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold"><i class="fas fa-user me-2"></i>Nama Lengkap</label>
                                <input type="text" class="form-control" name="nama" value="<?= $d['nama']; ?>" required>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold"><i class="fas fa-envelope me-2"></i>Email Address</label>
                                <input type="email" class="form-control" name="email" value="<?= $d['email']; ?>" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold"><i class="fab fa-whatsapp me-2"></i>WhatsApp</label>
                                <input type="text" class="form-control" name="whatsapp" value="<?= $d['whatsapp']; ?>" required>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold"><i class="fas fa-fish me-2"></i>Kategori Lomba</label>
                                <select class="form-select" name="lomba">
                                    <option value="Galatama Lele" <?= $d['lomba'] == 'Galatama Lele' ? 'selected' : '' ?>>Galatama Lele</option>
                                    <option value="Ikan Mas" <?= $d['lomba'] == 'Ikan Mas' ? 'selected' : '' ?>>Ikan Mas</option>
                                    <option value="Wild Fishing" <?= $d['lomba'] == 'Wild Fishing' ? 'selected' : '' ?>>Wild Fishing</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold"><i class="fas fa-users me-2"></i>Asal Komunitas</label>
                            <input type="text" class="form-control" name="sekolah" value="<?= $d['sekolah']; ?>" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold"><i class="fas fa-venus-mars me-2"></i>Gender</label>
                                <select class="form-select" name="gender">
                                    <option value="Laki-laki" <?= $d['gender'] == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                                    <option value="Perempuan" <?= $d['gender'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold"><i class="fas fa-calendar-alt me-2"></i>Tanggal Lahir</label>
                                <input type="date" class="form-control" name="tgl_lahir" value="<?= $d['tgl_lahir']; ?>" required>
                            </div>
                        </div>

                        <div class="mb-5">
                            <label class="form-label fw-bold"><i class="fas fa-map-marker-alt me-2"></i>Alamat Lengkap</label>
                            <textarea class="form-control" name="alamat" rows="3" required><?= $d['alamat']; ?></textarea>
                        </div>

                        <div class="text-center">
                            <button name="update" type="submit" class="btn btn-update w-100 mb-3">
                                <i class="fas fa-save me-2"></i> PERBARUI DATA SEKARANG
                            </button>
                            <a href="admin.php?pass=<?= $password_rahasia ?>" class="btn-back">
                                <i class="fas fa-arrow-left me-1"></i> Kembali ke Dashboard
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            <p class="text-center footer-text">
                &copy; 2026 Secured Admin System • Tournament Caster ID
            </p>
        </div>
    </div>
</div>

<script>
    // 1. Menghilangkan Preloader saat halaman selesai dimuat (Efek Masuk)
    window.addEventListener('load', function() {
        const loader = document.getElementById('preloader');
        loader.style.opacity = '0';
        setTimeout(() => {
            loader.style.visibility = 'hidden';
        }, 800);
    });

    // 2. Efek Fade-Out khusus saat klik tombol "Kembali ke Dashboard"
    document.querySelector('.btn-back').addEventListener('click', function(e) {
        e.preventDefault(); // Tahan proses pindah halaman
        const targetUrl = this.getAttribute('href');
        
        // Buat body memudar
        document.body.style.opacity = "0";
        
        // Pindah halaman setelah 0.5 detik (sesuai durasi transition di CSS body)
        setTimeout(() => {
            window.location.href = targetUrl;
        }, 500);
    });
</script>

</body>
</html>