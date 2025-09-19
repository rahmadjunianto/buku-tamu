@extends('guest.layout')

@section('title', 'Checkout - PTSP Kemenag Nganjuk')

@section('content')
<div class="single-page-wrapper">
    <!-- Compact Header -->
    <div class="compact-header">
        <div class="header-content">
            <img src="{{ asset('logo-kemenag.png') }}" alt="Logo Kemenag" class="header-logo">
            <div class="header-text">
                <h3>PTSP Kemenag Nganjuk</h3>
                <span>Buku Tamu Digital</span>
            </div>
        </div>
    </div>

    <!-- Checkout Content Section -->
    <div class="checkout-section">
        <div class="checkout-container">
            <!-- Checkout Icon & Message -->
            <div class="checkout-header">
                <div class="checkout-icon">
                    @if($type == 'success')
                    <i class="fas fa-check-circle success-icon"></i>
                    @elseif($type == 'info')
                    <i class="fas fa-info-circle info-icon"></i>
                    @else
                    <i class="fas fa-exclamation-circle error-icon"></i>
                    @endif
                </div>
                <h2>
                    @if($type == 'success')
                    Checkout Berhasil!
                    @elseif($type == 'info')
                    Informasi Checkout
                    @else
                    Checkout Gagal
                    @endif
                </h2>
                <p>{{ $message }}</p>
            </div>

            <!-- Guest Information Grid -->
            @if($guest)
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="info-content">
                        <label>Nama Lengkap</label>
                        <span>{{ $guest->nama }}</span>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div class="info-content">
                        <label>No. Telepon</label>
                        <span>{{ $guest->telepon ?? '-' }}</span>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <div class="info-content">
                        <label>Instansi Asal</label>
                        <span>{{ $guest->instansi ?? '-' }}</span>
                    </div>
                </div>
                @if($guest->bidangInfo)
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-sitemap"></i>
                    </div>
                    <div class="info-content">
                        <label>Bidang Tujuan</label>
                        <span>{{ $guest->bidangInfo->nama }}</span>
                    </div>
                </div>
                @endif

                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="info-content">
                        <label>Waktu Check-in</label>
                        <span>{{ $guest->check_in_at->format('d M Y, H:i') }} WIB</span>
                    </div>
                </div>

                @if($guest->check_out_at)
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-sign-out-alt"></i>
                    </div>
                    <div class="info-content">
                        <label>Waktu Check-out</label>
                        <span>{{ $guest->check_out_at->format('d M Y, H:i') }} WIB</span>
                    </div>
                </div>
                @endif

                @if($guest->check_out_at && $guest->duration_minutes)
                <div class="info-item highlight full-width">
                    <div class="info-icon">
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                    <div class="info-content">
                        <label>Durasi Kunjungan</label>
                        <span>
                            @php
                            $hours = floor($guest->duration_minutes / 60);
                            $minutes = $guest->duration_minutes % 60;
                            @endphp
                            @if($hours > 0)
                            {{ $hours }} jam {{ $minutes }} menit
                            @else
                            {{ $minutes }} menit
                            @endif
                        </span>
                    </div>
                </div>
                @endif
            </div>
            @endif

            <!-- Action Button -->
            <div class="action-buttons">
                <a href="{{ route('guest.form') }}" class="btn-primary full-width">
                    <i class="fas fa-home"></i>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* Reset and base */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        height: 100vh;
        overflow: hidden;
        background: linear-gradient(135deg, #e8f5e8 0%, #f0f8f0 100%);
    }

    /* Single Page Layout */
    .single-page-wrapper {
        height: 100vh;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    /* Compact Header */
    .compact-header {
        background: linear-gradient(135deg, #1e7e34, #28a745);
        padding: 0.75rem 1rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        flex-shrink: 0;
    }

    .header-content {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        max-width: 1200px;
        margin: 0 auto;
    }

    .header-logo {
        width: 45px;
        height: 45px;
        background: white;
        border-radius: 8px;
        padding: 4px;
        object-fit: contain;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .header-text h3 {
        color: white;
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 0;
        line-height: 1.2;
    }

    .header-text span {
        color: rgba(255, 255, 255, 0.9);
        font-size: 0.85rem;
        font-weight: 500;
    }

    /* Checkout Section */
    .checkout-section {
        flex: 1;
        padding: 20px;
        overflow-y: auto;
        background: linear-gradient(135deg, #f8fff8 0%, #e8f5e8 100%);
    }

    .checkout-container {
        max-width: 1000px;
        margin: 0 auto;
        height: 100%;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    /* Checkout Header */
    .checkout-header {
        text-align: center;
        margin-bottom: 20px;
    }

    .checkout-icon {
        font-size: 3.5rem;
        margin-bottom: 15px;
        display: block;
    }

    .success-icon {
        color: #28a745;
    }

    .info-icon {
        color: #17a2b8;
    }

    .error-icon {
        color: #dc3545;
    }

    .checkout-header h2 {
        color: #1e7e34;
        font-size: 1.8rem;
        font-weight: 700;
        margin: 0 0 8px 0;
    }

    .checkout-header p {
        color: #6c757d;
        font-size: 1rem;
        margin: 0;
        line-height: 1.5;
    }

    /* Info Grid */
    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        flex: 1;
    }

    .info-item {
        background: white;
        border-radius: 12px;
        padding: 15px;
        border: 1px solid rgba(40, 167, 69, 0.1);
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .info-item.full-width {
        grid-column: 1 / -1;
    }

    .info-item.highlight {
        background: linear-gradient(135deg, #e8f5e8, #f0f8f0);
        border: 2px solid #28a745;
    }

    .info-icon {
        width: 35px;
        height: 35px;
        background: #28a745;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.9rem;
        flex-shrink: 0;
    }

    .info-content {
        flex: 1;
    }

    .info-content label {
        font-size: 0.8rem;
        color: #6c757d;
        font-weight: 600;
        display: block;
        margin-bottom: 4px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-content span {
        font-size: 1rem;
        color: #2c3e50;
        font-weight: 500;
        display: block;
        line-height: 1.3;
    }

    /* Action Buttons */
    .action-buttons {
        display: grid;
        grid-template-columns: 1fr;
        gap: 15px;
        margin: 20px 0 15px;
    }

    .btn-primary {
        padding: 12px 20px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.9rem;
        text-decoration: none;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.3s ease;
        text-align: center;
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
        color: white;
    }

    .full-width {
        width: 100%;
    }

    /* Mobile Responsiveness */
    @media (max-width: 768px) {
        .compact-header {
            padding: 0 15px;
        }

        .header-text h3 {
            font-size: 0.9rem;
        }

        .header-text span {
            font-size: 0.7rem;
        }

        .checkout-section {
            padding: 15px;
        }

        .checkout-header h2 {
            font-size: 1.5rem;
        }

        .checkout-header p {
            font-size: 0.9rem;
        }

        .checkout-icon {
            font-size: 3rem;
        }

        .info-grid {
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .action-buttons {
            gap: 12px;
        }

        .info-item {
            padding: 12px;
        }

        .info-item.full-width {
            grid-column: 1 / -1;
            width: 100%;
        }

        .info-item.highlight {
            margin: 10px 0;
            padding: 15px;
        }

        .info-content span {
            font-size: 0.95rem;
            font-weight: 600;
        }
    }

    @media (max-width: 480px) {
        .checkout-icon {
            font-size: 2.5rem;
        }

        .checkout-header h2 {
            font-size: 1.3rem;
        }

        .info-icon {
            width: 30px;
            height: 30px;
            font-size: 0.8rem;
        }

        .info-content label {
            font-size: 0.75rem;
        }

        .info-content span {
            font-size: 0.9rem;
        }

        .btn-primary {
            padding: 14px 20px;
            font-size: 1rem;
        }

        .info-item.highlight {
            background: linear-gradient(135deg, #e8f5e8, #f0f8f0);
            border: 2px solid #28a745;
            margin: 15px 0;
            padding: 18px;
        }

        .info-item.highlight .info-content {
            text-align: center;
        }

        .info-item.highlight .info-content label {
            font-size: 0.85rem;
            margin-bottom: 8px;
        }

        .info-item.highlight .info-content span {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1e7e34;
        }
    }

    /* Print Styles */
    @media print {
        body {
            overflow: visible;
            background: white;
        }

        .single-page-wrapper {
            height: auto;
        }

        .compact-header {
            background: #1e7e34 !important;
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
        }

        .checkout-section {
            background: white;
            overflow: visible;
        }

        .action-buttons {
            display: none;
        }
    }
</style>
@endsection