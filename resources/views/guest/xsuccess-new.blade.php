@extends('guest.layout')

@section('title', 'Check-in Berhasil - SIBUTEK (Sistem Buku Tamu Elektronik) Kementerian Agama Kabupaten Nganjuk')

@section('content')
<div class="container-fluid p-0">
    <!-- Header PTSP -->
    <div class="ptsp-header">
        <div class="container">
            <div class="row align-items-center py-3">
                <div class="col-auto">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/3c/Emblem_of_the_Ministry_of_Religious_Affairs_of_the_Republic_of_Indonesia.svg/100px-Emblem_of_the_Ministry_of_Religious_Affairs_of_the_Republic_of_Indonesia.svg.png"
                         alt="Logo Kemenag" class="logo-kemenag">
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
                <div class="col-lg-10 col-xl-8">
                    <!-- Success Card -->
                    <div class="success-card">
                        <!-- Success Header -->
                        <div class="success-header text-center">
                            <div class="success-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <h1 class="success-title">Check-in Berhasil!</h1>
                            <p class="success-subtitle">Terima kasih telah berkunjung ke Kementerian Agama Nganjuk</p>
                        </div>

                        <!-- Guest Information Card -->
                        <div class="guest-info-section">
                            <div class="section-header">
                                <h5 class="section-title">
                                    <i class="fas fa-user-circle me-2"></i>
                                    Informasi Tamu
                                </h5>
                            </div>

                            <div class="info-container">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="info-card">
                                            <div class="info-icon">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div class="info-content">
                                                <label class="info-label">Nama Lengkap</label>
                                                <div class="info-value">{{ $guest->nama }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="info-card">
                                            <div class="info-icon">
                                                <i class="fas fa-phone"></i>
                                            </div>
                                            <div class="info-content">
                                                <label class="info-label">No. Telepon</label>
                                                <div class="info-value">{{ $guest->telepon ?: '-' }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="info-card">
                                            <div class="info-icon">
                                                <i class="fas fa-building"></i>
                                            </div>
                                            <div class="info-content">
                                                <label class="info-label">Instansi</label>
                                                <div class="info-value">{{ $guest->instansi ?: '-' }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="info-card">
                                            <div class="info-icon">
                                                <i class="fas fa-sitemap"></i>
                                            </div>
                                            <div class="info-content">
                                                <label class="info-label">Bidang Tujuan</label>
                                                <div class="info-value">{{ $guest->bidangInfo->nama }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="info-card">
                                            <div class="info-icon">
                                                <i class="fas fa-clipboard-list"></i>
                                            </div>
                                            <div class="info-content">
                                                <label class="info-label">Keperluan Kunjungan</label>
                                                <div class="info-value">{{ $guest->keperluan }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="info-card highlight">
                                            <div class="info-icon">
                                                <i class="fas fa-clock"></i>
                                            </div>
                                            <div class="info-content">
                                                <label class="info-label">Waktu Check-in</label>
                                                <div class="info-value">{{ $guest->check_in_at->format('d F Y, H:i') }} WIB</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="action-section">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <a href="{{ route('guest.form') }}" class="btn btn-outline-success btn-lg w-100">
                                        <i class="fas fa-plus me-2"></i>
                                        Daftar Tamu Lain
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <button onclick="window.print()" class="btn btn-success btn-lg w-100">
                                        <i class="fas fa-print me-2"></i>
                                        Cetak Bukti
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Important Notice -->
                        <div class="notice-section">
                            <div class="notice-card">
                                <div class="notice-icon">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                                <div class="notice-content">
                                    <h6 class="notice-title">Penting!</h6>
                                    <p class="notice-text">Jangan lupa untuk melakukan <strong>check-out</strong> sebelum meninggalkan kantor melalui petugas keamanan atau admin.</p>
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
    position: relative;
    z-index: 1000;
}

.logo-kemenag {
    width: 60px;
    height: 60px;
    object-fit: contain;
    background: white;
    border-radius: 10px;
    padding: 5px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.success-wrapper {
    background: linear-gradient(135deg, #f8fff8 0%, #e8f5e8 100%);
    min-height: calc(100vh - 100px);
    padding: 2rem 0;
}

.success-card {
    background: white;
    border-radius: 20px;
    padding: 2.5rem;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    border: 1px solid rgba(40, 167, 69, 0.1);
    margin: 1rem 0;
    position: relative;
    overflow: hidden;
}

.success-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(135deg, #28a745, #20c997);
}

.success-header {
    margin-bottom: 2.5rem;
}

.success-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #28a745, #20c997);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem auto;
    animation: successPulse 2s infinite;
}

.success-icon i {
    font-size: 2rem;
    color: white;
}

@keyframes successPulse {
    0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.7); }
    70% { transform: scale(1.05); box-shadow: 0 0 0 20px rgba(40, 167, 69, 0); }
    100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(40, 167, 69, 0); }
}

.success-title {
    color: #1e7e34;
    font-size: 2.2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.success-subtitle {
    color: #6c757d;
    font-size: 1.1rem;
    margin-bottom: 0;
}

.guest-info-section {
    margin-bottom: 2rem;
}

.section-header {
    margin-bottom: 1.5rem;
}

.section-title {
    color: #1e7e34;
    font-weight: 600;
    margin-bottom: 0;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #e8f5e8;
}

.info-container {
    background: #f8fff8;
    border-radius: 15px;
    padding: 1.5rem;
    border: 1px solid rgba(40, 167, 69, 0.1);
}

.info-card {
    background: white;
    border-radius: 12px;
    padding: 1.25rem;
    border: 1px solid rgba(40, 167, 69, 0.1);
    transition: all 0.3s ease;
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    height: 100%;
}

.info-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(40, 167, 69, 0.1);
    border-color: rgba(40, 167, 69, 0.2);
}

.info-card.highlight {
    background: linear-gradient(135deg, #e8f5e8, #f0f8f0);
    border-color: #28a745;
    border-width: 2px;
}

.info-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #28a745, #20c997);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.info-icon i {
    font-size: 1.1rem;
    color: white;
}

.info-content {
    flex: 1;
    min-width: 0;
}

.info-label {
    font-size: 0.85rem;
    color: #6c757d;
    font-weight: 600;
    margin-bottom: 0.25rem;
    display: block;
}

.info-value {
    font-size: 1rem;
    color: #2c3e50;
    font-weight: 500;
    word-wrap: break-word;
    line-height: 1.4;
}

.action-section {
    margin: 2.5rem 0 2rem 0;
    padding-top: 2rem;
    border-top: 2px solid #e8f5e8;
}

.action-section .btn {
    border-radius: 12px;
    font-weight: 600;
    padding: 0.75rem 2rem;
    transition: all 0.3s ease;
    border-width: 2px;
}

.action-section .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.btn-success {
    background: linear-gradient(135deg, #28a745, #20c997);
    border-color: #28a745;
}

.btn-success:hover {
    background: linear-gradient(135deg, #1e7e34, #28a745);
    border-color: #1e7e34;
}

.btn-outline-success {
    color: #28a745;
    border-color: #28a745;
}

.btn-outline-success:hover {
    background: #28a745;
    border-color: #28a745;
}

.notice-section {
    margin-top: 2rem;
}

.notice-card {
    background: linear-gradient(135deg, #d4f4dd, #e8f5e8);
    border-radius: 15px;
    padding: 1.5rem;
    border: 1px solid rgba(40, 167, 69, 0.2);
    display: flex;
    align-items: flex-start;
    gap: 1rem;
}

.notice-icon {
    width: 40px;
    height: 40px;
    background: #28a745;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.notice-icon i {
    font-size: 1.1rem;
    color: white;
}

.notice-content {
    flex: 1;
}

.notice-title {
    color: #1e7e34;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.notice-text {
    color: #1e7e34;
    margin-bottom: 0;
    line-height: 1.5;
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
        border: 2px solid #28a745 !important;
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

    .info-card {
        border: 1px solid #ddd !important;
        break-inside: avoid;
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
        font-size: 1.1rem;
    }

    .ptsp-header p {
        font-size: 0.85rem;
    }

    .success-card {
        padding: 1.5rem;
        margin: 0.5rem 0;
        border-radius: 15px;
    }

    .success-title {
        font-size: 1.8rem;
    }

    .success-subtitle {
        font-size: 1rem;
    }

    .success-icon {
        width: 70px;
        height: 70px;
        margin-bottom: 1rem;
    }

    .success-icon i {
        font-size: 1.8rem;
    }

    .info-container {
        padding: 1rem;
    }

    .info-card {
        padding: 1rem;
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 0.75rem;
    }

    .info-icon {
        width: 35px;
        height: 35px;
    }

    .info-icon i {
        font-size: 1rem;
    }

    .action-section .btn {
        padding: 0.75rem 1rem;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .success-wrapper {
        padding: 1rem 0;
    }

    .notice-card {
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 1rem;
    }
}

@media (max-width: 576px) {
    .success-card {
        padding: 1rem;
        margin: 0.25rem 0;
    }

    .success-title {
        font-size: 1.5rem;
    }

    .success-subtitle {
        font-size: 0.95rem;
    }

    .success-icon {
        width: 60px;
        height: 60px;
    }

    .success-icon i {
        font-size: 1.5rem;
    }

    .section-title {
        font-size: 1rem;
    }

    .info-label {
        font-size: 0.8rem;
    }

    .info-value {
        font-size: 0.9rem;
    }

    .action-section .btn {
        padding: 0.7rem;
        font-size: 0.85rem;
    }

    .notice-card {
        padding: 1rem;
        font-size: 0.9rem;
    }

    .notice-title {
        font-size: 0.95rem;
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
        margin: 0.25rem;
        padding: 0.75rem;
    }

    .success-title {
        font-size: 1.3rem;
    }

    .success-header {
        margin-bottom: 1.5rem;
    }

    .info-container {
        padding: 0.75rem;
    }

    .info-card {
        padding: 0.75rem;
    }
}
</style>
@endsection
