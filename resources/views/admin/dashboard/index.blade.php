@extends('admin.layout.sidebar')

@section('title', 'Transaksi')

@section('content')
    @include('sweetalert::alert')

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Transaksi</h6>
        </div>
        <div class="card-body">
            <!-- Grafik Garis untuk Semua Status -->
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Grafik Status Pesanan</h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-area">
                                <canvas id="chartPesanan"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Script for Chart.js -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                var ctx = document.getElementById("chartPesanan").getContext('2d');
                var chartPesanan = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September",
                            "Oktober", "November", "Desember"
                        ],
                        datasets: [{
                                label: "Belum Bayar",
                                data: @json(array_values($dataPerStatus['belum bayar'])),
                                backgroundColor: "rgba(255, 99, 132, 0.2)",
                                borderColor: "rgba(255, 99, 132, 1)",
                                fill: false,
                            },
                            {
                                label: "Diproses",
                                data: @json(array_values($dataPerStatus['diproses'])),
                                backgroundColor: "rgba(54, 162, 235, 0.2)",
                                borderColor: "rgba(54, 162, 235, 1)",
                                fill: false,
                            },
                            {
                                label: "Selesai Belum Diterima",
                                data: @json(array_values($dataPerStatus['selesai belum diterima'])),
                                backgroundColor: "rgba(75, 192, 192, 0.2)",
                                borderColor: "rgba(75, 192, 192, 1)",
                                fill: false,
                            },
                            {
                                label: "Selesai Sudah Diterima",
                                data: @json(array_values($dataPerStatus['selesai sudah diterima'])),
                                backgroundColor: "rgba(153, 102, 255, 0.2)",
                                borderColor: "rgba(153, 102, 255, 1)",
                                fill: false,
                            }
                        ]
                    },
                    options: {
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                            },
                        },
                    }
                });
            </script>

        </div>
    </div>

@endsection
