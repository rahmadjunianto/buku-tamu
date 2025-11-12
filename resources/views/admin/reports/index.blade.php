@extends('adminlte::page')

@section('title', 'Laporan Kunjungan')

@section('content_header')
    <h1>Laporan Kunjungan</h1>
@stop

@section('content')
    <!-- Filter -->
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-filter"></i> Filter Laporan</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
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
                            <label for="bidang_id">Seksi Tujuan</label>
                            <select class="form-control" id="bidang_id" name="bidang_id">
                                <option value="">Semua Seksi</option>
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
                                <button type="reset" class="btn btn-default">
                                    <i class="fas fa-undo"></i> Reset
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Export Options -->
    <div class="card card-success card-outline">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-download"></i> Export Data</h3>
        </div>
        <div class="card-body">
            <div class="d-flex align-items-center flex-column flex-sm-row">
                <div class="btn-group mb-3 mb-sm-0">
                    <a href="{{ route('admin.reports.export', array_merge(request()->query(), ['format' => 'csv'])) }}"
                       class="btn btn-success px-4 py-2">
                        <i class="fas fa-file-excel mr-2"></i> Export Excel
                    </a>
                </div>
                <div class="ml-sm-3">
                    <small class="text-muted d-flex align-items-center">
                        <i class="fas fa-info-circle mr-1"></i>
                        Data export sesuai dengan filter yang aktif
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-gradient-info">
                <div class="inner">
                    <h3>{{ $totalTamu }}</h3>
                    <p>Total Tamu</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="#" class="small-box-footer" data-toggle="tooltip" title="Total tamu dalam periode yang dipilih">
                   <i class="fas fa-info-circle"></i>  Total Tamu
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-gradient-success">
                <div class="inner">
                    <h3>
                        @if($bidangTersering)
                            {{ $bidangTersering->total }}
                        @else
                            0
                        @endif
                    </h3>
                    <p>
                        @if($bidangTersering && $bidangTersering->bidangInfo)
                            {{ $bidangTersering->bidangInfo->nama }}
                        @else
                            Seksi Paling Dikunjungi
                        @endif
                    </p>
                </div>
                <div class="icon">
                    <i class="fas fa-building"></i>
                </div>
                <a href="#" class="small-box-footer" data-toggle="tooltip" title="Seksi dengan kunjungan terbanyak pada periode ini">
                    <i class="fas fa-info-circle"></i> Seksi Paling Sering Dikunjungi
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-gradient-warning">
                <div class="inner">
                    <h3>
                        @if($hariTersibuk)
                            {{ $hariTersibuk->total }}
                        @else
                            0
                        @endif
                    </h3>
                    <p>
                        @if($hariTersibuk)
                            Tgl: {{ \Carbon\Carbon::parse($hariTersibuk->tanggal)->format('d/m/Y') }}
                        @else
                            Hari Paling Banyak Kunjungan
                        @endif
                    </p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <a href="#" class="small-box-footer" data-toggle="tooltip" title="Hari dengan kunjungan terbanyak pada periode ini">
                    <i class="fas fa-info-circle"></i> Hari Paling Banyak Kunjungan
                </a>
            </div>
        </div>
        {{-- <div class="col-lg-3 col-6">
            <div class="small-box bg-gradient-success">
                <div class="inner">
                    <h3>{{ $tamuSelesai }}</h3>
                    <p>Sudah Checkout</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <a href="#" class="small-box-footer" data-toggle="tooltip" title="Jumlah tamu yang sudah melakukan checkout">
                    Info <i class="fas fa-info-circle"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-gradient-warning">
                <div class="inner">
                    <h3>{{ $tamuBelumSelesai }}</h3>
                    <p>Belum Checkout</p>
                </div>
                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
                <a href="#" class="small-box-footer" data-toggle="tooltip" title="Jumlah tamu yang belum melakukan checkout">
                    Info <i class="fas fa-info-circle"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-gradient-danger">
                <div class="inner">
                    <h3>{{ $rataRataDurasi ? round($rataRataDurasi) : 0 }}</h3>
                    <p>Rata-rata Durasi (menit)</p>
                </div>
                <div class="icon">
                    <i class="fas fa-stopwatch"></i>
                </div>
                <a href="#" class="small-box-footer" data-toggle="tooltip" title="Rata-rata Durasi (menit) Pelayanan">
                    Info <i class="fas fa-info-circle"></i>
                </a>
            </div>
        </div> --}}
    </div>

