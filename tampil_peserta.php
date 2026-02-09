<?php
include "koneksi.php";

// Set zona waktu agar jam 100% akurat sesuai WIB
date_default_timezone_set('Asia/Jakarta');

// Ambil data terbaru dari database
$sql = mysqli_query($koneksi, "SELECT * FROM peserta ORDER BY id_peserta DESC");

// Fungsi sensor privasi ketat
function sensorEmail($email) {
    $parts = explode("@", $email);
    if(count($parts) < 2) return $email;
    $masked_name = substr($parts[0], 0, 1) . str_repeat("*", 4); 
    return $masked_name . "@" . $parts[1];
}

function sensorWA($number) {
    $clean_number = preg_replace('/[^0-9]/', '', $number);
    $len = strlen($clean_number);
    if ($len <= 4) return "****";
    return substr($clean_number, 0, 2) . str_repeat("*", $len - 4) . substr($clean_number, -2);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Strike Caster - Tournament Caster</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    
    <style>
        /* --- ANIMASI PERPINDAHAN HALAMAN (IDENTIK DENGAN PENDAFTARAN) --- */
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
            border: 5px solid #2a9d8f;
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
        /* ------------------------------------------------------------- */

        body {
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), 
                        url('https://images.unsplash.com/photo-1544551763-46a013bb70d5?auto=format&fit=crop&w=1920&q=80'); 
            background-size: cover;
            background-attachment: fixed;
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            overflow-x: hidden;
            transition: opacity 0.5s ease; /* Untuk efek fade-out saat pindah */
        }

        .content-wrapper { flex: 1; }

        .card { 
            border: none; 
            border-radius: 25px; 
            background: rgba(255, 255, 255, 0.98); 
            backdrop-filter: blur(10px);
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        }

        .card-header { 
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364); 
            color: white; 
            padding: 40px 20px; 
            border: none !important;
        }

        .table-bordered {
            border: 2px solid #dee2e6 !important;
        }
        .table-bordered thead th {
            background-color: #f8f9fa !important;
            color: #1a4a6e !important;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 1px;
            padding: 15px;
            border: 2px solid #dee2e6 !important;
            text-align: center;
            vertical-align: middle;
        }
        .table-bordered td {
            border: 2px solid #dee2e6 !important;
            padding: 12px;
            vertical-align: middle;
        }

        .search-box {
            position: relative;
            max-width: 400px;
        }
        .search-box input {
            border-radius: 50px;
            padding-left: 45px;
            border: 2px solid #eee;
        }
        .search-box i {
            position: absolute;
            left: 18px;
            top: 12px;
            color: #aaa;
        }

        .badge-lomba { 
            background: #2a9d8f; 
            color: white; 
            padding: 6px 15px; 
            border-radius: 50px; 
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-block;
        }

        footer {
            background: rgba(15, 32, 39, 0.9);
            backdrop-filter: blur(8px);
            color: white;
            padding: 40px 0 30px 0;
            margin-top: 60px;
            border-top: 3px solid #2a9d8f;
        }
        .footer-logo {
            font-size: 1.4rem;
            font-weight: 800;
            letter-spacing: 2px;
            color: #2a9d8f;
        }
        .copyright {
            font-size: 0.85rem;
            opacity: 0.7;
            margin-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 20px;
        }
        .btn-nav {
            color: white;
            text-decoration: none;
            padding: 5px 15px;
            border-radius: 50px;
            border: 1px solid rgba(255,255,255,0.2);
            font-size: 0.85rem;
            transition: 0.3s;
            display: inline-block;
        }
        .btn-nav:hover, .btn-nav.active {
            background: #2a9d8f;
            border-color: #2a9d8f;
            color: white;
        }
    </style>
</head>
<body>

<div id="preloader">
    <div class="text-center">
        <div class="loader mb-3"></div>
        <div class="text-white fw-bold small text-uppercase" style="letter-spacing: 3px;">Memuat Data Caster...</div>
    </div>
</div>

