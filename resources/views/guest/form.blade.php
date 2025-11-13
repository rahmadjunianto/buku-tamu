@extends('guest.layout')

@section('title', 'SIBUTEK (Sistem Buku Tamu Elektronik) Kementerian Agama Kabupaten Nganjuk')

@section('content')
<div class="single-page-wrapper">
    <!-- Compact Header -->
    <div class="compact-header">
        <div class="header-content">
            <img src="{{ asset('logo-kemenag.png') }}" alt="Logo Kemenag" class="header-logo">
            <div class="header-text">
                <h3> Kementerian Agama Kabupaten Nganjuk</h3>
                <span>SIBUTEK (Sistem Buku Tamu Elektronik)</span>
            </div>
        </div>
    </div>

    <!-- Single Page Form -->
    <div class="form-section">
        <div class="form-container">
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('guest.store') }}" id="guestForm">
                @csrf

                <div class="form-row">
                    <div class="form-col">
                        <label for="nama">Nama Lengkap *</label>
                        <input type="text" id="nama" name="nama" value="{{ old('nama') }}"
                               placeholder="Nama lengkap" required>
                        @error('nama')<span class="error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-col">
                        <label for="telepon">No. Telepon</label>
                        <input type="tel" id="telepon" name="telepon" value="{{ old('telepon') }}"
                               placeholder="08xxxxxxxxxx">
                        @error('telepon')<span class="error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-col">
                        <label for="instansi">Instansi</label>
                        <input type="text" id="instansi" name="instansi" value="{{ old('instansi') }}"
                               placeholder="Nama instansi">
                        @error('instansi')<span class="error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-col">
                        <label for="bidang">Seksi Tujuan *</label>
                        <select id="bidang" name="bidang" required>
                            <option value="">Pilih Seksi</option>
                            @foreach($bidangs as $bidang)
                                <option value="{{ $bidang->id }}" {{ old('bidang') == $bidang->id ? 'selected' : '' }}>
                                    {{ $bidang->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('bidang')<span class="error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-row full-width">
                    <div class="form-col">
                        <label for="keperluan">Keperluan Kunjungan *</label>
                        <input type="text" id="keperluan" name="keperluan" value="{{ old('keperluan') }}"
                               placeholder="Jelaskan tujuan kunjungan" required>
                        @error('keperluan')<span class="error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="submit-section">
                    <button type="submit" class="submit-btn" id="submitBtn">
                        <span id="submitText">SIMPAN</span>
                    </button>
                </div>
            </form>
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
    max-width: 100vw;
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

/* Form Section */
.form-section {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
    overflow: hidden;
}

.form-container {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    width: 100%;
    max-width: 900px;
    max-height: calc(100vh - 120px);
    overflow-y: auto;
}

/* Form Layout */
.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    margin-bottom: 1rem;
}

.form-row.full-width {
    grid-template-columns: 1fr;
}

.form-col {
    display: flex;
    flex-direction: column;
}

/* Form Elements */
label {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.4rem;
    font-size: 0.9rem;
}

input, select {
    padding: 0.7rem 1rem;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    font-size: 16px; /* Prevent iOS zoom */
    transition: all 0.3s ease;
    background: white;
    min-height: 44px;
}

input:focus, select:focus {
    outline: none;
    border-color: #28a745;
    box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.1);
}

select {
    cursor: pointer;
    appearance: none;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 0.5rem center;
    background-repeat: no-repeat;
    background-size: 1.5em 1.5em;
    padding-right: 2.5rem;
}

/* Error Messages */
.error {
    color: #dc3545;
    font-size: 0.75rem;
    margin-top: 0.25rem;
}

.alert {
    background: #f8d7da;
    color: #721c24;
    padding: 0.75rem;
    border-radius: 8px;
    margin-bottom: 1rem;
    font-size: 0.9rem;
}

/* Submit Section */
.submit-section {
    margin-top: 1.5rem;
    text-align: center;
}

.submit-btn {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
    border: none;
    padding: 1rem 3rem;
    border-radius: 50px;
    font-weight: 700;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    min-width: 200px;
    min-height: 48px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.submit-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);
    background: linear-gradient(135deg, #1e7e34 0%, #17a2b8 100%);
}

