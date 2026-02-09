<?php
  include "koneksi.php";

  // Set zona waktu agar jam 100% akurat sesuai WIB
  date_default_timezone_set('Asia/Jakarta');

  if(isset($_POST['pendaftaran'])){
    // 1. Ambil data dan bersihkan
    $email     = mysqli_real_escape_string($koneksi, $_POST['email']);
    $nama      = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $tgl_lahir = mysqli_real_escape_string($koneksi, $_POST['tgl_lahir']);
    $gender    = mysqli_real_escape_string($koneksi, $_POST['gender']);
    $lomba     = mysqli_real_escape_string($koneksi, $_POST['lomba']);
    $sekolah   = mysqli_real_escape_string($koneksi, $_POST['sekolah']);
    $whatsapp  = mysqli_real_escape_string($koneksi, $_POST['whatsapp']);
    $alamat    = mysqli_real_escape_string($koneksi, $_POST['alamat']);

    // 2. Query Simpan ke Database
    $query  = "INSERT INTO peserta (email, nama, tgl_lahir, gender, lomba, sekolah, whatsapp, alamat) 
               VALUES ('$email', '$nama', '$tgl_lahir', '$gender', '$lomba', '$sekolah', '$whatsapp', '$alamat')";
    
    $result = mysqli_query($koneksi, $query);
    
    if($result){
      $nomor_panitia = "628889184648"; 
      
      $pesan_wa  = "🏆 *KONFIRMASI PENDAFTARAN CASTING* 🏆%0A";
      $pesan_wa .= "-------------------------------------------%0A";
      $pesan_wa .= "Halo Panitia Tournament! 🎣🔥%0A%0A";
      $pesan_wa .= "Saya telah melakukan registrasi via Website dengan data sebagai berikut:%0A%0A";
      $pesan_wa .= "👤 *Nama Caster :* " . strtoupper($nama) . "%0A";
      $pesan_wa .= "🎯 *Kategori Lomba :* $lomba%0A";
      $pesan_wa .= "🛡️ *Komunitas/Asal :* $sekolah%0A";
      $pesan_wa .= "📅 *Waktu Daftar :* " . date('d-m-Y | H:i') . " WIB%0A%0A";
      $pesan_wa .= "-------------------------------------------%0A";
      $pesan_wa .= "Mohon segera diverifikasi ya Min! 🙏%0A";
      $pesan_wa .= "Siap beraksi dan *Salam Strike!* 🐟⚡";

      echo "<script>
              alert('✅ PENDAFTARAN BERHASIL! \\n\\nData Anda telah tersimpan. Langkah terakhir, silahkan klik OK untuk mengirim bukti pendaftaran ke WhatsApp Panitia.');
              window.location.href = 'https://api.whatsapp.com/send?phone=$nomor_panitia&text=$pesan_wa';
            </script>";
    } else {
      echo "<script>alert('❌ Gagal daftar! Error: " . mysqli_error($koneksi) . "');</script>";
    }
  } 
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrasi Angler Lomba Mancing</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <style>
    /* --- ANIMASI OPENING BERKELAS --- */
    #preloader {
      position: fixed;
      top: 0; left: 0; width: 100%; height: 100%;
      background: radial-gradient(circle at center, #1a4a6e 0%, #0f2027 100%);
      display: flex; justify-content: center; align-items: center;
      z-index: 9999;
      transition: all 1s cubic-bezier(0.77, 0, 0.175, 1);
    }
    
    .opening-content {
      text-align: center;
      animation: zoomIn 1.5s ease-out forwards;
    }

    .logo-icon {
      font-size: 4rem;
      color: #2a9d8f;
      text-shadow: 0 0 20px rgba(42, 157, 143, 0.6);
      margin-bottom: 20px;
      animation: pulseGlow 2s infinite;
    }

    .brand-name {
      color: white;
      font-weight: 800;
      letter-spacing: 8px;
      text-transform: uppercase;
      font-size: 1.2rem;
      margin-bottom: 10px;
      display: block;
      opacity: 0;
      animation: slideUp 0.8s ease-out 0.5s forwards;
    }

    .loading-bar-container {
      width: 200px;
      height: 2px;
      background: rgba(255,255,255,0.1);
      margin: 20px auto;
      overflow: hidden;
      border-radius: 10px;
    }

    .loading-bar-fill {
      width: 0%;
      height: 100%;
      background: #2a9d8f;
      box-shadow: 0 0 10px #2a9d8f;
      animation: progressMove 2.5s infinite;
    }

    @keyframes zoomIn {
      from { transform: scale(0.8); opacity: 0; }
      to { transform: scale(1); opacity: 1; }
    }

    @keyframes slideUp {
      from { transform: translateY(20px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }

    @keyframes pulseGlow {
      0% { transform: scale(1); text-shadow: 0 0 20px rgba(42, 157, 143, 0.6); }
      50% { transform: scale(1.1); text-shadow: 0 0 40px rgba(42, 157, 143, 0.9); }
      100% { transform: scale(1); text-shadow: 0 0 20px rgba(42, 157, 143, 0.6); }
    }

    @keyframes progressMove {
      0% { width: 0%; }
      50% { width: 70%; }
      100% { width: 100%; }
    }

    /* --- GAYA HALAMAN --- */
    body { 
      background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), 
                  url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1920&q=80'); 
      background-size: cover;
      background-attachment: fixed;
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      overflow-x: hidden;
      transition: opacity 0.6s ease;
    }

    .fade-in-page {
      animation: fadeIn 1.5s ease-in-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .content-wrapper { flex: 1; }

    .card { border: none; border-radius: 25px; background: rgba(255, 255, 255, 0.98); backdrop-filter: blur(10px); box-shadow: 0 20px 40px rgba(0,0,0,0.4); overflow: hidden; }
    .card-header { background: linear-gradient(135deg, #0f2027, #203a43, #2c5364); color: white; padding: 35px; border: none !important; }
    .btn-primary { background: #2a9d8f; border: none; padding: 12px 35px; border-radius: 50px; font-weight: bold; transition: 0.3s; box-shadow: 0 5px 15px rgba(42, 157, 143, 0.3); }
    .btn-primary:hover { background: #1a4a6e; transform: translateY(-3px); }
    .form-label { font-weight: 600; color: #1a4a6e; }
    .form-control, .form-select { border-radius: 10px; border: 1px solid #ddd; padding: 10px 15px; transition: 0.3s; }
    .form-control:focus { border-color: #2a9d8f; box-shadow: 0 0 0 0.25rem rgba(42, 157, 143, 0.2); }

    footer {
        background: rgba(15, 32, 39, 0.9);
        backdrop-filter: blur(8px);
        color: white;
        padding: 40px 0 30px 0;
        margin-top: 60px;
        border-top: 3px solid #2a9d8f;
    }
    .footer-logo { font-size: 1.4rem; font-weight: 800; letter-spacing: 2px; color: #2a9d8f; }
    .btn-nav {
        color: white;
        text-decoration: none;
        padding: 6px 18px;
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
    .copyright {
        font-size: 0.85rem;
        opacity: 0.7;
        margin-top: 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        padding-top: 20px;
    }
  </style>
</head>
<body>

  <div id="preloader">
    <div class="opening-content">
      <div class="logo-icon">
        <i class="fas fa-fish"></i>
      </div>
      <span class="brand-name">Tournament Caster ID</span>
      <div class="loading-bar-container">
        <div class="loading-bar-fill"></div>
      </div>
      <div class="text-white-50 small text-uppercase fw-light" style="letter-spacing: 2px;">Establishing Connection</div>
    </div>
  </div>

  <div class="content-wrapper container py-5 fade-in-page">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="card shadow-lg">
          <div class="card-header text-center">
            <h2 class="mb-0 fw-bold text-uppercase"><i class="fas fa-fish me-2"></i>Form Pendaftaran Casting</h2>
            <p class="mb-0 opacity-75">Siapkan Joran Terbaikmu dan Jadilah Juara!</p>
          </div>
          <div class="card-body p-4 p-md-5">
            <form method="POST" action="">
              <div class="row">
                <div class="col-md-6 border-end">
                  <h5 class="text-secondary mb-4"><i class="fas fa-user-circle me-2"></i>Identitas Caster</h5>
                  <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" name="nama" placeholder="Contoh: Tukul Strike" required>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Email Aktif</label>
                    <input type="email" class="form-control" name="email" placeholder="email@contoh.com" required>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" name="tgl_lahir" required>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label class="form-label">Gender</label>
                        <select class="form-select" name="gender">
                          <option value="Laki-laki">Laki-laki</option>
                          <option value="Perempuan">Perempuan</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-6 ps-md-4">
                  <h5 class="text-secondary mb-4"><i class="fas fa-trophy me-2"></i>Detail Pertandingan</h5>
                  <div class="mb-3">
                    <label class="form-label">Kategori Lomba</label>
                    <select class="form-select" name="lomba" required>
                      <option value="">-- Pilih Kategori --</option>
                      <option value="Galatama Lele">Galatama Lele</option>
                      <option value="Ikan Mas">Ikan Mas</option>
                      <option value="Wild Fishing">Wild Fishing</option>
                    </select>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Asal Komunitas</label>
                    <input type="text" class="form-control" name="sekolah" placeholder="Nama Komunitas/Tim" required>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Nomor WhatsApp</label>
                    <input type="text" class="form-control" name="whatsapp" placeholder="08XXXXXXXXXX" required>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Alamat Domisili</label>
                    <textarea class="form-control" name="alamat" rows="2" placeholder="Alamat lengkap saat ini" required></textarea>
                  </div>
                </div>
              </div>

              <div class="text-center mt-4">
                <button name="pendaftaran" type="submit" class="btn btn-primary btn-lg px-5 shadow">
                   <i class="fas fa-paper-plane me-2"></i>DAFTAR SEKARANG
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <footer>
      <div class="container text-center">
          <div class="footer-logo mb-3">TOURNAMENT CASTER ID</div>
          
          <div class="mb-4">
              <a href="index.php" class="btn-nav mx-1 active">Pendaftaran</a>
              <a href="tampil_peserta.php" class="btn-nav mx-1">List Caster</a>
              <a href="kontak.php" class="btn-nav mx-1">Kontak</a>
          </div>

          <div class="copyright">
              &copy; 2026 Turnamen Casting Nasional. <br>
              <span style="color: #2a9d8f; font-weight: bold;">Salam Strike, Jangan Kasih Kendor!</span>
          </div>
      </div>
  </footer>

  <script>
    // Logic Opening Berkelas dengan sessionStorage
    window.addEventListener('load', function() {
      const loader = document.getElementById('preloader');
      
      // Cek apakah user baru pertama kali akses di sesi ini
      if (!sessionStorage.getItem('opened_once')) {
        // Tampilkan animasi penuh (2 detik) untuk "First Impression"
        setTimeout(() => {
          loader.style.opacity = '0';
          loader.style.transform = 'scale(1.2)';
          setTimeout(() => {
            loader.style.visibility = 'hidden';
          }, 1000);
        }, 2200);
        
        // Simpan tanda bahwa user sudah melihat opening
        sessionStorage.setItem('opened_once', 'true');
      } else {
        // Jika sudah pernah lihat, hilangkan dengan cepat (0.4 detik)
        loader.style.transition = '0.4s ease';
        loader.style.opacity = '0';
        setTimeout(() => {
          loader.style.visibility = 'hidden';
        }, 400);
      }
    });

    // Navigasi Smooth antar halaman (Fade-Out)
    document.querySelectorAll('.btn-nav').forEach(link => {
      link.addEventListener('click', function(e) {
        if (this.href.includes('.php')) {
          e.preventDefault();
          const target = this.href;
          document.body.style.opacity = "0";
          setTimeout(() => {
            window.location.href = target;
          }, 600);
        }
      });
    });
  </script>

</body>
</html>