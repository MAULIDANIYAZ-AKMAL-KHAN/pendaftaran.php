<?php
include "koneksi.php";

// Set zona waktu agar jam 100% akurat sesuai WIB
date_default_timezone_set('Asia/Jakarta');

$password_rahasia = "admin2KUL";

// Cek Keamanan Akses
if (!isset($_GET['pass']) || $_GET['pass'] !== $password_rahasia) {
    die("<h1 style='text-align:center; color:white; margin-top:100px; font-family:sans-serif;'>⛔ Akses Ditolak!</h1>");
}

// --- LOGIKA HAPUS DATA ---
if(isset($_GET['hapus'])){
    $id = mysqli_real_escape_string($koneksi, $_GET['hapus']);
    $del = mysqli_query($koneksi, "DELETE FROM peserta WHERE id_peserta='$id'");
    if($del){
        echo "<script>alert('Data Berhasil Dihapus!'); window.location.href='admin.php?pass=$password_rahasia';</script>";
    }
}

// Mengambil data peserta (Urutkan dari yang terbaru daftar)
$sql = mysqli_query($koneksi, "SELECT * FROM peserta ORDER BY id_peserta DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Executive Admin Panel - Tournament Caster</title>
    
    <style>
        .loading-hidden #preloader { display: none !important; }
    </style>

    <script>
        // Mencegah loading muncul saat refresh
        if (sessionStorage.getItem('admin_session_active')) {
            document.documentElement.classList.add('loading-hidden');
        }
    </script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <style>
        :root {
            --primary-dark: #0f2027;
            --accent-green: #2ecc71;
            --gold-accent: #d4af37;
            --table-border: #dee2e6;
        }

        body {
            background: linear-gradient(rgba(0,0,0,0.65), rgba(0,0,0,0.65)), 
                        url('https://images.unsplash.com/photo-1544551763-46a013bb70d5?auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-attachment: fixed;
            font-family: 'Inter', 'Segoe UI', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* --- PRELOADER STYLE --- */
        #preloader {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: radial-gradient(circle at center, #162a31 0%, #050a0f 100%);
            display: flex; justify-content: center; align-items: center;
            z-index: 99999;
            transition: all 0.8s ease;
        }
        .outer-ring {
            position: absolute; width: 120px; height: 120px;
            border: 2px solid rgba(46, 204, 113, 0.1);
            border-top: 3px solid var(--accent-green);
            border-radius: 50%; animation: spin 2s linear infinite;
        }
        .inner-shield { font-size: 3rem; color: var(--accent-green); text-shadow: 0 0 20px rgba(46, 204, 113, 0.5); }
        @keyframes spin { 100% { transform: rotate(360deg); } }

        .content-wrapper { flex: 1; padding: 40px 15px; }

        .admin-card {
            background: rgba(255, 255, 255, 0.98);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 30px 60px rgba(0,0,0,0.5);
            border: none;
        }

        .header-admin {
            background: linear-gradient(135deg, #0f2027, #203a43);
            padding: 25px 35px;
            border-bottom: 4px solid var(--accent-green);
            color: white;
        }

        .search-box {
            background: rgba(255,255,255,0.1);
            border-radius: 8px;
            padding: 5px 15px;
            border: 1px solid rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
        }
        .search-box input {
            background: transparent; border: none; color: white;
            padding: 5px 10px; outline: none; width: 220px; font-size: 0.85rem;
        }

        /* --- TABEL RAPI & KOTAK --- */
        .table-bordered { border: 2px solid var(--table-border) !important; }
        .table-bordered th {
            background: #1c2833 !important;
            color: #ecf0f1 !important;
            font-size: 0.75rem;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            border: 2px solid var(--table-border) !important;
            padding: 15px;
            text-align: center;
        }
        .table-bordered td {
            border: 2px solid var(--table-border) !important;
            padding: 15px 10px;
            vertical-align: middle;
            text-align: center;
        }

        .btn-wa {
            width: 38px; height: 38px; border-radius: 10px;
            display: inline-flex; align-items: center; justify-content: center;
            background: #25d366; color: white; text-decoration: none;
            transition: all 0.3s ease; box-shadow: 0 4px 10px rgba(37, 211, 102, 0.3);
        }
        .btn-wa:hover { transform: translateY(-3px); color: white; }

        /* --- LUXURY FOOTER --- */
        .luxury-footer {
            background: linear-gradient(to bottom, #0f2027, #000000);
            color: white; padding: 60px 0 30px 0;
            border-top: 4px solid var(--accent-green);
        }
        .footer-brand {
            font-size: 1.8rem; font-weight: 900; letter-spacing: 4px;
            background: linear-gradient(to right, #fff, var(--accent-green));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        .footer-divider { width: 60px; height: 3px; background: var(--accent-green); margin: 20px auto; border-radius: 10px; }
        .footer-badge {
            display: inline-block; padding: 5px 15px;
            border: 1px solid rgba(46, 204, 113, 0.3);
            border-radius: 50px; background: rgba(46, 204, 113, 0.05);
            color: var(--accent-green); font-size: 0.7rem; font-weight: bold;
        }

        @media print { .no-print { display: none !important; } }
    </style>
</head>
<body>

<div id="preloader" class="no-print">
    <div class="text-center">
        <div class="position-relative mb-4 d-flex justify-content-center align-items-center" style="width:120px; height:120px; margin:auto;">
            <div class="outer-ring"></div>
            <i class="fas fa-shield-alt inner-shield"></i>
        </div>
        <div class="text-white fw-bold" style="letter-spacing: 10px; font-size: 1.2rem;">ADMIN PANEL</div>
        <div class="small text-accent-green mt-2" style="color:var(--accent-green); font-family:monospace;">SECURE SESSION...</div>
    </div>
</div>

<div class="content-wrapper container-fluid">
    <div class="admin-card mx-auto" style="max-width: 1400px;">
        <div class="header-admin d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold mb-0"><i class="fas fa-crown me-2" style="color: var(--gold-accent);"></i>ADMIN CASTING</h4>
                <p class="mb-0 small opacity-75 text-uppercase" style="letter-spacing: 2px;">Tournament Management System</p>
            </div>
            
            <div class="d-flex no-print">
                <div class="search-box me-3">
                    <i class="fas fa-search text-white-50"></i>
                    <input type="text" id="inputCari" onkeyup="cariData()" placeholder="Search caster database...">
                </div>
                <button onclick="window.print()" class="btn btn-outline-light btn-sm px-4 fw-bold">
                    <i class="fas fa-print me-2"></i>REPORTS
                </button>
            </div>
        </div>

        <div class="table-responsive p-4">
            <table class="table table-bordered table-hover mb-0" id="tabelData">
                <thead>
                    <tr>
                        <th width="50">NO</th>
                        <th>IDENTITY</th>
                        <th width="140">CONTACT</th>
                        <th>CATEGORY</th>
                        <th>COMMUNITY</th>
                        <th>RESIDENCE</th>
                        <th width="100" class="col-aksi">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; while($d = mysqli_fetch_array($sql)){ ?>
                    <tr>
                        <td class="fw-bold text-muted bg-light"><?= $no++; ?></td>
                        <td>
                            <div class="fw-bold text-dark" style="font-size: 1.05rem;"><?= strtoupper($d['nama']); ?></div>
                            <div class="text-muted" style="font-size: 0.72rem; font-style: italic;">
                                <i class="fas fa-clock text-primary me-1"></i>
                                Registered: <?php 
                                    if(isset($d['tgl_daftar'])){
                                        echo date('d M Y | H:i', strtotime($d['tgl_daftar'])) . " WIB";
                                    } else {
                                        echo "Date not recorded";
                                    }
                                ?>
                            </div>
                        </td>
                        <td>
                            <a href="https://wa.me/<?= $d['whatsapp']; ?>" target="_blank" class="btn-wa mb-1">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                            <div class="small fw-bold text-muted text-break" style="font-size: 0.65rem;"><?= $d['email']; ?></div>
                        </td>
                        <td>
                            <span class="badge bg-danger px-3 py-2 shadow-sm" style="font-size: 0.7rem;"><?= $d['lomba']; ?></span>
                        </td>
                        <td class="fw-bold text-primary" style="font-size: 0.85rem;"><?= strtoupper($d['sekolah']); ?></td>
                        <td style="font-size: 0.8rem; color: #555;">
                            <i class="fas fa-map-marked-alt text-success me-1"></i> <?= $d['alamat']; ?>
                        </td>
                        <td class="col-aksi">
                            <div class="d-flex justify-content-center gap-1">
                                <a href="edit_peserta.php?id=<?= $d['id_peserta']; ?>&pass=<?= $password_rahasia ?>" class="btn btn-sm btn-outline-primary border-0">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="admin.php?hapus=<?= $d['id_peserta']; ?>&pass=<?= $password_rahasia ?>" 
                                   onclick="return confirm('Hapus data pendaftar ini secara permanen?')" 
                                   class="btn btn-sm btn-outline-danger border-0">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="bg-light p-3 border-top text-end">
            <span class="text-muted small me-2">Authenticated as:</span>
            <span class="footer-badge">ADMIN CASTING</span>
        </div>
    </div>
</div>

<footer class="luxury-footer no-print text-center">
    <div class="container">
        <div class="footer-brand">TOURNAMENT CASTER ID</div>
        <div class="footer-divider"></div>
        <div class="row justify-content-center mb-4">
            <div class="col-md-6">
                <p class="small text-white-50" style="line-height: 1.8; max-width: 450px; margin: 0 auto;">
                    Sistem Manajemen Turnamen Casting Nasional. Data yang ditampilkan adalah aset terenkripsi yang hanya dapat diakses oleh panitia berwenang.
                </p>
            </div>
        </div>
        <div class="footer-badge mb-3">
            <i class="fas fa-check-circle me-1"></i> ENCRYPTED CONNECTION ACTIVE
        </div>
        <div class="mt-2 small opacity-25">
            &copy; 2026 Turnamen Casting Nasional • Made By 2KUL And Friends
        </div>
    </div>
</footer>

<script>
    // --- LOGIKA LOADING CERDAS ---
    window.addEventListener('load', function() {
        const loader = document.getElementById('preloader');
        if (!sessionStorage.getItem('admin_session_active')) {
            setTimeout(() => {
                loader.style.opacity = '0';
                setTimeout(() => {
                    loader.style.display = 'none';
                    sessionStorage.setItem('admin_session_active', 'true');
                }, 800);
            }, 2000); 
        } else {
            loader.style.display = 'none';
        }
    });

    function cariData() {
        let input = document.getElementById("inputCari");
        let filter = input.value.toUpperCase();
        let table = document.getElementById("tabelData");
        let tr = table.getElementsByTagName("tr");
        for (let i = 1; i < tr.length; i++) {
            let txtValue = tr[i].textContent || tr[i].innerText;
            tr[i].style.display = txtValue.toUpperCase().indexOf(filter) > -1 ? "" : "none";
        }
    }
</script>

</body>
</html>