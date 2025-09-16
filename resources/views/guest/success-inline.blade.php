@extends('guest.layout')

@section('title', 'Check-in Berhasil - Buku Tamu PTSP Kemenag Nganjuk')

@section('content')
<div class="container-fluid p-0">
    <!-- Header PTSP -->
    <div style="background: linear-gradient(135deg, #1e7e34, #28a745); color: white; padding: 20px;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-auto">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/3c/Emblem_of_the_Ministry_of_Religious_Affairs_of_the_Republic_of_Indonesia.svg/100px-Emblem_of_the_Ministry_of_Religious_Affairs_of_the_Republic_of_Indonesia.svg.png"
                         alt="Logo Kemenag" style="width: 60px; height: 60px; background: white; border-radius: 10px; padding: 5px;">
                </div>
                <div class="col">
                    <h4 class="mb-0 fw-bold">PTSP Kementerian Agama</h4>
                    <p class="mb-0">Kabupaten Nganjuk</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Content -->
    <div style="background: linear-gradient(135deg, #f8fff8 0%, #e8f5e8 100%); min-height: calc(100vh - 140px); padding: 40px 0;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div style="background: white; border-radius: 20px; padding: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border-top: 4px solid #28a745;">

                        <!-- Success Header -->
                        <div class="text-center mb-4">
                            <div style="width: 80px; height: 80px; background: #28a745; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                                <i class="fas fa-check-circle" style="font-size: 2rem; color: white;"></i>
                            </div>
                            <h1 style="color: #1e7e34; font-size: 2.2rem; font-weight: 700; margin-bottom: 10px;">Check-in Berhasil!</h1>
                            <p style="color: #6c757d; font-size: 1.1rem;">Terima kasih telah berkunjung ke PTSP Kemenag Nganjuk</p>
                        </div>

                        <!-- Guest Information -->
                        <div style="background: #f8fff8; border-radius: 15px; padding: 30px; margin: 30px 0;">
                            <h5 style="color: #1e7e34; font-weight: 600; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #e8f5e8;">
                                <i class="fas fa-user-circle me-2"></i>
                                Informasi Tamu
                            </h5>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div style="background: white; border-radius: 12px; padding: 20px; border: 1px solid rgba(40, 167, 69, 0.1);">
                                        <div style="display: flex; align-items: center; gap: 15px;">
                                            <div style="width: 40px; height: 40px; background: #28a745; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-user" style="color: white;"></i>
                                            </div>
                                            <div>
                                                <label style="font-size: 0.85rem; color: #6c757d; font-weight: 600; margin-bottom: 5px; display: block;">Nama Lengkap</label>
                                                <div style="font-size: 1rem; color: #2c3e50; font-weight: 500;">{{ $guest->nama ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div style="background: white; border-radius: 12px; padding: 20px; border: 1px solid rgba(40, 167, 69, 0.1);">
                                        <div style="display: flex; align-items: center; gap: 15px;">
                                            <div style="width: 40px; height: 40px; background: #28a745; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-phone" style="color: white;"></i>
                                            </div>
                                            <div>
                                                <label style="font-size: 0.85rem; color: #6c757d; font-weight: 600; margin-bottom: 5px; display: block;">No. Telepon</label>
                                                <div style="font-size: 1rem; color: #2c3e50; font-weight: 500;">{{ $guest->telepon ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div style="background: white; border-radius: 12px; padding: 20px; border: 1px solid rgba(40, 167, 69, 0.1);">
                                        <div style="display: flex; align-items: center; gap: 15px;">
                                            <div style="width: 40px; height: 40px; background: #28a745; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-building" style="color: white;"></i>
                                            </div>
                                            <div>
                                                <label style="font-size: 0.85rem; color: #6c757d; font-weight: 600; margin-bottom: 5px; display: block;">Instansi</label>
                                                <div style="font-size: 1rem; color: #2c3e50; font-weight: 500;">{{ $guest->instansi ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div style="background: white; border-radius: 12px; padding: 20px; border: 1px solid rgba(40, 167, 69, 0.1);">
                                        <div style="display: flex; align-items: center; gap: 15px;">
                                            <div style="width: 40px; height: 40px; background: #28a745; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-sitemap" style="color: white;"></i>
                                            </div>
                                            <div>
                                                <label style="font-size: 0.85rem; color: #6c757d; font-weight: 600; margin-bottom: 5px; display: block;">Bidang Tujuan</label>
                                                <div style="font-size: 1rem; color: #2c3e50; font-weight: 500;">{{ $guest->bidangInfo->nama ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div style="background: white; border-radius: 12px; padding: 20px; border: 1px solid rgba(40, 167, 69, 0.1);">
                                        <div style="display: flex; align-items: center; gap: 15px;">
                                            <div style="width: 40px; height: 40px; background: #28a745; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-clipboard-list" style="color: white;"></i>
                                            </div>
                                            <div>
                                                <label style="font-size: 0.85rem; color: #6c757d; font-weight: 600; margin-bottom: 5px; display: block;">Keperluan Kunjungan</label>
                                                <div style="font-size: 1rem; color: #2c3e50; font-weight: 500;">{{ $guest->keperluan ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div style="background: linear-gradient(135deg, #e8f5e8, #f0f8f0); border-radius: 12px; padding: 20px; border: 2px solid #28a745;">
                                        <div style="display: flex; align-items: center; gap: 15px;">
                                            <div style="width: 40px; height: 40px; background: #28a745; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-clock" style="color: white;"></i>
                                            </div>
                                            <div>
                                                <label style="font-size: 0.85rem; color: #6c757d; font-weight: 600; margin-bottom: 5px; display: block;">Waktu Check-in</label>
                                                <div style="font-size: 1rem; color: #2c3e50; font-weight: 500;">{{ $guest->check_in_at ? $guest->check_in_at->format('d F Y, H:i') : '-' }} WIB</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="row g-3 mt-3" style="padding-top: 30px; border-top: 2px solid #e8f5e8;">
                            <div class="col-md-6">
                                <a href="{{ route('guest.form') }}" class="btn btn-outline-success btn-lg w-100" style="border-radius: 12px; font-weight: 600; padding: 12px; border-width: 2px;">
                                    <i class="fas fa-plus me-2"></i>
                                    Daftar Tamu Lain
                                </a>
                            </div>
                            <div class="col-md-6">
                                <button onclick="window.print()" class="btn btn-success btn-lg w-100" style="border-radius: 12px; font-weight: 600; padding: 12px; background: linear-gradient(135deg, #28a745, #20c997); border-color: #28a745;">
                                    <i class="fas fa-print me-2"></i>
                                    Cetak Bukti
                                </button>
                            </div>
                        </div>

                        <!-- Important Notice -->
                        <div style="background: linear-gradient(135deg, #d4f4dd, #e8f5e8); border-radius: 15px; padding: 20px; margin-top: 30px; border: 1px solid rgba(40, 167, 69, 0.2);">
                            <div style="display: flex; align-items: flex-start; gap: 15px;">
                                <div style="width: 40px; height: 40px; background: #28a745; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <i class="fas fa-info-circle" style="color: white;"></i>
                                </div>
                                <div>
                                    <h6 style="color: #1e7e34; font-weight: 700; margin-bottom: 8px;">Penting!</h6>
                                    <p style="color: #1e7e34; margin-bottom: 0; line-height: 1.5;">Jangan lupa untuk melakukan <strong>check-out</strong> sebelum meninggalkan kantor melalui petugas keamanan atau admin.</p>
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