<div class="content-wrapper container py-5 fade-in-page">
    <div class="row justify-content-center">
        <div class="col-xl-11">
            <div class="card shadow-lg">
                <div class="card-header text-center">
                    <h2 class="mb-1 fw-bold text-uppercase"><i class="fas fa-trophy me-2"></i>List Strike Caster</h2>
                    <p class="mb-0 opacity-75 fw-light text-uppercase">Data Pendaftar Turnamen Casting Nasional</p>
                </div>
                
                <div class="card-body p-4 p-md-5">
                    <div class="row g-3 mb-4 align-items-center">
                        <div class="col-md-6">
                            <div class="search-box">
                                <i class="fas fa-search"></i>
                                <input type="text" id="inputCari" class="form-control shadow-sm" placeholder="Cari nama atau komunitas..." onkeyup="filterTabel()">
                            </div>
                        </div>
                        <div class="col-md-6 text-md-end text-dark">
                            <span class="fw-bold me-3">Total: <?= mysqli_num_rows($sql); ?> Caster</span>
                            <a href="index.php" class="btn btn-primary btn-sm px-4 rounded-pill shadow-sm btn-action" style="background:#1a4a6e; border:none;">+ DAFTAR</a>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle" id="tabelCaster">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th>Caster</th>
                                    <th>WhatsApp</th>
                                    <th>Kategori</th>
                                    <th>Komunitas</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                if(mysqli_num_rows($sql) > 0){
                                    while($data = mysqli_fetch_array($sql)){
                                ?>
                                <tr class="text-center">
                                    <td class="fw-bold text-muted bg-light"><?= $no++; ?></td>
                                    <td>
                                        <div class="fw-bold text-dark text-uppercase"><?= $data['nama']; ?></div>
                                        <div class="text-muted small"><i class="far fa-envelope me-1"></i><?= sensorEmail($data['email']); ?></div>
                                    </td>
                                    <td>
                                        <code class="text-dark bg-light px-2 py-1 rounded border" style="font-size: 0.85rem;">
                                            <?= sensorWA($data['whatsapp']); ?>
                                        </code>
                                    </td>
                                    <td>
                                        <span class="badge-lomba"><?= $data['lomba']; ?></span>
                                    </td>
                                    <td class="text-secondary fw-bold" style="font-size: 0.85rem;">
                                        <i class="fas fa-users me-1"></i> <?= strtoupper($data['sekolah']); ?>
                                    </td>
                                </tr>
                                <?php 
                                    } 
                                } else {
                                    echo "<tr><td colspan='5' class='text-center py-5 text-muted'>Belum ada pendaftar.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<footer>
    <div class="container text-center">
        <div class="footer-logo mb-3">
            TOURNAMENT CASTER ID
        </div>
        
        <div class="mb-4">
            <a href="index.php" class="btn-nav mx-1">Pendaftaran</a>
            <a href="tampil_peserta.php" class="btn-nav mx-1 active">List Caster</a>
            <a href="kontak.php" class="btn-nav mx-1">Kontak</a>
        </div>

        <div class="copyright">
            &copy; 2026 Turnamen Casting Nasional. <br>
            <span style="color: #2a9d8f; font-weight: bold;">Salam Strike, Jangan Kasih Kendor!</span>
        </div>
    </div>
</footer>

<script>
// 1. Menghilangkan Preloader saat halaman selesai dimuat
window.addEventListener('load', function() {
    const loader = document.getElementById('preloader');
    loader.style.opacity = '0';
    setTimeout(() => {
        loader.style.visibility = 'hidden';
    }, 800);
});

// 2. Menambahkan efek fade-out saat mengklik link navigasi
document.querySelectorAll('.btn-nav, .btn-action').forEach(link => {
    link.addEventListener('click', function(e) {
        const target = this.getAttribute('href');
        if (target && target.includes('.php')) {
            e.preventDefault();
            document.body.style.opacity = "0";
            setTimeout(() => {
                window.location.href = target;
            }, 500);
        }
    });
});

// 3. Fungsi Filter Tabel
function filterTabel() {
    let input = document.getElementById("inputCari");
    let filter = input.value.toUpperCase();
    let table = document.getElementById("tabelCaster");
    let tr = table.getElementsByTagName("tr");

    for (let i = 1; i < tr.length; i++) {
        let tdNama = tr[i].getElementsByTagName("td")[1];
        let tdKomunitas = tr[i].getElementsByTagName("td")[4];
        
        if (tdNama || tdKomunitas) {
            let txtValue = (tdNama.textContent || tdNama.innerText) + " " + (tdKomunitas.textContent || tdKomunitas.innerText);
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}
</script>

</body>
</html>