@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="pagetitle">
  <h1>Dashboard</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/">Home</a></li>
      <li class="breadcrumb-item active">Dashboard</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section dashboard">
  <div class="row">
  @if(auth()->user() && in_array(auth()->user()->role->name, ['Owner', 'Admin Keuangan', 'Management']))
    <!-- Row 1: Cards PENDAPATAN, PENGELUARAN, SISA UANG, dan KARYAWAN -->
    <div class="col-12">
      <div class="row">
        <!-- Pendapatan Card -->
        <div class="col-lg-3 col-md-6 mb-4">
          <div class="card info-card sales-card">
            <div class="card custom-border-left no-shadow shadow h-100 py-2">
              <div class="card-body">
                  <h5 class="card-title">PENDAPATAN <span>| HARI INI</span></h5>
                  <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                          <i class="bi bi-calendar"></i>
                      </div>
                      <div class="ps-3">
                          <h6>
                              Rp. {{ number_format($pemasukan_hari_ini, 2, ',', '.') }}
                          </h6>
                      </div>
                  </div>
                  <div class="mt-4">
                      <span class="text-muted small pt-2 ps-1">&nbsp Total: </span>
                      <span class="text-success small pt-1 fw-bold">Rp. {{ number_format($jumlahmasuk, 2, ',', '.') }}</span>
                  </div>
              </div>
          </div>
          <style>
              .custom-border-left {
                  border-left: 4px solid rgb(28, 200, 138); 
              }
              .no-shadow {
                  
                  margin-bottom: 0; 
                  padding-bottom: 0; 
              }
          </style>
          </div>
        </div>
        <!-- End Pendapatan Card -->

        <!-- Pengeluaran Card -->
        <div class="col-lg-3 col-md-6 mb-4">
          <div class="card info-card revenue-card">
              <div class="card custom-border-left-2 no-shadow shadow h-100 py-2">
                  <div class="card-body">
                      <h5 class="card-title">PENGELUARAN <span>| HARI INI</span></h5>
                      <div class="d-flex align-items-center">
                          <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                              <i class="bi bi-currency-dollar"></i>
                          </div>
                          <div class="ps-3">
                              <h6>
                                  Rp. {{ number_format($pengeluaran_hari_ini, 2, ',', '.') }}
                              </h6>
                          </div>
                      </div>
                      <div class="mt-4">
                        <span class="text-muted small pt-2 ps-1">&nbsp Total:</span>
                        <span class="text-success small pt-1 fw-bold"> Rp. {{ number_format($jumlahkeluar, 2, ',', '.') }}</span>
                      </div>
                      <style>
                          .custom-border-left-2 {
                              border-left: 4px solid rgb(231, 74, 59); 
                          }
                          .no-shadow {
                              margin-bottom: 0; 
                              padding-bottom: 0; 
                          }
                      </style>
                  </div>
              </div>
          </div>
      </div>
        <!-- End Pengeluaran Card -->

        <!-- Sisa Uang Card -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card info-card customers-card">
                <div class="card custom-border-left-3 no-shadow shadow h-100 py-2">
                    <div class="card-body">
                        <h5 class="card-title">SISA UANG</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-clipboard-check"></i>
                            </div>
                            <div class="ps-3">
                                <h6>
                                    Rp. {{ number_format($uang, 2, ',', '.') }}
                                </h6>
                            </div>
                        </div>
                        <div class="mt-2">
                        <span class="text-muted small pt-2 ps-1"></span>
                        <span class="text-success small pt-1 fw-bold"> </span>
                            <div class="progress progress-md mr-2">
                                @php
                                    if ($uang < 1) {
                                        $warna = 'danger';
                                        $value = 0;
                                    } elseif ($uang >= 1 && $uang < 1000000) {
                                        $warna = 'warning';
                                        $value = 1;
                                    } else {
                                        $warna = 'info';
                                        $value = min(100, $uang / 10000); 
                                    }
                                @endphp
                                <div class="progress-bar bg-{{ $warna }} custom-progress-bar" role="progressbar" 
                                    style="width: {{ $value }}%" aria-valuenow="{{ $value }}" 
                                    aria-valuemin="0" aria-valuemax="100">
                                    <span>{{ round($value, 2) }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <style>
                    .custom-border-left-3 {
                        border-left: 4px solid rgb(54, 185, 204);
                    }
                    .no-shadow {
                        margin-bottom: 0;
                        padding-bottom: 0;
                    }
                    .custom-progress-bar span {
                        color: white; 
                        font-weight: 600; 
                        font-size: 1.2em;
                    }
                </style>
            </div>
        </div>
        <!-- End Sisa Uang Card -->

        <!-- Karyawan Card -->
        <div class="col-lg-3 col-md-6 mb-4">
          <div class="card info-card karyawan-card">
          <div class="card custom-border-left-4 no-shadow shadow h-100 py-2">
            <div class="card-body">
              <h5 class="card-title">KARYAWAN</h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-people"></i>
                </div>
                <div class="ps-3">
                  <h6-i>{{ number_format($karyawan) }}</h6-i>
                </div>
              </div>
              <div class="mt-4">
                        <span class="text-muted small pt-2 ps-1"></span>
                        <span class="text-success small pt-1 fw-bold"> </span>
              </div>
            </div>
            </div>
            <style>
              .custom-border-left-4 {
                  border-left: 4px solid rgb(78, 115, 223); 
                }
              .no-shadow {
                  margin-bottom: 0; 
                  padding-bottom: 0; 
                }
            </style>
          </div>
        </div>
        <!-- End Karyawan Card -->
      </div>
    </div>
    <!-- End Row 1 -->

    <!-- Row 2: Recent Sales and Website Traffic -->
    <div class="col-12">
      <div class="row">
        <!-- Pendapatan Minggu Ini Card -->
        <div class="col-lg-8">
          <div class="card recent-sales overflow-auto">
                <div class="card-body">
                  <h5 class="card-title">Pendapatan Minggu Ini</h5>

                  <table class="table table-borderless datatable">
                    <thead>
                      <tr>
                        <th scope="col">No</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Jumlah</th>
                        <th scope="col">Sumber</th>
                        <th scope="col">Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <!-- Data Hari Ini -->
          <tr>
            <th scope="row"><a href="#">1</a></th>
            <td>{{ date('Y-m-d') }}</td>
            <td><a href="#" class="text-primary">Rp. {{ number_format($pemasukan_hari_ini, 0, ',', '.') }}</a></td>
            <td>{{ $pemasukan_hari_ini_data->first()->sumberPemasukan->nama ?? 'Tidak Diketahui' }}</td>
            <td><span class="badge bg-success">Approved</span></td>
          </tr>

          <!-- Data 6 Hari Sebelumnya -->
          @foreach ($pendapatan_mingguan ?? [] as $index => $item)
    @if ($item->tgl_pemasukan != date('Y-m-d'))
    <tr>
        <td>{{ $index + 2 }}</td>
        <td>{{ $item->tgl_pemasukan }}</td>
        <td><a href="#" class="text-primary">Rp. {{ number_format($item->jumlah, 0, ',', '.') }}</a></td>
        <td>{{ $item->sumberPemasukan->nama ?? 'Tidak Diketahui' }}</td>
        <td><span class="badge bg-success">Approved</span></td>
    </tr>
    @endif
@endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
            <!-- End Recent Sales -->

            <!-- Perbandingan -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body pb-0">
                    <h5 class="card-title">Perbandingan <span></span></h5>
                    <div id="comparisonChart" style="min-height: 400px;" class="echart"></div>
                    <script>
                        document.addEventListener("DOMContentLoaded", () => {
                            echarts.init(document.querySelector("#comparisonChart")).setOption({
                                tooltip: {
                                    trigger: 'item'
                                },
                                legend: {
                                    top: '5%',
                                    left: 'center'
                                },
                                color: ['rgb(46, 202, 106)', 'rgb(220, 53, 69)', 'rgb(54, 185, 204)'],
                                series: [{
                                    name: 'Perbandingan Keuangan',
                                    type: 'pie',
                                    radius: ['40%', '70%'],
                                    avoidLabelOverlap: false,
                                    label: {
                                        show: false,
                                        position: 'center'
                                    },
                                    emphasis: {
                                        label: {
                                            show: true,
                                            fontSize: '18',
                                            fontWeight: 'bold'
                                        }
                                    },
                                    labelLine: {
                                        show: false
                                    },
                                    data: [
                                        { value: {{ $jumlahmasuk }}, name: 'Pendapatan' },
                                        { value: {{ $jumlahkeluar }}, name: 'Pengeluaran' },
                                        { value: {{ $uang }}, name: 'Sisa Uang' }
                                    ]
                                }]
                            });
                        });
                    </script>

                </div>
            </div><!-- End Perbandingan -->
      </div>
</div>
<div class="col-lg-8">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Grafik Pendapatan Bulanan</h5>
            <div id="pendapatanChart" style="min-height: 400px;" class="echart"></div>
            <script>
                document.addEventListener("DOMContentLoaded", () => {
                    echarts.init(document.querySelector("#pendapatanChart")).setOption({
                        tooltip: {
                            trigger: 'axis'
                        },
                        xAxis: {
                            type: 'category',
                            data: {!! json_encode($chartLabels) !!}, 
                            axisLabel: {
                                rotate: 30,
                                fontSize: 12
                            }
                        },
                        yAxis: {
                            type: 'value',
                            axisLabel: {
                                formatter: function(value) {
                                    return 'Rp ' + value.toLocaleString('id-ID'); 
                                }
                            }
                        },
                        series: [{
                            name: 'Pendapatan',
                            type: 'line',
                            data: {!! json_encode($chartData) !!}, 
                            smooth: true,
                            color: 'rgb(46, 202, 106)',
                            lineStyle: { width: 3 },
                            areaStyle: { opacity: 0.2 } 
                        }]
                    });
                });
            </script>
        </div>
    </div>
</div>
@endif

<div class="row">
  @if(auth()->user() && in_array(auth()->user()->role->name, ['Admin Stok Barang']))
    <!-- Row 1: Cards PENDAPATAN, PENGELUARAN, SISA UANG, dan KARYAWAN -->
    <div class="col-12">
      <div class="row">
        <!-- Pendapatan Card -->
        <div class="col-lg-3 col-md-6 mb-4">
          <div class="card info-card sales-card">
            <div class="card custom-border-left no-shadow shadow h-100 py-2">
              <div class="card-body">
                  <h5 class="card-title">TOTAL BARANG MASUK</h5>
                  <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                          <i class="bi bi-calendar"></i>
                      </div>
                      <div class="ps-3">
                          <h6>
                              {{ number_format($totalStokValue) }}
                          </h6>
                      </div>
                  </div>
                  <div class="mt-4">
                        <span class="text-muted small pt-2 ps-1">Hari Ini:</span>
                        <span class="text-success small pt-1 fw-bold"> {{ number_format($totalBarangMasukHariIniValue) }}</span>
                    </div>
              </div>
          </div>
          <style>
              .custom-border-left {
                  border-left: 4px solid rgb(28, 200, 138); 
              }
              .no-shadow {
                  
                  margin-bottom: 0; 
                  padding-bottom: 0; 
              }
          </style>
          </div>
        </div>
        <!-- End Pendapatan Card -->

        <!-- Pengeluaran Card -->
        <div class="col-lg-3 col-md-6 mb-4">
          <div class="card info-card revenue-card">
              <div class="card custom-border-left-2 no-shadow shadow h-100 py-2">
                  <div class="card-body">
                      <h5 class="card-title">TOTAL BARANG KELUAR</h5>
                      <div class="d-flex align-items-center">
                          <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                              <i class="bi bi-currency-dollar"></i>
                          </div>
                          <div class="ps-3">
                          <h6>
                          {{ number_format($totalStokKeluarValue) }}
                          </h6>
                        </div>
                      </div>
                      <div class="mt-4">
                        <span class="text-muted small pt-2 ps-1">Hari Ini:</span>
                        <span class="text-success small pt-1 fw-bold"> {{ number_format($totalBarangKeluarHariIniValue) }}</span>
                    </div>
                      <style>
                          .custom-border-left-2 {
                              border-left: 4px solid rgb(231, 74, 59); 
                          }
                          .no-shadow {
                              margin-bottom: 0; 
                              padding-bottom: 0; 
                          }
                      </style>
                  </div>
              </div>
          </div>
      </div>
        <!-- End Pengeluaran Card -->
        <div class="col-lg-8">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Grafik Barang Masuk dan Keluar Bulanan</h5>
            <div id="barangChart" style="min-height: 400px;" class="echart"></div>
            <script>
                document.addEventListener("DOMContentLoaded", () => {
                    echarts.init(document.querySelector("#barangChart")).setOption({
                        tooltip: {
                            trigger: 'axis'
                        },
                        legend: {
                            data: ['Barang Masuk', 'Barang Keluar']
                        },
                        xAxis: {
                            type: 'category',
                            data: {!! json_encode($chartLabels) !!}, 
                            axisLabel: {
                                rotate: 30,
                                fontSize: 12
                            }
                        },
                        yAxis: {
                            type: 'value',
                            axisLabel: {
                                formatter: function(value) {
                                    return value.toLocaleString('id-ID');
                                }
                            }
                        },
                        series: [{
                            name: 'Barang Masuk',
                            type: 'line',
                            data: {!! json_encode($barangMasukData) !!}, 
                            smooth: true,
                            color: 'rgb(46, 202, 106)',
                            lineStyle: { width: 3 },
                            areaStyle: { opacity: 0.2 } 
                        }, {
                            name: 'Barang Keluar',
                            type: 'line',
                            data: {!! json_encode($barangKeluarData) !!}, 
                            smooth: true,
                            color: 'rgb(255, 99, 132)',
                            lineStyle: { width: 3 },
                            areaStyle: { opacity: 0.2 } 
                        }]
                    });
                });
            </script>
        </div>
    </div>
</div>

         @endif
         
</div>
        </div>
        
</section>
@endsection