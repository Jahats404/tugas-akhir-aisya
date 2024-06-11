@extends('layouts.app')

@section('content')
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
            <div class="welcome-text">
                <h4>Hi, Selamat Datang {{ Auth::user()->name }}</h4>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-sm-6">
            <div class="card">
                <div class="stat-widget-two card-body">
                    <div class="stat-content">
                        <div class="stat-text">Arsip Pendidikan</div>
                        <div class="stat-digit"></div>
                    </div>
                    <h1>{{ $countpendidikan }}</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card">
                <div class="stat-widget-two card-body">
                    <div class="stat-content">
                        <div class="stat-text">Arsip Kependudukan </div>
                        <div class="stat-digit"></div>
                    </div>
                    <h1>{{ $countkependudukan }}</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card">
                <div class="stat-widget-two card-body">
                    <div class="stat-content">
                        <div class="stat-text">Arsip Kesehatan</div>
                        <div class="stat-digit"></div>
                    </div>
                    <h1>{{ $countkesehatan }}</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card">
                <div class="stat-widget-two card-body">
                    <div class="stat-content">
                        <div class="stat-text">Arsip Pribadi</div>
                        <div class="stat-digit"></div>
                    </div>
                    <h1>{{ $countpribadi }}</h1>
                </div>
            </div>
            <!-- /# card -->
        </div>
        <!-- /# column -->
    </div>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Chart boss</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-12 col-lg-8">
                            <canvas id="chartKecamatan" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-7 col-lg-7 col-md-7">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Peta Kecamatan</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-12 col-lg-8">
                            @include('admin.layout-map')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-5 col-lg-5 col-md-5">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Chart Doughnut Arsip</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-12 col-lg-8">
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('vendor/chart.js/Chart.bundle.min.js') }}"></script>
    <script>
        var ctx = document.getElementById('chartKecamatan').getContext('2d');
    
        // Data nama wilayah dari variabel $kecamatan
        var kecamatanData = @json($namaKecamatan->pluck('nama'));
        var kecamatanKode = @json($kodeKecamatan->pluck('kode'));
        var kecamatanCount = @json($totalKecamatan->pluck('total'));
    
    
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: kecamatanData,
                datasets: [{
                    label: 'Diagram Kecamatan',
                    data: kecamatanCount,
                    backgroundColor: ['rgba(100, 73, 237, 0.5)', 'rgba(100, 73, 237, 0.75)',
                        'rgba(100, 73, 237, 1.0)', 'rgba(0, 0, 139, 0.75)', 'rgba(0, 0, 139, 1.0)',
                        'rgba(222, 235, 135, 0.75)', 'rgba(222, 235, 135, 1.0)',
                        'rgba(255, 247, 80, 0.75)', 'rgba(255, 247, 80, 1.0)',
                        'rgba(220, 193, 60, 0.75)', 'rgba(220, 193, 60, 1.0)',
                        'rgba(95, 249, 160, 0.5)', 'rgba(95, 249, 160, 0.75)',
                        'rgba(95, 249, 160, 1.0)', 'rgba(127, 255, 0, 0.5)', 'rgba(127, 255, 0, 0.75)',
                        'rgba(127, 255, 0, 1.0)', 'rgba(119, 120, 153, 0.5)',
                        'rgba(119, 120, 153, 0.75)', 'rgba(119, 120, 153, 1.0)',
                        'rgba(176, 12, 222, 0.5)', 'rgba(176, 12, 222, 0.75)',
                        'rgba(176, 12, 222, 1.0)', 'rgba(144, 14, 144, 0.75)', 'rgba(144, 14, 144, 1.0)'
                    ],
                    borderColor: ['rgba(100, 73, 237, 0.5)', 'rgba(100, 73, 237, 0.75)',
                        'rgba(100, 73, 237, 1.0)', 'rgba(0, 0, 139, 0.75)', 'rgba(0, 0, 139, 1.0)',
                        'rgba(222, 235, 135, 0.75)', 'rgba(222, 235, 135, 1.0)',
                        'rgba(255, 247, 80, 0.75)', 'rgba(255, 247, 80, 1.0)',
                        'rgba(220, 193, 60, 0.75)', 'rgba(220, 193, 60, 1.0)',
                        'rgba(95, 249, 160, 0.5)', 'rgba(95, 249, 160, 0.75)',
                        'rgba(95, 249, 160, 1.0)', 'rgba(127, 255, 0, 0.5)', 'rgba(127, 255, 0, 0.75)',
                        'rgba(127, 255, 0, 1.0)', 'rgba(119, 120, 153, 0.5)',
                        'rgba(119, 120, 153, 0.75)', 'rgba(119, 120, 153, 1.0)',
                        'rgba(176, 12, 222, 0.5)', 'rgba(176, 12, 222, 0.75)',
                        'rgba(176, 12, 222, 1.0)', 'rgba(144, 14, 144, 0.75)', 'rgba(144, 14, 144, 1.0)'
                    ],
                    borderWidth: 1
                }]
            },
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var ctx = document.getElementById('myChart').getContext('2d');
            var data = @json($data);
            new Chart(ctx, {
                type: 'doughnut',
                data: data,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Doughnut Chart Example'
                        }
                    }
                },
            });
        });
    </script>
@endsection
