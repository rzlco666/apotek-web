@extends('layouts.master')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/select2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/date-picker.css') }}">
@endsection

@section('title')
    Data Faktur
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
    <div class="container-fluid basic_table">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        @can('create obat')
                            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#form-modal">
                                <i class="icon-plus"></i> Tambah @yield('title')
                            </button>
                        @endcan
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered" id="datatable">
                            <thead>
                            <tr class="border-bottom-primary">
                                <th scope="col" width="20px">No</th>
                                <th scope="col">Aksi</th>
                                <th scope="col">Obat</th>
                                <th scope="col">Tanggal Faktur</th>
                                <th scope="col">Total Obat</th>
                                <th scope="col">Total Bayar</th>
                                <th scope="col">Supplier</th>
                                <th scope="col">Updated By</th>
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
    {{-- modal Add Data --}}
    <div class="modal fade" id="form-modal"  role="dialog" aria-labelledby="modal-form-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-form-label">Add {{ __('Data') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-input">
                        <input type="hidden" name="data_faktur_id" id="data-faktur-id">
                        <div class="form-group">
                            <label>{{ __('Tanggal Faktur') }} <span class="text-danger">*</span></label>
                            <input type="text" name="tanggal_faktur" id="tanggal-faktur" data-date-format="yyyy-mm-dd" class="form-control digits" required>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Obat') }} <span class="text-danger">*</span></label>
                            <select class="form-control select2" name="obat_id" id="obat-id" required>
                                @if ($data_obat)
                                    @foreach ($data_obat as $row)
                                        <option value="{{ $row->id }}">{{ $row->kode_obat }} - {{ $row->nama_obat }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Total Obat') }} <span class="text-danger">*</span></label>
                            <input type="number" name="total_obat" id="total-obat" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Total Bayar') }} <span class="text-danger">*</span></label>
                            <input type="text" name="total_bayar" id="total-bayar" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Supplier') }} <span class="text-danger">*</span></label>
                            <select class="form-control select2" name="supplier_id" id="supplier-id" required>
                                @if ($data_supplier)
                                    @foreach ($data_supplier as $row)
                                        <option value="{{ $row->id }}">{{ $row->nama_perusahaan }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="save-btn" class="btn btn-sm btn-primary">Submit</button>
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
                        <label>{{ __('Tanggal Faktur') }}</label>
                        <p id="detail-tanggal-faktur" class="form-control"></p>
                    </div>
                    <div class="form-group">
                        <label>{{ __('Total Obat') }}</label>
                        <p id="detail-total-obat" class="form-control"></p>
                    </div>
                    <div class="form-group">
                        <label>{{ __('Total Bayar') }}</label>
                        <p id="detail-total-bayar" class="form-control"></p>
                    </div>
                    <div class="form-group">
                        <label>{{ __('Supplier') }}</label>
                        <p id="detail-supplier-id" class="form-control"></p>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
    <script src="{{ asset('assets/js/tooltip-init.js') }}"></script>
    <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker/date-picker/datepicker.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker/date-picker/datepicker.en.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('.select2').select2({
                minimumInputLength: 0,
            });

            $('#tanggal-faktur').datepicker({
                language: 'en',
                //format: 'yyyy-mm-dd',
                //minDate: new Date() // Now can select only dates, which goes after today
            })

            $('#total-bayar').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0});

            var datatable = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('data-faktur-datatable') }}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                    { data: 'data_obat.nama_obat', name: 'data_obat.nama_obat' },
                    { data: 'tanggal_faktur', name: 'tanggal_faktur' },
                    { data: 'total_obat', name: 'total_obat' },
                    {
                        data: 'total_bayar',
                        name: 'total_bayar',
                        render: function(data, type, row) {
                            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(data);
                        }
                    },
                    { data: 'data_supplier.nama_perusahaan', name: 'data_supplier.nama_perusahaan' },
                    { data: 'last_modified', name: 'last_modified' }
                ]
            });

            $('#form-modal').on('show.bs.modal', function(){
                $.fn.modal.Constructor.prototype._enforceFocus = function() {};
            })

            $('#form-modal').on('hidden.bs.modal', function() {
                $('#data-faktur-id').val('')
                $('#modal-form-label').text('Add Data Faktur')
                $('#obat-id').val('')
                $('#tanggal-faktur').val('')
                $('#total-obat').val('')
                $('#total-bayar').val('')
                $('#supplier-id').val('')

                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
            })

            $(document).on('click', '.edit-btn', function() {
                let id = $(this).data('id')
                let url = '{{ route('data-faktur-detail', ':id') }}'
                url = url.replace(':id', id)
                $('#data-faktur-id').val(id)
                $('#modal-form-label').text('Edit {{ __('Data Faktur') }}')

                $.get(url, function(response) {
                    let data = response.data
                    $('#obat-id').val(data.obat_id).trigger('change')
                    $('#tanggal-faktur').val(data.tanggal_faktur)
                    $('#total-obat').val(data.total_obat)
                    $('#total-bayar').val(data.total_bayar)
                    $('#supplier-id').val(data.supplier_id).trigger('change')

                    $('#form-modal').modal('show')
                }).fail((err) => {
                    Swal.fire({
                        title: 'Error',
                        text: err.responseJSON.message,
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    })
                })

            })

            $(document).on('click', '.detail-btn', function() {
                let id = $(this).data('id')
                let url = '{{ route('data-faktur-detail', ':id') }}'
                url = url.replace(':id', id)

                $.get(url, function(response) {
                    let data = response.data
                    $('#detail-kode-obat').html(data.data_obat.kode_obat)
                    $('#detail-nama-obat').html(data.data_obat.nama_obat)
                    $('#detail-tanggal-faktur').html(data.tanggal_faktur)
                    $('#detail-total-obat').html(data.total_obat)
                    $('#detail-total-bayar').html(new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(data.total_bayar))
                    $('#detail-supplier-id').html(data.data_supplier.nama_perusahaan)

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

            $('#save-btn').on('click', function() {
                let params = new FormData($('#form-input')[0])
                let url = '{{ route('data-faktur-create') }}'
                let data_faktur_id = $('#data-faktur-id').val()

                if (data_faktur_id !== '') {
                    url = '{{ route('data-faktur-update', ':id') }}'
                    url = url.replace(':id', data_faktur_id)
                }

                $.ajax({
                    url: url,
                    data: params,
                    cache: false,
                    contentType: false,
                    processData: false,
                    method: 'POST',
                    success: function(response) {
                        Swal.fire({
                            title: 'Success',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'Ok'
                        })
                        datatable.ajax.reload(null, false)

                        $('#form-modal').modal('hide')
                        $('.modal-backdrop').remove()
                        $('body').removeClass('modal-open')
                        $('body').removeAttr('style')

                        // Reset modal state after hiding
                        setTimeout(function(){
                            $('#form-modal').removeClass('show');
                            $('.modal-backdrop').remove();
                            $('body').removeClass('modal-open');
                            $('body').css('padding-right', '');
                        }, 500);
                    },
                    error: function(err) {
                        Swal.fire({
                            title: 'Error',
                            text: err.responseJSON.message,
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        })
                    }
                });
            })

            $(document).on('click', '.delete-btn', function() {
                let id = $(this).data('id')
                let url = '{{ route('data-faktur-delete', ':id') }}'
                url = url.replace(':id', id)

                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Apakah anda yakin akan menghapus data ini?',
                    icon: 'warning',
                    confirmButtonText: 'Ya',
                    denyButtonText: `Tidak`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            method: 'DELETE',
                            success: function(response) {
                                if (response.status == false) {
                                    Swal.fire({
                                        title: 'Error',
                                        text: response.message,
                                        icon: 'error',
                                        confirmButtonText: 'Ok'
                                    })
                                    return false
                                }

                                Swal.fire({
                                    title: 'Success',
                                    text: response.message,
                                    icon: 'success',
                                    confirmButtonText: 'Ok'
                                }).then((result) => {
                                    datatable.ajax.reload(null, false)
                                })
                            },
                            error: function(e) {
                                Swal.fire({
                                    title: 'Error',
                                    text: e.responseJSON.message,
                                    icon: 'error',
                                    confirmButtonText: 'Ok'
                                })
                                return false
                            }
                        })
                    }
                })

            })
        });
    </script>

@endsection
