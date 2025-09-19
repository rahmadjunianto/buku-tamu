@extends('guest.layout')

@section('title', 'Check-in Berhasil - Buku Tamu PTSP Kemenag Nganjuk')

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

    <!-- Success Content Section -->
    <div class="success-section">
        <div class="success-container">
            <!-- Success Icon & Message -->
            <div class="success-header">
                <div class="success-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h2>Check-in Berhasil!</h2>
                <p>Terima kasih telah berkunjung ke PTSP Kemenag Nganjuk</p>
            </div>

            <!-- Guest Information Grid -->
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="info-content">
                        <label>Nama Lengkap</label>
                        <span>{{ $guest->nama ?? '-' }}</span>
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

                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-sitemap"></i>
                    </div>
                    <div class="info-content">
                        <label>Bidang Tujuan</label>
                        <span>{{ $guest->bidangInfo->nama ?? '-' }}</span>
                    </div>
                </div>

                <div class="info-item full-width">
                    <div class="info-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <div class="info-content">
                        <label>Keperluan Kunjungan</label>
                        <span>{{ $guest->keperluan ?? '-' }}</span>
                    </div>
                </div>

                <div class="info-item highlight">
                    <div class="info-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="info-content">
                        <label>Waktu Check-in</label>
                        <span>{{ $guest->check_in_at ? $guest->check_in_at->format('d F Y, H:i') : '-' }} WIB</span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="{{ route('guest.checkout', $guest->id) }}" class="btn-checkout-primary">
                    <i class="fas fa-sign-out-alt"></i>
                    Check-out Sekarang
                </a>
                <a href="#" class="btn-survey" onclick="openSurvey()">
                    <i class="fas fa-clipboard-check"></i>
                    Isi Survey Kepuasan
                </a>
                <a href="{{ route('guest.form') }}" class="btn-secondary">
                    <i class="fas fa-home"></i>
                    Kembali ke Beranda
                </a>
            </div>
            <!-- Important Notice -->
            <div class="notice">
                <div class="notice-icon">
                    <i class="fas fa-info-circle"></i>
                </div>
                <div class="notice-content">
                    <strong>Penting!</strong>
                    <span>Jangan lupa untuk melakukan check-out sebelum meninggalkan kantor.</span>
                    <div class="checkout-instruction">
                        <em>Klik link di bawah ini jika sudah selesai berkunjung:</em>
                        <a href="{{ route('guest.checkout', $guest->id) }}" class="checkout-link">
                            <i class="fas fa-external-link-alt"></i>
                            Link Check-out
                        </a>
                    </div>
                </div>
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
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
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
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.header-text h3 {
    color: white;
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: 0;
    line-height: 1.2;
}

.header-text span {
    color: rgba(255,255,255,0.9);
    font-size: 0.85rem;
    font-weight: 500;
}

