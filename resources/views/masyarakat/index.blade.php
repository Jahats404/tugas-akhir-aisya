@extends('layouts.app')

@section('content')
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
            <div class="welcome-text">
                <h4>Hi, Selamat Datang {{ Auth::user()->masyarakat->name }}</h4>
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
                        <div class="stat-text">Arsip Kependudukan </div>
                        <div class="stat-digit"></div>
                    </div>
                    <h1>{{ $countkependudukan }}</h1>
                </div>
            </div>
        </div>
    </div>
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
