@extends('adminlte::page')

@section('title', 'Laporan Kunjungan')

@section('content_header')
    <h1>Laporan Kunjungan</h1>
@stop

@section('content')
    <!-- Filter -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Filter Laporan</h3>
        </div>
        <form method="GET" action="{{ route('admin.reports.index') }}">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="start_date">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $startDate }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="end_date">Tanggal Akhir</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $endDate }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="bidang_id">Bidang</label>
                            <select class="form-control" id="bidang_id" name="bidang_id">
                                <option value="">Semua Bidang</option>
                                @foreach($bidangs as $bidang)
                                    <option value="{{ $bidang->id }}" {{ $bidangId == $bidang->id ? 'selected' : '' }}>
                                        {{ $bidang->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Filter
                                </button>
                                <a href="{{ route('admin.reports.export', request()->query()) }}" class="btn btn-success">
                                    <i class="fas fa-download"></i> Export CSV
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Statistik -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalTamu }}</h3>
                    <p>Total Tamu</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $tamuSelesai }}</h3>
                    <p>Sudah Checkout</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $tamuBelumSelesai }}</h3>
                    <p>Belum Checkout</p>
                </div>
                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $rataRataDurasi ? round($rataRataDurasi) : 0 }}</h3>
                    <p>Rata-rata Durasi (menit)</p>
                </div>
                <div class="icon">
                    <i class="fas fa-stopwatch"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik per Bidang -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Statistik per Bidang</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Bidang</th>
                            <th>Jumlah Tamu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($statistikBidang as $stat)
                        <tr>
                            <td>{{ $stat->bidangInfo->nama ?? '-' }}</td>
                            <td>{{ $stat->total }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="text-center">Tidak ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Data Tamu -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Kunjungan ({{ $startDate }} - {{ $endDate }})</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Telepon</th>
                            <th>Instansi</th>
                            <th>Keperluan</th>
                            <th>Bidang</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Durasi</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($guests as $guest)
                        <tr>
                            <td>{{ $loop->iteration + ($guests->currentPage() - 1) * $guests->perPage() }}</td>
                            <td>{{ $guest->nama }}</td>
                            <td>{{ $guest->telepon ?? '-' }}</td>
                            <td>{{ $guest->instansi ?? '-' }}</td>
                            <td>{{ $guest->keperluan }}</td>
                            <td>{{ $guest->bidangInfo->nama ?? '-' }}</td>
                            <td>{{ $guest->check_in_at->format('d/m/Y H:i') }}</td>
                            <td>
                                @if($guest->check_out_at)
                                    {{ $guest->check_out_at->format('d/m/Y H:i') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if($guest->duration_minutes)
                                    {{ floor($guest->duration_minutes / 60) }}j {{ $guest->duration_minutes % 60 }}m
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if($guest->check_out_at)
                                    <span class="badge badge-success">Selesai</span>
                                @else
                                    <span class="badge badge-warning">Belum Selesai</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center">Tidak ada data kunjungan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $guests->appends(request()->query())->links() }}
        </div>
    </div>
@stop
