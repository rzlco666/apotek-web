@extends('layouts.master')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
@endsection

@section('title')
    Data Obat
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
                        @if (Auth::user()->can('create obat'))
                            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#form-modal">
                                <i class="icon-plus"></i> Tambah @yield('title')
                            </button>
                        @endif
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered" id="datatable">
                            <thead>
                            <tr class="border-bottom-primary">
                                <th scope="col" width="20px">No</th>
                                <th scope="col">Aksi</th>
                                <th scope="col">Kode</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Kategori</th>
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
                        <input type="hidden" name="obat_id" id="obat-id">
                        <div class="form-group">
                            <label>{{ __('Kode Obat') }} <span class="text-danger">*</span></label>
                            <input type="text" name="kode_obat" id="kode-obat" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Nama Obat') }} <span class="text-danger">*</span></label>
                            <input type="text" name="nama_obat" id="nama-obat" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Dosis') }} <span class="text-danger">*</span></label>
                            <input type="text" name="dosis" id="dosis" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Kategori Obat') }} <span class="text-danger">*</span></label>
                            <select class="form-control select2" name="kategori_obat_id" id="kategori-obat-id" required>
                                @if ($category_obat)
                                    @foreach ($category_obat as $row)
                                        <option value="{{ $row->id }}">{{ $row->nama_kategori }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Satuan') }} <span class="text-danger">*</span></label>
                            <input type="text" name="satuan" id="satuan" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Golongan') }} <span class="text-danger">*</span></label>
                            <input type="text" name="golongan" id="golongan" class="form-control" required>
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
                        <label>{{ __('Dosis') }}</label>
                        <p id="detail-dosis" class="form-control"></p>
                    </div>
                    <div class="form-group">
                        <label>{{ __('Kategori Obat') }}</label>
                        <p id="detail-kategori-obat" class="form-control"></p>
                    </div>
                    <div class="form-group">
                        <label>{{ __('Satuan') }}</label>
                        <p id="detail-satuan" class="form-control"></p>
                    </div>
                    <div class="form-group">
                        <label>{{ __('Golongan') }}</label>
                        <p id="detail-golongan" class="form-control"></p>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('.select2').select2({
                minimumInputLength: 0,
            });

            var datatable = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('data-obat-datatable') }}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                    { data: 'kode_obat', name: 'kode_obat' },
                    { data: 'nama_obat', name: 'nama_obat' },
                    { data: 'category_obat.nama_kategori', name: 'category_obat.nama_kategori' },
                    { data: 'last_modified', name: 'last_modified' }
                ]
            });

            $('#form-modal').on('show.bs.modal', function(){
                $.fn.modal.Constructor.prototype._enforceFocus = function() {};
            })

            $('#form-modal').on('hidden.bs.modal', function() {
                $('#obat-id').val('')
                $('#modal-form-label').text('Add Data Obat')
                $('#kode-obat').val('')
                $('#nama-obat').val('')
                $('#dosis').val('')
                $('#kategori-obat-id').val(null).trigger('change')
                $('#satuan').val('')
                $('#golongan').val('')

                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
            })

            $(document).on('click', '.edit-btn', function() {
                let id = $(this).data('id')
                let url = '{{ route('data-obat-detail', ':id') }}'
                url = url.replace(':id', id)
                $('#obat-id').val(id)
                $('#modal-form-label').text('Edit {{ __('Data Obat') }}')

                $.get(url, function(response) {
                    let data = response.data
                    $('#kode-obat').val(data.kode_obat)
                    $('#nama-obat').val(data.nama_obat)
                    $('#dosis').val(data.dosis)
                    $('#kategori-obat-id').val(data.kategori_obat_id).trigger('change')
                    $('#satuan').val(data.satuan)
                    $('#golongan').val(data.golongan)

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
                let url = '{{ route('data-obat-detail', ':id') }}'
                url = url.replace(':id', id)

                $.get(url, function(response) {
                    let data = response.data
                    $('#detail-kode-obat').html(data.kode_obat)
                    $('#detail-nama-obat').html(data.nama_obat)
                    $('#detail-dosis').html(data.dosis)
                    $('#detail-kategori-obat').html(data.category_obat.nama_kategori)
                    $('#detail-satuan').html(data.satuan)
                    $('#detail-golongan').html(data.golongan)

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
                let url = '{{ route('data-obat-create') }}'
                let obat_id = $('#obat-id').val()

                if (obat_id !== '') {
                    url = '{{ route('data-obat-update', ':id') }}'
                    url = url.replace(':id', obat_id)
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
                let url = '{{ route('data-obat-delete', ':id') }}'
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
