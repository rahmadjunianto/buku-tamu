<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - PTSP Kemenag Nganjuk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-green: #28a745;
            --secondary-green: #20c997;
            --dark-green: #155724;
            --light-green: #d4edda;
        }

        body {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--secondary-green) 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .checkout-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .checkout-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 40px;
            text-align: center;
            max-width: 500px;
            width: 100%;
        }

        .checkout-icon {
            font-size: 4rem;
            margin-bottom: 20px;
        }

        .success-icon {
            color: var(--primary-green);
        }

        .info-icon {
            color: #17a2b8;
        }

        .error-icon {
            color: #dc3545;
        }

        .checkout-title {
            color: var(--dark-green);
            font-weight: 600;
            margin-bottom: 20px;
        }

        .checkout-message {
            font-size: 1.1rem;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .guest-details {
            background: var(--light-green);
            border-radius: 15px;
            padding: 20px;
            margin: 20px 0;
            text-align: left;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding: 5px 0;
            border-bottom: 1px solid rgba(40, 167, 69, 0.2);
        }

        .detail-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .detail-label {
            font-weight: 600;
            color: var(--dark-green);
        }

        .detail-value {
            color: #333;
        }

        .btn-back {
            background: linear-gradient(45deg, var(--primary-green), var(--secondary-green));
            border: none;
            color: white;
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(40, 167, 69, 0.3);
            color: white;
        }

        .time-info {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin: 15px 0;
            border-left: 4px solid var(--primary-green);
        }

        @media (max-width: 768px) {
            .checkout-card {
                padding: 30px 20px;
                margin: 10px;
            }

            .checkout-icon {
                font-size: 3rem;
            }

            .detail-row {
                flex-direction: column;
                gap: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="checkout-container">
        <div class="checkout-card">
            <!-- Icon berdasarkan tipe pesan -->
            @if($type == 'success')
                <div class="checkout-icon success-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
            @elseif($type == 'info')
                <div class="checkout-icon info-icon">
                    <i class="fas fa-info-circle"></i>
                </div>
            @else
                <div class="checkout-icon error-icon">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
            @endif

            <!-- Header -->
            <h1 class="checkout-title">
                @if($type == 'success')
                    Checkout Berhasil!
                @elseif($type == 'info')
                    Informasi Checkout
                @else
                    Checkout Gagal
                @endif
            </h1>

            <!-- Pesan -->
            <div class="checkout-message">
                {{ $message }}
            </div>

            <!-- Detail tamu jika ada -->
            @if($guest)
                <div class="guest-details">
                    <div class="detail-row">
                        <span class="detail-label"><i class="fas fa-user"></i> Nama:</span>
                        <span class="detail-value">{{ $guest->nama }}</span>
                    </div>

                    @if($guest->bidangInfo)
                    <div class="detail-row">
                        <span class="detail-label"><i class="fas fa-building"></i> Bidang:</span>
                        <span class="detail-value">{{ $guest->bidangInfo->nama }}</span>
                    </div>
                    @endif

                    <div class="detail-row">
                        <span class="detail-label"><i class="fas fa-clock"></i> Check-in:</span>
                        <span class="detail-value">{{ $guest->check_in_at->format('d M Y, H:i') }} WIB</span>
                    </div>

                    @if($guest->check_out_at)
                    <div class="detail-row">
                        <span class="detail-label"><i class="fas fa-sign-out-alt"></i> Check-out:</span>
                        <span class="detail-value">{{ $guest->check_out_at->format('d M Y, H:i') }} WIB</span>
                    </div>
                    @endif
                </div>

                @if($guest->check_out_at && $guest->duration_minutes)
                <div class="time-info">
                    <strong><i class="fas fa-hourglass-half"></i> Durasi Kunjungan:</strong>
                    @php
                        $hours = floor($guest->duration_minutes / 60);
                        $minutes = $guest->duration_minutes % 60;
                    @endphp

                    @if($hours > 0)
                        {{ $hours }} jam {{ $minutes }} menit
                    @else
                        {{ $minutes }} menit
                    @endif
                </div>
                @endif
            @endif

            <!-- Tombol kembali -->
            <div class="mt-4">
                <a href="{{ route('guest.form') }}" class="btn-back">
                    <i class="fas fa-home"></i> Kembali ke Beranda
                </a>
            </div>

            <!-- Footer -->
            <div class="mt-4 text-muted">
                <small>
                    <i class="fas fa-building"></i> PTSP Kemenag Nganjuk<br>
                    Sistem Buku Tamu Digital
                </small>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
