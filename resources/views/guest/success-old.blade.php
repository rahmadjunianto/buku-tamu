@extends('guest.layout')

@section('title', 'Check-in Berhasil - Buku Tamu PTSP Kemenag Nganjuk')

@section('content')
<div class="container-fluid p-0">
    <!-- Header PTSP -->
    <div class="ptsp-header">
        <div class="container">
            <div class="row align-items-center py-3">
                <div class="col-auto">
                    <img src="logo-kemenag.png"
                        alt="Logo Kemenag"
                        class="logo-kemenag"
                        style="width: 60px; height: 60px; object-fit: contain;">
                </div>
                <div class="col">
                    <h4 class="mb-0 text-white fw-bold">PTSP Kementerian Agama</h4>
                    <p class="mb-0 text-white-50">Kabupaten Nganjuk</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Content -->
    <div class="success-wrapper">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <!-- Success Card -->
                    <div class="success-card">
                        <div class="success-header">
                            <div class="success-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <h1 class="success-title">Check-in Berhasil!</h1>
                            <p class="success-subtitle">Terima kasih telah berkunjung ke PTSP Kemenag Nganjuk</p>
                        </div>

                        <!-- Guest Information -->
                        <div class="guest-info">
                            <h5 class="info-title">
                                <i class="fas fa-user-circle me-2"></i>
                                Informasi Tamu
                            </h5>

                            <div class="info-grid">
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-user text-primary"></i>
                                        Nama Lengkap
                                    </div>
                                    <div class="info-value">{{ $guest->nama }}</div>
                                </div>

                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-phone text-success"></i>
                                        No. Telepon
                                    </div>
                                    <div class="info-value">{{ $guest->telepon ?: '-' }}</div>
                                </div>

                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-building text-info"></i>
                                        Instansi
                                    </div>
                                    <div class="info-value">{{ $guest->instansi ?: '-' }}</div>
                                </div>

                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-clipboard-list text-warning"></i>
                                        Keperluan
                                    </div>
                                    <div class="info-value">{{ $guest->keperluan }}</div>
                                </div>

                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-sitemap text-danger"></i>
                                        Bidang Tujuan
                                    </div>
                                    <div class="info-value">{{ $guest->bidangInfo->nama }}</div>
                                </div>

                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-clock text-secondary"></i>
                                        Waktu Check-in
                                    </div>
                                    <div class="info-value">{{ $guest->check_in_at->format('d F Y, H:i') }} WIB</div>
                                </div>
                            </div>
                        </div>

                        <!-- Important Notice -->
                        <div class="notice-section">
                            <div class="alert alert-info border-0">
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-info-circle text-info me-3 mt-1"></i>
                                    <div>
                                        <h6 class="alert-heading mb-1">Penting!</h6>
                                        <p class="mb-0">Jangan lupa untuk melakukan <strong>check-out</strong> sebelum meninggalkan kantor melalui petugas keamanan atau admin.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
/* PTSP Kemenag Theme - Hijau */
.ptsp-header {
    background: linear-gradient(135deg, #1e7e34, #28a745);
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.logo-kemenag {
    width: 60px;
    height: 60px;
    object-fit: contain;
    background: white;
    border-radius: 10px;
    padding: 5px;
}

.success-wrapper {
    background: linear-gradient(135deg, #f8fff8 0%, #e8f5e8 100%);
    min-height: calc(100vh - 100px);
    padding: 3rem 0;
}

.success-card {
    background: white;
    border-radius: 20px;
    padding: 3rem;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    border: 1px solid rgba(255,255,255,0.2);
    margin: 2rem 0;
}

.success-header {
    text-align: center;
    margin-bottom: 3rem;
}

.success-icon {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, #28a745, #20c997);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 2rem auto;
    animation: successPulse 2s infinite;
}

.success-icon i {
    font-size: 2.5rem;
    color: white;
}

@keyframes successPulse {
    0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.7); }
    70% { transform: scale(1.05); box-shadow: 0 0 0 20px rgba(40, 167, 69, 0); }
    100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(40, 167, 69, 0); }
}

.success-title {
    color: #2c3e50;
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.success-subtitle {
    color: #6c757d;
    font-size: 1.2rem;
    margin-bottom: 0;
}

.guest-info {
    margin: 2rem 0;
}

.info-title {
    color: #2c3e50;
    font-weight: 600;
    margin-bottom: 1.5rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #e9ecef;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
}

.info-item {
    background: #f8fff8;
    border-radius: 15px;
    padding: 1.5rem;
    border-left: 4px solid #28a745;
    transition: all 0.3s ease;
}

.info-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    border-left-color: #1e7e34;
}

