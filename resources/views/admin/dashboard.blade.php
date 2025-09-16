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
                <a href="{{ route('admin.guestbook.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
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
                <a href="{{ route('admin.guestbook.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
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
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $totalBidang }}</h3>
                    <p>Total Bidang</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div>
    <!-- /.row -->

    <!-- Main row -->
    <div class="row">
        <!-- Left col -->
        <section class="col-lg-7 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-pie mr-1"></i>
                        Statistik Kunjungan
                    </h3>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content p-0">
                        <!-- Morris chart - Sales -->
                        <div class="chart tab-pane active" id="revenue-chart"
                             style="position: relative; height: 300px;">
                            <canvas id="revenue-chart-canvas" height="300" style="height: 300px;"></canvas>
                        </div>
                    </div>
                </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
        </section>
        <!-- /.Left col -->

        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-5 connectedSortable">
            <!-- Map card -->
            <div class="card bg-gradient-primary">
                <div class="card-header border-0">
                    <h3 class="card-title">
                        <i class="fas fa-map-marker-alt mr-1"></i>
                        Lokasi Pengunjung
                    </h3>
                </div>
                <div class="card-body">
                    <div id="world-map" style="height: 250px; width: 100%;"></div>
                </div>
                <!-- /.card-body-->
            </div>
            <!-- /.card -->

            <!-- solid sales graph -->
            <div class="card bg-gradient-info">
                <div class="card-header border-0">
                    <h3 class="card-title">
                        <i class="fas fa-th mr-1"></i>
                        Tamu Terbaru
                    </h3>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        @forelse($tamuTerbaru as $tamu)
                        <li>
                            <i class="far fa-circle text-white"></i>
                            {{ $tamu->nama }} - {{ $tamu->keperluan }}
                            <small class="text-white float-right">{{ $tamu->check_in_at->diffForHumans() }}</small>
                        </li>
                        @empty
                        <li>
                            <i class="far fa-circle text-white"></i>
                            Belum ada tamu hari ini
                        </li>
                        @endforelse
                    </ul>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </section>
        <!-- right col -->
    </div>
    <!-- /.row (main row) -->
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        console.log('Hi! Welcome to AdminLTE Dashboard');
    </script>
@stop
