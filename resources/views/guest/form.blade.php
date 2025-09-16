@extends('guest.layout')

@section('title', 'Buku Tamu PTSP Kemenag Nganjuk')

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

    <div class="form-wrapper">
        <div class="container">
            <div class="row">
                <!-- Welcome Section -->
                <div class="col-lg-6 welcome-section d-none d-lg-flex">
                    <div class="welcome-content">
                        <div class="welcome-icon">
                            <i class="fas fa-mosque"></i>
                        </div>
                        <h2>Selamat Datang di PTSP Kemenag Nganjuk</h2>
                        <p class="mb-4">
                            Pelayanan Terpadu Satu Pintu untuk kemudahan urusan keagamaan Anda
                        </p>
                        <div class="features-grid">
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <h6>Pelayanan Cepat</h6>
                                <small>Proses pendaftaran hanya 2 menit</small>
                            </div>
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <h6>Data Aman</h6>
                                <small>Data Anda tersimpan dengan aman</small>
                            </div>
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fas fa-mobile-alt"></i>
                                </div>
                                <h6>Digital Modern</h6>
                                <small>Dapat diakses dari smartphone</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Section -->
                <div class="col-lg-6 d-flex align-items-center justify-content-center p-4">
                    <div class="form-container w-100">
                        <div class="form-card">
                            <div class="form-header">
                                <h1><i class="fas fa-book-open me-3"></i>Buku Tamu Digital</h1>
                                <p>Silakan isi data diri Anda untuk melakukan check-in</p>
                            </div>

                            <div class="form-body">
                                @if(session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ session('error') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('guest.store') }}" id="guestForm">
                                    @csrf

                                    <div class="form-group">
                                        <label for="nama" class="form-label">
                                            Nama Lengkap <span class="required">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <input type="text"
                                                   class="form-control @error('nama') is-invalid @enderror"
                                                   id="nama"
                                                   name="nama"
                                                   value="{{ old('nama') }}"
                                                   placeholder="Masukkan nama lengkap Anda"
                                                   required>
                                        </div>
                                        @error('nama')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="telepon" class="form-label">Nomor Telepon</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                            <input type="tel"
                                                   class="form-control @error('telepon') is-invalid @enderror"
                                                   id="telepon"
                                                   name="telepon"
                                                   value="{{ old('telepon') }}"
                                                   placeholder="08xxxxxxxxxx">
                                        </div>
                                        @error('telepon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="instansi" class="form-label">Instansi/Perusahaan</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-building"></i></span>
                                            <input type="text"
                                                   class="form-control @error('instansi') is-invalid @enderror"
                                                   id="instansi"
                                                   name="instansi"
                                                   value="{{ old('instansi') }}"
                                                   placeholder="Nama instansi atau perusahaan">
                                        </div>
                                        @error('instansi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="keperluan" class="form-label">
                                            Keperluan Kunjungan <span class="required">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-clipboard-list"></i></span>
                                            <input type="text"
                                                   class="form-control @error('keperluan') is-invalid @enderror"
                                                   id="keperluan"
                                                   name="keperluan"
                                                   value="{{ old('keperluan') }}"
                                                   placeholder="Jelaskan tujuan kunjungan Anda"
                                                   required>
                                        </div>
                                        @error('keperluan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="bidang" class="form-label">
                                            Bidang yang Dituju <span class="required">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-sitemap"></i></span>
                                            <select class="form-control @error('bidang') is-invalid @enderror"
                                                    id="bidang"
                                                    name="bidang"
                                                    required>
                                                <option value="">Pilih bidang yang akan dikunjungi</option>
                                                @foreach($bidangs as $bidang)
                                                    <option value="{{ $bidang->id }}" {{ old('bidang') == $bidang->id ? 'selected' : '' }}>
                                                        {{ $bidang->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('bidang')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="d-grid mt-4">
                                        <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                                            <i class="fas fa-sign-in-alt me-2"></i>
                                            <span id="submitText">Check In Sekarang</span>
                                        </button>
                                    </div>
                                </form>

                                <div class="text-center mt-3">
                                    <small class="text-muted">
                                        Dengan melakukan check-in, Anda menyetujui kebijakan privasi kami
                                    </small>
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

.form-wrapper {
    background: linear-gradient(135deg, #f8fff8 0%, #e8f5e8 100%);
    min-height: calc(100vh - 100px);
    padding: 0;
}

.welcome-section {
    background: linear-gradient(135deg, #1e7e34 0%, #28a745 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: calc(100vh - 100px);
    padding: 3rem;
}

.welcome-content {
    text-align: center;
    max-width: 400px;
}

.welcome-icon {
    width: 100px;
    height: 100px;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 2rem auto;
    backdrop-filter: blur(10px);
}

.welcome-icon i {
    font-size: 2.5rem;
    color: white;
}

.welcome-content h2 {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.welcome-content p {
    font-size: 1.1rem;
    opacity: 0.9;
    line-height: 1.6;
}

.features-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.5rem;
    margin-top: 3rem;
}

.feature-item {
    background: rgba(255,255,255,0.1);
    border-radius: 15px;
    padding: 1.5rem;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.2);
}

.feature-icon {
    width: 50px;
    height: 50px;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem auto;
}

.feature-icon i {
    font-size: 1.2rem;
    color: white;
}

.feature-item h6 {
    color: white;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.feature-item small {
    color: rgba(255,255,255,0.8);
    font-size: 0.85rem;
}

.form-container {
    max-width: 500px;
    margin: 0 auto;
}

.form-card {
    background: white;
    border-radius: 20px;
    padding: 2.5rem;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    border: 1px solid rgba(255,255,255,0.2);
    margin: 2rem 0;
}

.form-header {
    text-align: center;
    margin-bottom: 2rem;
}

.form-header h1 {
    color: #2c3e50;
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.form-header p {
    color: #6c757d;
    font-size: 1rem;
    margin-bottom: 0;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.5rem;
    font-size: 0.95rem;
}

.required {
    color: #dc3545;
}

.input-group-text {
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    color: #6c757d;
    width: 45px;
    justify-content: center;
}

.form-control {
    border: 1px solid #e9ecef;
    border-radius: 0 10px 10px 0;
    padding: 0.75rem 1rem;
    font-size: 0.95rem;
    transition: all 0.3s ease;
}

.input-group-text {
    border-radius: 10px 0 0 10px;
}

.form-control:focus {
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40,167,69,0.25);
}

.form-control:focus + .input-group-text,
.input-group .form-control:focus ~ .input-group-text {
    border-color: #28a745;
}

.btn-primary {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    border: none;
    border-radius: 50px;
    padding: 0.75rem 2rem;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    background: linear-gradient(135deg, #1e7e34 0%, #28a745 100%);
}

.btn-primary:focus {
    box-shadow: 0 0 0 0.2rem rgba(40,167,69,0.5);
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

    .form-wrapper {
        padding: 1rem 0;
    }

    .form-card {
        padding: 2rem 1.5rem;
        margin: 1rem;
        border-radius: 15px;
    }

    .form-header h1 {
        font-size: 1.5rem;
    }

    .welcome-content h2 {
        font-size: 1.5rem;
    }

    .welcome-content {
        padding: 2rem 1rem;
    }

    .welcome-section {
        min-height: auto;
        padding: 2rem 1rem;
    }

    .features-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
        margin-top: 2rem;
    }

    .feature-item {
        padding: 1rem;
    }

    .input-group-text {
        width: 40px;
    }

    .form-control {
        font-size: 16px; /* Prevents zoom on iOS */
    }

    .btn-primary {
        padding: 0.75rem 1rem;
        font-size: 0.9rem;
        width: 100%;
    }
}

@media (max-width: 576px) {
    .form-card {
        padding: 1.5rem 1rem;
        margin: 0.5rem;
    }

    .form-header h1 {
        font-size: 1.3rem;
    }

    .form-header p {
        font-size: 0.9rem;
    }

    .input-group-text {
        width: 35px;
        font-size: 0.85rem;
    }

    .form-control {
        padding: 0.6rem 0.8rem;
        font-size: 16px; /* Prevents zoom on iOS */
    }

    .form-label {
        font-size: 0.9rem;
    }

    .btn-primary {
        padding: 0.75rem;
        font-size: 0.95rem;
    }

    .welcome-content {
        padding: 1.5rem 0.5rem;
        text-align: center;
    }

    .welcome-content h2 {
        font-size: 1.3rem;
        line-height: 1.3;
    }

    .welcome-content p {
        font-size: 0.95rem;
    }

    .welcome-icon {
        width: 80px;
        height: 80px;
        margin-bottom: 1.5rem;
    }

    .welcome-icon i {
        font-size: 2rem;
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

    .form-card {
        margin: 0.25rem;
        padding: 1rem 0.75rem;
    }

    .form-header h1 {
        font-size: 1.2rem;
    }

    .form-group {
        margin-bottom: 1.25rem;
    }
}
</style>
@endsection

@section('scripts')
<script>
document.getElementById('guestForm').addEventListener('submit', function(e) {
    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');

    submitBtn.disabled = true;
    submitText.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Sedang memproses...';
});

// Auto focus on first input
document.getElementById('nama').focus();
</script>
@endsection
