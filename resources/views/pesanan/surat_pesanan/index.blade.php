@extends('layouts.master')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/select2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/date-picker.css') }}">
@endsection

@section('title')
    Surat Pesanan
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
                                <th scope="col">Nama Perusahaan</th>
                                <th scope="col">Tanggal Pesanan</th>
                                <th scope="col">Obat</th>
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
                        <input type="hidden" name="surat_pesanan_id" id="surat-pesanan-id">
                        <div class="form-group">
                            <label>{{ __('Nama Perusahaan') }} <span class="text-danger">*</span></label>
                            <input type="text" name="nama_perusahaan" id="nama-perusahaan" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Tanggal Pesan') }} <span class="text-danger">*</span></label>
                            <input type="text" name="tanggal_pesanan" id="tanggal-pesanan" data-date-format="yyyy-mm-dd" class="form-control digits" required>
                        </div>
                        <div class="form-group">
                            <button type="button" value="tambah" id="add-button" class="btn btn-primary btn-xs">
                                <i class="icon-plus"></i>
                            </button>
                        </div>
                        <div id="tambah-input">
                            <div class="form-group row" id="obat-row-0">
                                <div class="col-md-6">
                                    <label>{{ __('Obat') }} <span class="text-danger">*</span></label>
                                    <select class="form-control select2 obat" name="obat_id[]" required>
                                        @if ($data_obat)
                                            @foreach ($data_obat as $row)
                                                <option value="{{ $row->id.'-'.$row->nama_obat }}">{{ $row->kode_obat }} - {{ $row->nama_obat }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label>{{ __('Jumlah Pesan') }} <span class="text-danger">*</span></label>
                                    <input type="number" name="jumlah_out[]" class="form-control" required>
                                </div>
                            </div>
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
                        <label>{{ __('Nama Perusahaan') }}</label>
                        <p id="detail-nama-perusahaan" class="form-control"></p>
                    </div>
                    <div class="form-group">
                        <label>{{ __('Tanggal Pesan') }}</label>
                        <p id="detail-tanggal-pesanan" class="form-control"></p>
                    </div>
                    <div class="form-group">
                        <label>{{ __('Obat') }}</label>
                        <div id="detail-obat"></div>
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
    <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker/date-picker/datepicker.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker/date-picker/datepicker.en.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('.select2').select2({
                minimumInputLength: 0,
            });

            $('#tanggal-pesanan').datepicker({
                language: 'en',
                //format: 'yyyy-mm-dd',
                //minDate: new Date() // Now can select only dates, which goes after today
            })

            var rowCounter = 1;

            $('#add-button').on('click', function () {
                var html = `
                <div class="form-group row" id="obat-row-${rowCounter}">
                    <div class="col-md-6">
                        <label>{{ __('Obat') }} <span class="text-danger">*</span></label>
                        <select class="form-control select2 obat" name="obat_id[]" required>
                            @if ($data_obat)
                @foreach ($data_obat as $row)
                <option value="{{ $row->id.'-'.$row->nama_obat }}">{{ $row->kode_obat }} - {{ $row->nama_obat }}</option>
                @endforeach
                @endif
                </select>
            </div>
            <div class="col-md-4">
                <label>{{ __('Jumlah Pesan') }} <span class="text-danger">*</span></label>
                        <input type="number" name="jumlah_out[]" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger btn-xs remove-row" data-row="${rowCounter}"><i class="icon-minus"></i></button>
                    </div>
                </div>
                `;

                $('#tambah-input').append(html);
                $('.select2').select2();
                rowCounter++;
            });

            $(document).on('click', '.remove-row', function () {
                var row = $(this).data('row');
                $('#obat-row-' + row).remove();
            });

            $('#remove-button').on('click', function () {
                var rowCount = $('#tambah-input').children().length;
                if (rowCount > 1) {
                    $('#tambah-input').children().last().remove();
                }
            });

            var datatable = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('surat-pesanan-datatable') }}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                    { data: 'nama_perusahaan', name: 'nama_perusahaan' },
                    { data: 'tanggal_pesanan', name: 'tanggal_pesanan' },
                    {
                        data: 'obat',
                        name: 'obat',
                        render: function(data) {
                            var parsedData = data.replace(/&quot;/g, '"');
                            var obatData = JSON.parse(parsedData);
                            var obatText = '';
                            for (var i = 0; i < obatData.length; i++) {
                                var namaObat = obatData[i].nama_obat;
                                var jumlahOut = obatData[i].jumlah_out;
                                obatText += namaObat + ' (' + jumlahOut + ')';
                                if (i < obatData.length - 1) {
                                    obatText += ', ';
                                }
                            }
                            return obatText;
                        }
                    },
                    { data: 'last_modified', name: 'last_modified' }
                ]
            });

            $('#form-modal').on('show.bs.modal', function(){
                $.fn.modal.Constructor.prototype._enforceFocus = function() {};
            })

            $('#form-modal').on('hidden.bs.modal', function() {
                $('#surat-pesanan-id').val('')
                $('#modal-form-label').text('Add Surat Pesanan')
                $('#obat-id').val('')
                $('#nama-perusahaan').val('')
                $('#tanggal-pesanan').val('')
                $('#jumlah-out').val('')

                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
            })

            $(document).on('click', '.edit-btn', function() {
                let id = $(this).data('id')
                let url = '{{ route('surat-pesanan-detail', ':id') }}'
                url = url.replace(':id', id)
                $('#surat-pesanan-id').val(id)
                $('#modal-form-label').text('Edit {{ __('Surat Pesanan') }}')

                $.get(url, function(response) {
                    let data = response.data
                    $('#obat-id').val(data.obat_id).trigger('change')
                    $('#nama-perusahaan').val(data.nama_perusahaan)
                    $('#tanggal-pesanan').val(data.tanggal_keluar)
                    $('#jumlah-out').val(data.jumlah_out)

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
                let url = '{{ route('surat-pesanan-detail', ':id') }}'
                url = url.replace(':id', id)

                $.get(url, function(response) {
                    let data = response.data
                    $('#detail-tanggal-pesanan').html(data.tanggal_pesanan)
                    $('#detail-nama-perusahaan').html(data.nama_perusahaan)

                    var obatData = JSON.parse(data.obat);
                    var obatTable = '<table class="table table-bordered">';
                    obatTable += '<thead><tr><th>Nama Obat</th><th>Jumlah Pesan</th></tr></thead>';
                    obatTable += '<tbody>';

                    for (var i = 0; i < obatData.length; i++) {
                        var namaObat = obatData[i].nama_obat;
                        var jumlahOut = obatData[i].jumlah_out;

                        obatTable += '<tr><td>' + namaObat + '</td><td>' + jumlahOut + '</td></tr>';
                    }

                    obatTable += '</tbody></table>';

                    $('#detail-obat').html(obatTable);

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
                let url = '{{ route('surat-pesanan-create') }}'
                let surat_pesanan_id = $('#surat-pesanan-id').val()

                if (surat_pesanan_id !== '') {
                    url = '{{ route('surat-pesanan-update', ':id') }}'
                    url = url.replace(':id', surat_pesanan_id)
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
                let url = '{{ route('surat-pesanan-delete', ':id') }}'
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

            $(document).on('click', '.print-btn', function() {
                let id = $(this).data('id');
                let url = '{{ route('surat-pesanan-pdf', ':id') }}';
                url = url.replace(':id', id);

                window.open(url, '_blank');
            });

        });
    </script>

@endsection
