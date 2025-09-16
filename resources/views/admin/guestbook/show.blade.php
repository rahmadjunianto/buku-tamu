@extends('adminlte::page')

@section('title', 'Detail Tamu')

@section('content_header')
    <h1>Detail Tamu</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Informasi Tamu</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Nama</th>
                            <td>{{ $guest->nama }}</td>
                        </tr>
                        <tr>
                            <th>Telepon</th>
                            <td>{{ $guest->telepon ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Instansi</th>
                            <td>{{ $guest->instansi ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Keperluan</th>
                            <td>{{ $guest->keperluan }}</td>
                        </tr>
                        <tr>
                            <th>Bidang</th>
                            <td>{{ $guest->bidangInfo->nama ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Check In</th>
                            <td>{{ $guest->check_in_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                        <tr>
                            <th>Check Out</th>
                            <td>
                                @if($guest->check_out_at)
                                    {{ $guest->check_out_at->format('d/m/Y H:i:s') }}
                                @else
                                    <span class="badge badge-warning">Belum Checkout</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Durasi Kunjungan</th>
                            <td>
                                @if($guest->duration_minutes)
                                    {{ floor($guest->duration_minutes / 60) }} jam {{ $guest->duration_minutes % 60 }} menit
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('admin.guestbook.edit', $guest->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            @if(!$guest->check_out_at)
                <form method="POST" action="{{ route('admin.guestbook.checkout', $guest->id) }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-success" onclick="return confirm('Yakin checkout tamu ini?')">
                        <i class="fas fa-sign-out-alt"></i> Checkout
                    </button>
                </form>
            @endif
            <a href="{{ route('admin.guestbook.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
@stop
