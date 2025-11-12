@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $tamuHariIni }}</h3>
                    <p>Tamu Hari Ini</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $totalTamu }}</h3>
                    <p>Total Tamu</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chart-bar"></i>
                </div>
                {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
            </div>
        </div>

        <!-- ./col -->
        {{-- <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $tamuBelumCheckout }}</h3>
                    <p>Belum Checkout</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <a href="{{ route('admin.guestbook.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div> --}}
        <!-- ./col -->
        {{-- <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $totalBidang }}</h3>
                    <p>Total Seksi</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div> --}}
        <!-- ./col -->
    </div>
    <!-- /.row -->
    <!-- Chart: Distribusi per Bidang -->
    <div class="row mt-3">
        <div class="col-md-6">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-chart-pie"></i> Distribusi Kunjungan per Seksi</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    @php
                        $labels = $statistikBidang->pluck('nama')->toArray();
                        $values = $statistikBidang->pluck('guestbook_count')->toArray();
                        $total = array_sum($values);
                    @endphp
                    <div style="height:300px;">
                        <canvas id="dashboardBidangChart" style="width:100%; height:100%; display:block;"></canvas>
                    </div>
                    <ul class="list-unstyled mb-0">
                        @foreach($statistikBidang as $b)
                            @php
                                $pct = $total ? round($b->guestbook_count / $total * 100, 1) : 0;
                            @endphp
                            <li class="py-1"><strong>{{ $b->nama }}</strong>: {{ $b->guestbook_count }} (<em>{{ $pct }}%</em>)</li>
                        @endforeach
                    </ul>
                    <p class="mt-2 text-muted">Total kunjungan terdaftar: <strong>{{ $total }}</strong></p>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <style>
        /* Chart container tweaks */
        #dashboardBidangChart {
            max-height: 100%;
        }
        .card.card-outline.card-info .card-body {
            min-height: 340px;
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script>
        // Render dashboard bidang pie chart with percentages in tooltip
        document.addEventListener('DOMContentLoaded', function() {
            try {
                const labels = @json($labels ?? []);
                const values = @json($values ?? []);
                const total = {{ $total ?? 0 }};
                const el = document.getElementById('dashboardBidangChart');
                if (!el || !labels.length) return;
                const ctx = el.getContext('2d');
                const palette = ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796', '#5a5c69', '#2e59d9'];
                const bg = labels.map((_, i) => palette[i % palette.length]);

                new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: values,
                            backgroundColor: bg,
                            borderColor: '#fff',
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { position: 'top' },
                            tooltip: {
                                callbacks: {
                                    label: function(ctx) {
                                        const v = ctx.parsed || 0;
                                        const pct = total ? (v / total * 100).toFixed(1) : '0.0';
                                        return ctx.label + ': ' + v + ' (' + pct + '%)';
                                    }
                                }
                            }
                        }
                    }
                });
            } catch (e) {
                console.error('Dashboard chart error', e);
            }
        });
    </script>
@stop