/* Success Section */
.success-section {
    flex: 1;
    padding: 20px;
    overflow-y: auto;
    background: linear-gradient(135deg, #f8fff8 0%, #e8f5e8 100%);
}

.success-container {
    max-width: 1000px;
    margin: 0 auto;
    height: 100%;
    display: flex;
    flex-direction: column;
    gap: 20px;
}

/* Success Header */
.success-header {
    text-align: center;
    margin-bottom: 20px;
}

.success-icon {
    width: 60px;
    height: 60px;
    background: #28a745;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 15px;
    font-size: 1.8rem;
    color: white;
}

.success-header h2 {
    color: #1e7e34;
    font-size: 1.8rem;
    font-weight: 700;
    margin: 0 0 8px 0;
}

.success-header p {
    color: #6c757d;
    font-size: 1rem;
    margin: 0;
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
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.info-item.full-width {
    grid-column: 1 / -1;
}

.info-item.highlight {
    grid-column: 1 / -1;
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
    grid-template-columns: 1fr 1fr 1fr;
    gap: 15px;
    margin: 20px 0 15px;
}

.btn-primary, .btn-secondary, .btn-checkout-primary, .btn-survey {
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
    min-height: 48px; /* Minimum touch target for mobile */
}

.btn-primary {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
}

.btn-checkout-primary {
    background: linear-gradient(135deg, #dc3545, #e74c3c);
    color: white;
    box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
    font-weight: 700;
    position: relative;
    overflow: hidden;
}

.btn-checkout-primary::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.btn-checkout-primary:hover::before {
    left: 100%;
}

.btn-checkout-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(220, 53, 69, 0.4);
}

.btn-survey {
    background: linear-gradient(135deg, #17a2b8, #138496);
    color: white;
    box-shadow: 0 4px 15px rgba(23, 162, 184, 0.3);
    font-weight: 700;
}

.btn-survey:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(23, 162, 184, 0.4);
}

.btn-secondary {
    background: white;
    color: #28a745;
    border: 2px solid #28a745;
}

.btn-secondary:hover {
    background: #28a745;
    color: white;
    transform: translateY(-2px);
}

/* Notice */
.notice {
    background: linear-gradient(135deg, #d4f4dd, #e8f5e8);
    border-radius: 12px;
    padding: 15px;
    border: 1px solid rgba(40, 167, 69, 0.2);
    display: flex;
    align-items: flex-start;
    gap: 12px;
}

.notice-icon {
    width: 30px;
    height: 30px;
    background: #28a745;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.8rem;
    flex-shrink: 0;
    margin-top: 2px;
}

.notice-content {
    flex: 1;
    color: #1e7e34;
    font-size: 0.85rem;
    line-height: 1.4;
}

.notice-content strong {
    display: block;
    margin-bottom: 4px;
    font-weight: 700;
}

.checkout-instruction {
    margin-top: 10px;
    padding-top: 10px;
    border-top: 1px solid rgba(30, 126, 52, 0.2);
}

.checkout-instruction em {
    display: block;
    font-style: italic;
    color: #155724;
    margin-bottom: 8px;
    font-size: 0.8rem;
}

.checkout-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: #1e7e34;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.85rem;
    padding: 6px 12px;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 8px;
    border: 1px solid rgba(30, 126, 52, 0.3);
    transition: all 0.3s ease;
}

.checkout-link:hover {
    background: #1e7e34;
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(30, 126, 52, 0.3);
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

    .success-section {
        padding: 15px;
    }

    .success-header h2 {
        font-size: 1.5rem;
    }

    .success-header p {
        font-size: 0.9rem;
    }

    .info-grid {
        grid-template-columns: 1fr;
        gap: 12px;
    }

    .action-buttons {
        grid-template-columns: 1fr;
        gap: 15px;
        margin: 25px 0 20px;
    }

    .btn-primary, .btn-secondary, .btn-checkout-primary, .btn-survey {
        padding: 14px 20px;
        font-size: 1rem;
        min-height: 52px;
        font-weight: 700;
    }

    .info-item {
        padding: 12px;
    }

    .notice {
        padding: 15px;
        margin-top: 20px;
    }

    .notice-content {
        font-size: 0.85rem;
    }
}

@media (max-width: 480px) {
    .success-icon {
        width: 50px;
        height: 50px;
        font-size: 1.5rem;
    }

    .success-header h2 {
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

    .btn-primary, .btn-secondary, .btn-checkout-primary, .btn-survey {
        padding: 16px 20px;
        font-size: 1rem;
        min-height: 56px;
        border-radius: 14px;
    }

    .action-buttons {
        gap: 18px;
        margin: 30px 0 25px;
    }

    .notice {
        padding: 18px;
        border-radius: 14px;
    }

    .notice-content {
        font-size: 0.9rem;
        line-height: 1.5;
    }

    .notice-content strong {
        font-size: 1rem;
        margin-bottom: 6px;
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

    .success-section {
        background: white;
        overflow: visible;
    }

    .action-buttons {
        display: none;
    }

    .notice {
        page-break-inside: avoid;
    }
}
</style>

<script>
function openSurvey() {
    // You can customize this URL to your actual survey link
    const surveyUrl = 'https://forms.gle/your-survey-id'; // Replace with actual Google Forms or survey URL

    // Show confirmation dialog
    if (confirm('Apakah Anda ingin mengisi survey kepuasan pelayanan kami? Ini akan membuka halaman baru.')) {
        window.open(surveyUrl, '_blank');
    }
}
</script>
@endsection