.info-label {
    font-size: 0.9rem;
    color: #6c757d;
    font-weight: 600;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.info-label i {
    width: 16px;
    text-align: center;
}

.info-value {
    font-size: 1.1rem;
    color: #2c3e50;
    font-weight: 500;
    word-wrap: break-word;
}

.action-section {
    margin: 3rem 0 2rem 0;
    padding-top: 2rem;
    border-top: 2px solid #e9ecef;
}

.action-section .btn {
    border-radius: 50px;
    font-weight: 600;
    padding: 0.75rem 2rem;
    transition: all 0.3s ease;
}

.action-section .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
}

.notice-section {
    margin-top: 2rem;
}

.notice-section .alert {
    background: linear-gradient(135deg, #d4f4dd, #c3e6cb);
    border-radius: 15px;
    padding: 1.5rem;
    border: 1px solid rgba(40, 167, 69, 0.2);
}

.notice-section .alert-heading {
    color: #1e7e34;
    font-weight: 700;
}

.notice-section .alert {
    color: #1e7e34;
}

/* Print Styles */
@media print {
    .ptsp-header {
        background: #1e7e34 !important;
        -webkit-print-color-adjust: exact;
        color-adjust: exact;
    }

    .action-section,
    .notice-section {
        display: none !important;
    }

    .success-card {
        box-shadow: none !important;
        border: 2px solid #ddd !important;
        page-break-inside: avoid;
    }

    .success-icon {
        background: #28a745 !important;
        -webkit-print-color-adjust: exact;
        color-adjust: exact;
    }

    body {
        background: white !important;
    }

    .success-wrapper {
        background: white !important;
        padding: 1rem 0 !important;
    }
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .ptsp-header .container {
        padding: 0 1rem;
    }

    .logo-kemenag {
        width: 50px;
        height: 50px;
    }

    .ptsp-header h4 {
        font-size: 1.2rem;
    }

    .success-card {
        padding: 2rem 1.5rem;
        margin: 1rem 0;
        border-radius: 15px;
    }

    .success-title {
        font-size: 2rem;
    }

    .success-subtitle {
        font-size: 1rem;
    }

    .success-icon {
        width: 80px;
        height: 80px;
    }

    .success-icon i {
        font-size: 2rem;
    }

    .info-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .info-item {
        padding: 1rem;
    }

    .action-section .btn {
        padding: 0.75rem 1rem;
        font-size: 0.9rem;
    }

    .success-wrapper {
        padding: 2rem 0;
    }
}

@media (max-width: 576px) {
    .success-wrapper {
        padding: 1rem 0;
    }

    .success-card {
        padding: 1.5rem 1rem;
        margin: 0.5rem 0;
    }

    .success-title {
        font-size: 1.7rem;
    }

    .success-subtitle {
        font-size: 0.95rem;
    }

    .success-icon {
        width: 70px;
        height: 70px;
        margin-bottom: 1.5rem;
    }

    .success-icon i {
        font-size: 1.8rem;
    }

    .info-label {
        font-size: 0.85rem;
    }

    .info-value {
        font-size: 1rem;
    }

    .info-item {
        padding: 0.75rem;
    }

    .action-section .btn {
        padding: 0.7rem;
        font-size: 0.85rem;
        margin-bottom: 0.5rem;
    }

    .notice-section .alert {
        padding: 1rem;
        font-size: 0.9rem;
    }
}

/* Extra small devices */
@media (max-width: 375px) {
    .ptsp-header .row {
        text-align: center;
    }

    .ptsp-header .col-auto,
    .ptsp-header .col {
        flex: 0 0 100%;
        max-width: 100%;
        margin-bottom: 0.5rem;
    }

    .ptsp-header h4 {
        font-size: 1rem;
        margin-bottom: 0.2rem;
    }

    .success-card {
        margin: 0.25rem 0;
        padding: 1.25rem 0.75rem;
    }

    .success-title {
        font-size: 1.5rem;
    }

    .success-header {
        margin-bottom: 2rem;
    }

    .info-grid {
        gap: 0.75rem;
    }
}
</style>
@endsection
