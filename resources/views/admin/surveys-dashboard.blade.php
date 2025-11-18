@extends('adminlte::page')

@section('title', 'Dashboard Surveys')

@section('content_header')
    <h1>Dashboard Surveys</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Grafik Rating (Bintang)</div>
            <div class="card-body">
                <canvas id="starChart" height="120"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Distribusi Jenis Kelamin</div>
            <div class="card-body">
                <canvas id="genderChart" height="120"></canvas>
            </div>
        </div>
    </div>
</div>
<div class="row mt-3">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Distribusi Rentang Usia</div>
            <div class="card-body">
                <canvas id="ageChart" height="120"></canvas>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    fetch('{{ route('admin.surveys.data') }}')
        .then(response => response.json())
        .then(data => {
            // Star rating chart
            const starCtx = document.getElementById('starChart').getContext('2d');
            new Chart(starCtx, {
                type: 'bar',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Rata-rata Rating',
                        data: data.ratings,
                        backgroundColor: 'rgba(255,193,7,0.7)',
                        borderColor: 'rgba(255,193,7,1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let rating = context.parsed.y;
                                    let stars = '★'.repeat(Math.round(rating)) + '☆'.repeat(5 - Math.round(rating));
                                    return ` ${rating} (${stars})`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: { beginAtZero: true, max: 5 }
                    }
                }
            });

            // Gender distribution chart
            const genderCtx = document.getElementById('genderChart').getContext('2d');
            new Chart(genderCtx, {
                type: 'pie',
                data: {
                    labels: data.genderLabels,
                    datasets: [{
                        label: 'Jenis Kelamin',
                        data: data.genderCounts,
                        backgroundColor: [
                            'rgba(54,162,235,0.7)',
                            'rgba(255,99,132,0.7)',
                            'rgba(153,102,255,0.7)'
                        ],
                        borderColor: [
                            'rgba(54,162,235,1)',
                            'rgba(255,99,132,1)',
                            'rgba(153,102,255,1)'
                        ],
                        borderWidth: 1
                    }]
                }
            });

            // Age group distribution chart
            const ageCtx = document.getElementById('ageChart').getContext('2d');
            new Chart(ageCtx, {
                type: 'bar',
                data: {
                    labels: data.ageLabels,
                    datasets: [{
                        label: 'Rentang Usia',
                        data: data.ageCounts,
                        backgroundColor: 'rgba(40,167,69,0.7)',
                        borderColor: 'rgba(40,167,69,1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        });
</script>
@stop