.submit-btn:disabled {
    opacity: 0.7;
    transform: none;
    cursor: not-allowed;
}

/* Loading spinner */
.spinner-border-sm {
    width: 1rem;
    height: 1rem;
    border: 2px solid transparent;
    border-top: 2px solid currentColor;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .header-logo {
        width: 40px;
        height: 40px;
    }

    .header-text h3 {
        font-size: 1rem;
    }

    .header-text span {
        font-size: 0.8rem;
    }

    .form-container {
        padding: 1rem;
        margin: 0.5rem;
        max-height: calc(100vh - 100px);
    }

    .form-row {
        grid-template-columns: 1fr;
        gap: 0.75rem;
        margin-bottom: 0.75rem;
    }

    label {
        font-size: 0.85rem;
        margin-bottom: 0.3rem;
    }

    input, select {
        padding: 0.6rem 0.8rem;
        font-size: 16px;
    }

    .submit-btn {
        padding: 0.8rem 2rem;
        font-size: 0.9rem;
        min-width: 100%;
    }
}

@media (max-width: 480px) {
    .compact-header {
        padding: 0.5rem;
    }

    .header-content {
        gap: 0.75rem;
    }

    .header-logo {
        width: 35px;
        height: 35px;
    }

    .header-text h3 {
        font-size: 0.9rem;
    }

    .header-text span {
        font-size: 0.75rem;
    }

    .form-section {
        padding: 0.5rem;
    }

    .form-container {
        padding: 0.75rem;
        border-radius: 12px;
    }

    .form-row {
        gap: 0.5rem;
        margin-bottom: 0.5rem;
    }

    label {
        font-size: 0.8rem;
    }

    input, select {
        padding: 0.5rem 0.7rem;
        border-radius: 6px;
    }

    .submit-btn {
        padding: 0.7rem 1.5rem;
        font-size: 0.85rem;
        border-radius: 25px;
    }
}

/* Landscape Mobile */
@media (max-width: 768px) and (orientation: landscape) {
    .compact-header {
        padding: 0.4rem 1rem;
    }

    .header-logo {
        width: 35px;
        height: 35px;
    }

    .form-container {
        max-height: calc(100vh - 80px);
        padding: 1rem;
    }

    .form-row {
        grid-template-columns: 1fr 1fr;
        gap: 0.75rem;
        margin-bottom: 0.5rem;
    }

    .submit-section {
        margin-top: 1rem;
    }
}

/* Very Small Screens */
@media (max-width: 320px) {
    .header-text h3 {
        font-size: 0.8rem;
    }

    .form-container {
        padding: 0.5rem;
    }

    input, select {
        padding: 0.45rem 0.6rem;
        font-size: 14px;
    }

    .submit-btn {
        padding: 0.6rem 1rem;
        font-size: 0.8rem;
    }
}

/* Ensure no scroll */
html, body {
    height: 100%;
    overflow: hidden;
}
</style>
@endsection

@section('scripts')
<script>
document.getElementById('guestForm').addEventListener('submit', function(e) {
    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');

    submitBtn.disabled = true;
    submitText.innerHTML = '<span class="spinner-border-sm"></span> MEMPROSES...';
});

// Auto focus on first input
document.getElementById('nama').focus();

// Prevent form submission on Enter key except on submit button
document.addEventListener('keydown', function(e) {
    if (e.key === 'Enter' && e.target.type !== 'submit') {
        e.preventDefault();
        const form = document.getElementById('guestForm');
        const inputs = Array.from(form.querySelectorAll('input, select')).filter(input => !input.disabled);
        const currentIndex = inputs.indexOf(e.target);

        if (currentIndex < inputs.length - 1) {
            inputs[currentIndex + 1].focus();
        } else {
            document.getElementById('submitBtn').focus();
        }
    }
});

// Add visual feedback for required fields
document.querySelectorAll('input[required], select[required]').forEach(field => {
    field.addEventListener('blur', function() {
        if (!this.value.trim()) {
            this.style.borderColor = '#dc3545';
        } else {
            this.style.borderColor = '#28a745';
        }
    });

    field.addEventListener('input', function() {
        if (this.value.trim()) {
            this.style.borderColor = '#28a745';
        }
    });
});
</script>
@endsection
