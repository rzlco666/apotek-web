@extends('layouts.master')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endsection

@section('title')
    Stok Obat
@endsection

@section('prefix')
    Obat
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
                        <li class="breadcrumb-item">@yield('prefix')</li>
                        <li class="breadcrumb-item active">@yield('title')</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid basic_table">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered" id="datatable">
                            <thead>
                            <tr class="border-bottom-primary">
                                <th scope="col" width="20px">No</th>
                                <th scope="col">Aksi</th>
                                <th scope="col">Obat</th>
                                <th scope="col">Kategori</th>
                                <th scope="col">Kadaluwarsa</th>
                                <th scope="col">Sisa Stok</th>
                                <th scope="col">Stok Masuk</th>
                                <th scope="col">Stok Keluar</th>
                            </tr>
                            </thead>
                            <tbody>
                            {{-- table content --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- modal Detail --}}
    <div class="modal fade" id="detail-modal"  role="dialog" aria-labelledby="modal-detail-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-detail-label">Detail {{ __('Data') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{ __('Kode Obat') }}</label>
                        <p id="detail-kode-obat" class="form-control"></p>
                    </div>
                    <div class="form-group">
                        <label>{{ __('Nama Obat') }}</label>
                        <p id="detail-nama-obat" class="form-control"></p>
                    </div>
                    <div class="form-group">
                        <label>{{ __('Kategori Obat') }}</label>
                        <p id="detail-kategori-obat" class="form-control"></p>
                    </div>
                    <div class="form-group">
                        <label>{{ __('Tanggal Kadaluwarsa') }}</label>
                        <p id="detail-tanggal-kadaluwarsa" class="form-control"></p>
                    </div>
                    <div class="form-group">
                        <label>{{ __('Stok Masuk') }}</label>
                        <p id="detail-stok-in" class="form-control"></p>
                    </div>
                    <div class="form-group">
                        <label>{{ __('Stok Keluar') }}</label>
                        <p id="detail-stok-out" class="form-control"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
    <script src="{{ asset('assets/js/tooltip-init.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            var datatable = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('stok-obat-datatable') }}',
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
                { data: 'nama_obat', name: 'nama_obat' },
                { data: 'category_obat.nama_kategori', name: 'category_obat.nama_kategori' },
                {
                    data: 'exp_obat.tanggal_kadaluwarsa',
                    name: 'exp_obat.tanggal_kadaluwarsa',
                    render: function ( data, type, row ) {
                        return data || '-';
                    }
                },
                {
                    data: null,
                    name: 'sisa_stok',
                    render: function ( data, type, row ) {
                        var total_jumlah_in = data.in_obat && data.in_obat.total_jumlah_in ? data.in_obat.total_jumlah_in : 0;
                        var total_jumlah_out = data.out_obat && data.out_obat.total_jumlah_out ? data.out_obat.total_jumlah_out : 0;
                        var sisa_stok = total_jumlah_in - total_jumlah_out;

                        return isNaN(sisa_stok) || sisa_stok === 0 ? '-' : sisa_stok;
                    },
                    "createdCell": function (td, cellData, rowData, row, col) {
                        var total_jumlah_in = rowData.in_obat && rowData.in_obat.total_jumlah_in ? rowData.in_obat.total_jumlah_in : 0;
                        var total_jumlah_out = rowData.out_obat && rowData.out_obat.total_jumlah_out ? rowData.out_obat.total_jumlah_out : 0;
                        var sisa_stok = total_jumlah_in - total_jumlah_out;

                        $(td).attr('data-order', sisa_stok);
                    }
                },
                {
                    data: 'in_obat.total_jumlah_in',
                    name: 'in_obat.total_jumlah_in',
                    render: function ( data, type, row ) {
                        return data || '-';
                    }
                },
                {
                    data: 'out_obat.total_jumlah_out',
                    name: 'out_obat.total_jumlah_out',
                    render: function ( data, type, row ) {
                        return data || '-';
                    }
                },
            ],
            order: [[5, 'asc']] // Urutan kolom ke-5 (sisa_stok) secara menaik
        });


            $('#form-modal').on('show.bs.modal', function(){
                $.fn.modal.Constructor.prototype._enforceFocus = function() {};
            })

            $(document).on('click', '.detail-btn', function() {
                let id = $(this).data('id')
                let url = '{{ route('stok-obat-detail', ':id') }}'
                url = url.replace(':id', id)

                $.get(url, function(response) {
                    let data = response.data
                    $('#detail-kode-obat').html(data.kode_obat)
                    $('#detail-nama-obat').html(data.nama_obat)
                    $('#detail-kategori-obat').html(data.category_obat.nama_kategori)
                    $('#detail-tanggal-kadaluwarsa').html(data.exp_obat.tanggal_kadaluwarsa)
                    $('#detail-stok-in').html(data.in_obat.total_jumlah_in)
                    $('#detail-stok-out').html(data.out_obat.total_jumlah_out)

                    $('#detail-modal').modal('show')
                }).fail((err) => {
                    Swal.fire({
                        title: 'Error',
                        text: err.responseJSON.message,
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    })
                })

            })
        });
    </script>

@endsection
