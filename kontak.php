<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak Panitia - Tournament Caster</title>
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
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),
                        url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-attachment: fixed;
            font-family: 'Segoe UI', sans-serif;
            color: #fff;
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            overflow-x: hidden;
            transition: opacity 0.5s ease; /* Untuk efek fade-out saat pindah */
        }

        /* Container tengah */
        .main-content {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 0;
        }

        /* Card Style */
        .contact-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(15px);
            border-radius: 25px;
            padding: 50px 40px;
            max-width: 500px;
            width: 90%;
            text-align: center;
            box-shadow: 0 20px 50px rgba(0,0,0,0.5);
            color: #333;
        }

        .icon-circle {
            width: 90px;
            height: 90px;
            background: linear-gradient(135deg, #1a4a6e, #2a9d8f);
            border-radius: 50%;
            margin: 0 auto 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: white;
            box-shadow: 0 10px 20px rgba(42, 157, 143, 0.3);
        }

        .btn-whatsapp {
            background: #25d366;
            color: white;
            padding: 15px 35px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
            transition: 0.3s;
            margin-top: 20px;
            box-shadow: 0 5px 15px rgba(37, 211, 102, 0.3);
        }

        .btn-whatsapp:hover {
            background: #128c7e;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(37, 211, 102, 0.4);
        }

        footer {
            background: rgba(15, 32, 39, 0.9);
            backdrop-filter: blur(8px);
            color: white;
            padding: 40px 0 30px 0;
            border-top: 3px solid #2a9d8f;
        }

        .footer-logo {
            font-size: 1.4rem;
            font-weight: 800;
            letter-spacing: 2px;
            color: #2a9d8f;
        }

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
        
        .status-online {
            font-size: 0.75rem;
            color: #2a9d8f;
            letter-spacing: 2px;
            margin-bottom: 15px;
            display: block;
            font-weight: 800;
        }
    </style>
</head>
<body>

<div id="preloader">
    <div class="text-center">
        <div class="loader mb-3"></div>
        <div class="text-white fw-bold small text-uppercase" style="letter-spacing: 3px;">Menghubungkan...</div>
    </div>
</div>

<div class="main-content fade-in-page">
    <div class="contact-card">
        <span class="status-online"><i class="fas fa-circle me-1"></i> PANITIA ONLINE</span>
        <div class="icon-circle">
            <i class="fas fa-headset"></i>
        </div>
        <h2 class="fw-bold mb-3">Butuh Bantuan?</h2>
        <p class="text-muted mb-4">Ada kendala pendaftaran atau ingin bertanya seputar turnamen? Tim kami siap membantu Anda kapan saja.</p>
        
        <a href="https://wa.me/628889184648" target="_blank" class="btn-whatsapp">
            <i class="fab fa-whatsapp me-2"></i> CHAT ADMIN SEKARANG
        </a>
    </div>
</div>

<footer>
    <div class="container text-center">
        <div class="footer-logo mb-3">
            TOURNAMENT CASTER ID
        </div>
        
        <div class="mb-4">
            <a href="index.php" class="btn-nav mx-1">Pendaftaran</a>
            <a href="tampil_peserta.php" class="btn-nav mx-1">List Caster</a>
            <a href="kontak.php" class="btn-nav mx-1 active">Kontak</a>
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
    document.querySelectorAll('.btn-nav').forEach(link => {
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
</script>

</body>
</html>