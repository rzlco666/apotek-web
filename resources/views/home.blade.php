@extends('layouts.master')

@section('title')
    Dashboard
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/chartist.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/prism.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/vector-map.css') }}">
@endsection

@section('main_content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h3>@yield('title')</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item active">@yield('title')</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid dashboard-2">
        <div class="row">
            <div class="col-xl-9 col-md-12 box-col-70 xl-70">
                <div class="row">
                    <div class="col-lg-4 col-md-6 box-col-4">
                        <div class="card profit-card">
                            <div class="card-header pb-0">
                                <div class="d-flex justify-content-between">
                                    <div class="flex-grow-1">
                                        <p class="square-after f-w-600 header-text-primary">Data Faktur<i
                                                class="fa fa-circle"> </i></p>
                                        <h4>{{ $totalFaktur }}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="right-side icon-right-primary"><i class="fa fa-inbox"></i>
                                    <div class="shap-block">
                                        <div class="rounded-shap animate-bg-primary"><i></i><i></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 box-col-4">
                        <div class="card visitor-card">
                            <div class="card-header pb-0">
                                <div class="d-flex justify-content-between">
                                    <div class="flex-grow-1">
                                        <p class="square-after f-w-600 header-text-info">Data Obat<i
                                                class="fa fa-circle"> </i></p>
                                        <h4>{{ $totalObat }}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="right-side icon-right-info"><i class="fa fa-archive"></i>
                                    <div class="shap-block">
                                        <div class="rounded-shap animate-bg-primary"><i></i><i></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 box-col-4">
                        <div class="card sell-card">
                            <div class="card-header pb-0">
                                <div class="d-flex justify-content-between">
                                    <div class="flex-grow-1">
                                        <p class="square-after f-w-600 header-text-success">Data Surat Pesanan<i
                                                class="fa fa-circle"> </i></p>
                                        <h4>{{ $totalSuratPesanan }}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="right-side icon-right-success"><i class="fa fa-file-text-o"></i>
                                    <div class="shap-block">
                                        <div class="rounded-shap animate-bg-secondary"><i></i><i></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 box-col-12">
                        <div class="card best-seller">
                            <div class="card-header pb-0">
                                <div class="d-flex justify-content-between">
                                    <div class="flex-grow-1">
                                        <p class="square-after f-w-600">Data Obat<i class="fa fa-circle"> </i></p>
                                    </div>
                                    <div class="setting-list">
                                        <ul class="list-unstyled setting-option">
                                            <li>
                                                <div class="setting-light"><i class="icon-layout-grid2"></i></div>
                                            </li>
                                            <li><i class="view-html fa fa-code font-white"></i></li>
                                            <li><i class="icofont icofont-maximize full-card font-white"></i></li>
                                            <li><i class="icofont icofont-minus minimize-card font-white"></i></li>
                                            <li><i class="icofont icofont-refresh reload-card font-white"></i></li>
                                            <li><i class="icofont icofont-error close-card font-white"> </i></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="table-responsive theme-scrollbar">
                                    <table class="table table-bordernone">
                                        <thead>
                                        <tr>
                                            <th class="f-26">Stok Obat</th>
                                            <th>Date</th>
                                            <th>Sisa Stok</th>
                                            <th></th>
                                            <th>Stok Masuk</th>
                                            <th>Stok Keluar</th>
                                            <th> </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($stokObat as $stok)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="f-14 f-w-600"> <a href="{{ route('stok-obat') }}">{{ $stok->nama_obat }}</a></span>
                                                </div>
                                            </td>
                                            <td>16 August</td>
                                            <td>{{ $stok->in_obat->total_jumlah_in - $stok->out_obat->total_jumlah_out }}</td>
                                            <td> <i class="flag-icon flag-icon-gb"></i></td>
                                            <td>{{ $stok->in_obat->total_jumlah_in }}</td>
                                            <td>{{ $stok->out_obat->total_jumlah_out }}</td>
                                            <td><span> <a href="{{ route('stok-obat') }}">Detail</a></span></td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-5 col-md-6 box-col-30 xl-30">
                <div class="card product">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between">
                            <div class="flex-grow-1">
                                <p class="square-after f-w-600">Data Obat<i class="fa fa-circle"> </i></p>
                                <h4>Kadaluwarsa</h4>
                            </div>
                            <div class="setting-list">
                                <ul class="list-unstyled setting-option">
                                    <li>
                                        <div class="setting-light"><i class="icon-layout-grid2"></i></div>
                                    </li>
                                    <li><i class="view-html fa fa-code font-white"></i></li>
                                    <li><i class="icofont icofont-maximize full-card font-white"></i></li>
                                    <li><i class="icofont icofont-minus minimize-card font-white"></i></li>
                                    <li><i class="icofont icofont-refresh reload-card font-white"></i></li>
                                    <li><i class="icofont icofont-error close-card font-white"> </i></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive theme-scrollbar">
                            <table class="table">
                                <tbody>
                                @foreach ($expiredMedicines as $medicine)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span> <a href="{{ route('exp-obat') }}">{{ $medicine->data_obat->nama_obat }}</a></span>
                                            <div class="active-status active-online"></div>
                                        </div>
                                    </td>
                                    <td></td>
                                    <td><span>{{ $medicine->tanggal_kadaluwarsa }}</span></td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="code-box-copy">
                            <button class="code-box-copy__btn btn-clipboard" data-clipboard-target="#sell-product"><i
                                    class="icofont icofont-copy-alt"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')


    <script src="{{ asset('assets/js/chart/chartist/chartist.js') }}"></script>
    <script src="{{ asset('assets/js/chart/chartist/chartist-plugin-tooltip.js') }}"></script>
    <script src="{{ asset('assets/js/chart/apex-chart/apex-chart.js') }}"></script>
    <script src="{{ asset('assets/js/chart/apex-chart/stock-prices.js') }}"></script>
    <script src="{{ asset('assets/js/prism/prism.min.js') }}"></script>
    <script src="{{ asset('assets/js/clipboard/clipboard.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom-card/custom-card.js') }}"></script>
    <script src="{{ asset('assets/js/notify/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('assets/js/vector-map/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ asset('assets/js/vector-map/map/jquery-jvectormap-world-mill-en.js') }}"></script>
    <script src="{{ asset('assets/js/vector-map/map/jquery-jvectormap-us-aea-en.js') }}"></script>
    <script src="{{ asset('assets/js/vector-map/map/jquery-jvectormap-uk-mill-en.js') }}"></script>
    <script src="{{ asset('assets/js/vector-map/map/jquery-jvectormap-au-mill.js') }}"></script>
    <script src="{{ asset('assets/js/vector-map/map/jquery-jvectormap-chicago-mill-en.js') }}"></script>
    <script src="{{ asset('assets/js/vector-map/map/jquery-jvectormap-in-mill.js') }}"></script>
    <script src="{{ asset('assets/js/vector-map/map/jquery-jvectormap-asia-mill.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard/default.js') }}"></script>
    <script src="{{ asset('assets/js/notify/index.js') }}"></script>
    <script src="{{ asset('assets/js/typeahead/handlebars.js') }}"></script>
    <script src="{{ asset('assets/js/typeahead/typeahead.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/typeahead/typeahead.custom.js') }}"></script>
    <script src="{{ asset('assets/js/typeahead-search/handlebars.js') }}"></script>
    <script src="{{ asset('assets/js/typeahead-search/typeahead-custom.js') }}"></script>
@endsection
