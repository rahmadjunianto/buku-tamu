@extends('guest.layout')

@section('title', 'Check-in Berhasil - Debug')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-success text-white">
            <h3>Debug Success Page</h3>
        </div>
        <div class="card-body">
            <h4>Guest Information:</h4>
            <p><strong>Nama:</strong> {{ $guest->nama ?? 'N/A' }}</p>
            <p><strong>Telepon:</strong> {{ $guest->telepon ?? 'N/A' }}</p>
            <p><strong>Instansi:</strong> {{ $guest->instansi ?? 'N/A' }}</p>
            <p><strong>Keperluan:</strong> {{ $guest->keperluan ?? 'N/A' }}</p>
            <p><strong>Bidang:</strong> {{ $guest->bidangInfo->nama ?? 'N/A' }}</p>
            <p><strong>Check-in:</strong> {{ $guest->check_in_at ? $guest->check_in_at->format('d F Y, H:i') : 'N/A' }} WIB</p>

            <hr>
            <h5>Raw Data:</h5>
            <pre>{{ print_r($guest->toArray(), true) }}</pre>
        </div>
    </div>
</div>
@endsection
