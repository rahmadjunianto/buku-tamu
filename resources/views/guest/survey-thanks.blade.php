@extends('guest.layout')

@section('title','Terima Kasih - Survey')

@section('content')
<div class="single-page-wrapper">
  <div class="success-section">
    <div class="success-container" style="max-width:700px;margin:0 auto;text-align:center;padding:20px;">
      <div class="success-icon" style="margin-bottom:12px;"><i class="fas fa-check-circle"></i></div>
      <h2>Terima kasih!</h2>
      <p>Terima kasih atas waktu dan masukan Anda. Masukan akan membantu kami meningkatkan pelayanan.</p>
      <a href="{{ route('guest.form') }}" class="btn-primary" style="margin-top:16px;display:inline-block;">Kembali ke Form</a>
    </div>
  </div>
</div>
@endsection
