<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Aplikasi Absensi Siswa</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .landing-card {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .school-logo {
            max-width: 150px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="landing-card p-5 text-center">
                    <!-- Ganti dengan logo sekolah Anda -->
                    <img src="https://via.placeholder.com/150" alt="Logo Sekolah" class="school-logo">
                    <h1 class="fw-bold mb-3">Aplikasi Absensi Siswa</h1>
                    <p class="lead text-muted mb-4">
                        Sistem presensi modern dan efisien menggunakan QR Code untuk memantau kehadiran siswa secara real-time.
                    </p>
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                        <i class="bi bi-box-arrow-in-right"></i> Masuk ke Sistem
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>