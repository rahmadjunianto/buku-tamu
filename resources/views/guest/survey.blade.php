
@extends('guest.layout')

@section('title', 'Survey Kepuasan Pelayanan')

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

  <!-- Survey Content Section (duplicated from success) -->
  <div class="success-section">
    <div class="success-container">
      <!-- Success Icon & Message -->
      <div class="success-header">
        <div class="success-icon">
          <i class="fas fa-clipboard-check"></i>
        </div>
        <h2>Survey Kepuasan Pelayanan</h2>
        <p>Terima kasih atas kunjungan Anda. Mohon luangkan 1–2 menit untuk mengisi survei ini agar kami dapat meningkatkan kualitas pelayanan.</p>
      </div>

      <!-- Survey Form inside container -->
      <div class="survey-form-wrapper">
        <form method="POST" action="{{ route('survey.store') }}">
          @csrf
          <input type="hidden" name="guest_id" value="{{ $guest->id ?? '' }}">

          <fieldset style="border:0;padding:0;margin-bottom:12px;">
            <legend style="font-weight:700;margin-bottom:8px;">A. Informasi Responden</legend>
            <div style="margin-bottom:8px;">
              <label style="display:block;font-weight:600;">Jenis Kelamin</label>
              <label><input type="radio" name="gender" value="Laki-laki" {{ old('gender')=='Laki-laki' ? 'checked' : '' }}> Laki-laki</label>
              &nbsp;
              <label><input type="radio" name="gender" value="Perempuan" {{ old('gender')=='Perempuan' ? 'checked' : '' }}> Perempuan</label>
              &nbsp;
              {{-- <label><input type="radio" name="gender" value="Lainnya" {{ old('gender')=='Lainnya' ? 'checked' : '' }}> Lainnya</label> --}}
              @error('gender')
                <div style="color:#c00;font-size:0.95em;margin-top:4px;">{{ $message }}</div>
              @enderror
            </div>
            <div style="margin-bottom:8px;">
              <label style="display:block;font-weight:600;">Usia</label>
              <select name="age_group" style="width:100%;padding:10px;border-radius:8px;border:1px solid #ddd;">
                <option value="">Pilih rentang usia</option>
                <option value="<20" {{ old('age_group')=='<20' ? 'selected' : '' }}>< 20 tahun</option>
                <option value="21-30" {{ old('age_group')=='21-30' ? 'selected' : '' }}>21–30 tahun</option>
                <option value="31-40" {{ old('age_group')=='31-40' ? 'selected' : '' }}>31–40 tahun</option>
                <option value="41-50" {{ old('age_group')=='41-50' ? 'selected' : '' }}>41–50 tahun</option>
                <option value=">" {{ old('age_group')=='>' ? 'selected' : '' }}>> 50 tahun</option>
              </select>
              @error('age_group')
                <div style="color:#c00;font-size:0.95em;margin-top:4px;">{{ $message }}</div>
              @enderror
            </div>
            <div style="margin-bottom:8px;">
              <label style="display:block;font-weight:600;">Keperluan Kunjungan</label>
              <div style="display:flex;flex-wrap:wrap;gap:8px;">
                @php
                  $options = ['Pelayanan PTSP','Konsultasi','Pengajuan dokumen','Koordinasi/rapat','Lainnya'];
                @endphp
                @foreach($options as $opt)
                  <label style="min-width:45%;"><input type="checkbox" name="purposes[]" value="{{ $opt }}" {{ (is_array(old('purposes')) && in_array($opt, old('purposes'))) ? 'checked' : '' }}> {{ $opt }}</label>
                @endforeach
              </div>
              @error('purposes')
                <div style="color:#c00;font-size:0.95em;margin-top:4px;">{{ $message }}</div>
              @enderror
              @error('purposes.*')
                <div style="color:#c00;font-size:0.95em;margin-top:4px;">{{ $message }}</div>
              @enderror
              <input type="text" name="purpose_other" value="{{ old('purpose_other') }}" placeholder="Jika Lainnya, sebutkan..." style="width:100%;padding:10px;margin-top:8px;border-radius:8px;border:1px solid #ddd;">
              @error('purpose_other')
                <div style="color:#c00;font-size:0.95em;margin-top:4px;">{{ $message }}</div>
              @enderror
            </div>
          </fieldset>

          <fieldset style="border:0;padding:0;margin-bottom:12px;">
            <legend style="font-weight:700;margin-bottom:8px;">B. Penilaian Pelayanan (1 = Sangat Tidak Puas ... 5 = Sangat Puas)</legend>
            @php
              $questions = [
                'rating_registration' => 'Kemudahan proses pendaftaran/pengecekan tamu',
                'rating_speed' => 'Kecepatan pelayanan petugas',
                'rating_friendliness' => 'Keramahan dan sikap petugas',
                'rating_clarity' => 'Kejelasan informasi yang diberikan',
                'rating_comfort' => 'Kenyamanan ruang pelayanan',
                'rating_cleanliness' => 'Kebersihan dan kerapian lingkungan',
                'rating_system' => 'Kemudahan menggunakan Sistem Buku Tamu Elektronik (SIBUTEK)',
              ];
            @endphp
            @foreach($questions as $name => $label)
              <div style="margin-bottom:10px;">
                <label style="display:block;font-weight:600;margin-bottom:6px;">{{ $label }}</label>
                <div style="display:flex;gap:8px;flex-wrap:wrap;">
                  @for($i=1;$i<=5;$i++)
                    <label style="flex:1;min-width:46px;text-align:center;">
                      <input type="radio" name="{{ $name }}" value="{{ $i }}" {{ old($name)==$i ? 'checked' : '' }}> {{ $i }}
                    </label>
                  @endfor
                </div>
                @error($name)
                  <div style="color:#c00;font-size:0.95em;margin-top:4px;">{{ $message }}</div>
                @enderror
              </div>
            @endforeach
          </fieldset>

          <fieldset style="border:0;padding:0;margin-bottom:12px;">
            <legend style="font-weight:700;margin-bottom:8px;">C. Kepuasan Keseluruhan</legend>
            <div style="display:flex;gap:8px;flex-wrap:wrap;">
              <label style="flex:1;"><input type="radio" name="rating_overall" value="1" {{ old('rating_overall')=='1' ? 'checked' : '' }}> Sangat Tidak Puas</label>
              <label style="flex:1;"><input type="radio" name="rating_overall" value="2" {{ old('rating_overall')=='2' ? 'checked' : '' }}> Tidak Puas</label>
              <label style="flex:1;"><input type="radio" name="rating_overall" value="3" {{ old('rating_overall')=='3' ? 'checked' : '' }}> Cukup Puas</label>
              <label style="flex:1;"><input type="radio" name="rating_overall" value="4" {{ old('rating_overall')=='4' ? 'checked' : '' }}> Puas</label>
              <label style="flex:1;"><input type="radio" name="rating_overall" value="5" {{ old('rating_overall')=='5' ? 'checked' : '' }}> Sangat Puas</label>
            </div>
            @error('rating_overall')
              <div style="color:#c00;font-size:0.95em;margin-top:4px;">{{ $message }}</div>
            @enderror
          </fieldset>

          <fieldset style="border:0;padding:0;margin-bottom:12px;">
            <legend style="font-weight:700;margin-bottom:8px;">D. Saran & Masukan</legend>
            <textarea name="comments" rows="4" placeholder="Tulis saran atau masukan..." style="width:100%;padding:10px;border-radius:8px;border:1px solid #ddd;">{{ old('comments') }}</textarea>
            @error('comments')
              <div style="color:#c00;font-size:0.95em;margin-top:4px;">{{ $message }}</div>
            @enderror
          </fieldset>

          <div class="action-buttons">
            <button type="submit" class="btn-primary">
              <i class="fas fa-paper-plane"></i> Kirim Survey
            </button>
          </div>
        </form>
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
  height: auto;
  display: flex;
  flex-direction: column;
  gap: 20px;
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
  padding: 24px;
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

/* Action Buttons */
.action-buttons {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 15px;
  margin: 20px 0 15px;
}

.btn-primary, .btn-secondary {
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
  min-height: 48px;
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
  .action-buttons {
    grid-template-columns: 1fr;
    gap: 15px;
    margin: 25px 0 20px;
  }
  .btn-primary, .btn-secondary {
    padding: 14px 20px;
    font-size: 1rem;
    min-height: 52px;
    font-weight: 700;
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
  .btn-primary, .btn-secondary {
    padding: 16px 20px;
    font-size: 1rem;
    min-height: 56px;
    border-radius: 14px;
  }
  .action-buttons {
    gap: 18px;
    margin: 30px 0 25px;
  }
}
</style>
@endsection