{{--
    <!-- Chart: Distribusi Bidang -->
    <div class="card card-outline card-info">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-chart-pie"></i> Distribusi Kunjungan per Bidang</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            @php
                // Group guests by bidang name, fall back to a default label
                $byBidang = $guests->groupBy(function($g) {
                    return optional($g->bidangInfo)->nama ?? 'Tidak Ditetapkan';
                });
                $chartLabels = $byBidang->keys()->toArray();
                $chartValues = $byBidang->map->count()->values()->toArray();
            @endphp

            <div class="row">
                <div class="col-md-6">
                    <div style="height:320px;">
                        <canvas id="bidangChart" aria-label="Chart distribusi bidang" role="img" style="height:100%; width:100%; display:block;"></canvas>
                    </div>
                </div>
                <div class="col-md-6 d-flex align-items-center">
                    <div>
                        <p class="text-muted">Total kunjungan: <strong>{{ $guests->total() ?? $guests->count() }}</strong></p>
                        <ul class="list-unstyled mb-0">
                            @foreach($byBidang as $name => $group)
                                <li><span class="badge badge-pill badge-light mr-2">&nbsp;</span> {{ $name }} — <strong>{{ $group->count() }}</strong></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Data Tamu -->
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-table"></i> Data Kunjungan
                <small class="ml-2 text-muted">Periode: {{ $startDate }} - {{ $endDate }}</small>
            </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                    <i class="fas fa-expand"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="report-table" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Telepon</th>
                            <th>Instansi</th>
                            <th>Keperluan</th>
                            <th>Seksi Tujuan</th>
                            <th>Jam Masuk</th>
                            {{-- <th>Check Out</th>
                            <th>Durasi</th>
                            <th>Status</th> --}}
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
                            {{-- <td>
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
                            </td> --}}
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center">Tidak ada data kunjungan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4 d-flex justify-content-center">
                {{ $guests->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@stop

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">
<style>
    .small-box {
        border-radius: 0.5rem;
    }
    .small-box .icon {
        color: rgba(0,0,0,0.15);
    }
    .table th {
        background-color: #f4f6f9;
    }
    .badge {
        padding: 0.5em 1em;
    }
    .card-header .text-muted {
        font-size: 0.9rem;
    }
    .btn-group {
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .tooltip {
        font-size: 0.8rem;
    }

    /* DataTables & Pagination Styling */
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        margin-bottom: 0.5rem;
    }

    .dataTables_wrapper .dataTables_length select {
        min-width: 65px;
        margin: 0 0.5rem;
        padding: 0.375rem 1.75rem 0.375rem 0.75rem;
        border-radius: 0.25rem;
        border: 1px solid #ced4da;
        background-color: #fff;
    }

    .dataTables_wrapper .dataTables_filter input {
        margin-left: 0.5rem;
        padding: 0.375rem 0.75rem;
        border-radius: 0.25rem;
        border: 1px solid #ced4da;
        min-width: 200px;
    }

    .dataTables_wrapper .dataTables_info {
        padding-top: 0.5rem;
        font-size: 0.875rem;
        color: #6c757d;
    }

    /* Pagination Styling */
    .dataTables_wrapper .dataTables_paginate {
        padding-top: 0.5rem;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        margin: 0 2px;
        padding: 0.5rem 0.75rem;
        border: 1px solid #dee2e6;
        background-color: #fff;
        color: #28a745 !important;
        border-radius: 0.25rem;
        cursor: pointer;
        transition: all 0.15s ease-in-out;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current,
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        background: #28a745 !important;
        border-color: #28a745;
        color: #fff !important;
        font-weight: 600;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #e9ecef !important;
        border-color: #28a745;
        color: #1e7e34 !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
        color: #6c757d !important;
        background-color: #f8f9fa !important;
        border-color: #dee2e6;
        cursor: not-allowed;
    }

    @media (max-width: 768px) {
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            text-align: left;
            margin-bottom: 1rem;
        }

        .dataTables_wrapper .dataTables_filter input {
            margin-left: 0;
            margin-top: 0.5rem;
            width: 100%;
        }

        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            text-align: center;
            display: block;
            float: none;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0.375rem 0.5rem;
            font-size: 0.875rem;
        }
    }

    /* Export Buttons */
    .btn-group .btn {
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .btn-group .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(0,0,0,0.15);
    }
    .btn-group .btn i {
        font-size: 1.1rem;
    }
</style>
@stop

@section('js')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script> --}}
<script>
$(function () {
    // Enable tooltips
    $('[data-toggle="tooltip"]').tooltip();

    // Initialize DataTable (Laravel pagination is used, so disable DataTables paging)
    $('#report-table').DataTable({
        responsive: true,
        autoWidth: false,
        pageLength: 10,
        ordering: true,
        dom: '<"d-flex justify-content-between align-items-center mb-3"lf>rt<"d-flex justify-content-between align-items-center mt-3"ip>',
        language: {
            "sEmptyTable":  "Tidak ada data yang tersedia pada tabel ini",
            "sProcessing":  "Sedang memproses...",
            "sLengthMenu":  "Tampilkan _MENU_ entri",
            "sZeroRecords": "Tidak ditemukan data yang sesuai",
            "sInfo":        "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
            "sInfoEmpty":   "Menampilkan 0 sampai 0 dari 0 entri",
            "sInfoFiltered":"(disaring dari _MAX_ entri keseluruhan)",
            "sSearch":      "Cari:",
            "oPaginate": {
                "sFirst":    "Pertama",
                "sPrevious": "Sebelumnya",
                "sNext":     "Selanjutnya",
                "sLast":     "Terakhir"
            }
        },
        paging: false,  // Disable DataTables paging; use Laravel pagination below the table
        searching: true,
        info: false,
        order: [[6, 'desc']]
    });

    // Reset button handler: clear filters and resubmit
    $('button[type="reset"]').click(function() {
        $('#start_date').val('');
        $('#end_date').val('');
        $('#bidang_id').val('');
        setTimeout(function() {
            $('button[type="submit"]').click();
        }, 10);
    });

    // // Chart.js: render pie chart for bidang distribution
    // try {
    //     const bidangLabels = @json($chartLabels ?? []);
    //     const bidangValues = @json($chartValues ?? []);
    //     const ctxEl = document.getElementById('bidangChart');
    //     if (ctxEl && bidangLabels.length) {
    //         const ctx = ctxEl.getContext('2d');
    //         // Generate a color palette
    //         const palette = [
    //             '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796', '#5a5c69', '#2e59d9'
    //         ];
    //         const bgColors = bidangLabels.map((_, i) => palette[i % palette.length]);

    //         // Ensure the canvas element fills its parent
    //         ctxEl.style.display = 'block';

    //         new Chart(ctx, {
    //             type: 'pie',
    //             data: {
    //                 labels: bidangLabels,
    //                 datasets: [{
    //                     data: bidangValues,
    //                     backgroundColor: bgColors,
    //                     borderColor: '#fff',
    //                     borderWidth: 2
    //                 }]
    //             },
    //             options: {
    //                 responsive: true,
    //                 maintainAspectRatio: false,
    //                 plugins: {
    //                     legend: {
    //                         position: 'top'
    //                     },
    //                     tooltip: {
    //                         callbacks: {
    //                             label: function(context) {
    //                                 const label = context.label || '';
    //                                 const value = context.parsed || 0;
    //                                 return label + ': ' + value;
    //                             }
    //                         }
    //                     }
    //                 }
    //             }
    //         });
    //     }
    // } catch (e) {
    //     // Chart rendering errors shouldn't break the page
    //     console.error('Chart render error:', e);
    // }
});
</script>
@stop
