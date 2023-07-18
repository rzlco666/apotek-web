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
                                <th scope="col">Distributor</th>
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
                            <label>{{ __('Surat Pesanan') }} <span class="text-danger">*</span></label>
                            <select class="form-control select2" name="id_surat_pesanan" id="pesanan-id" required>
                                <option value="0" selected disabled>-Select here-</option>
                                @if ($data_surat_pesanan)
                                    @foreach ($data_surat_pesanan as $row)
                                        <option value="{{ $row->id }}">{{ $row->kode_pesanan }}</option>
                                    @endforeach
                                @endif
                            </select>
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
                                    <label>{{ __('Jumlah') }} <span class="text-danger">*</span></label>
                                    <input type="number" name="jumlah[]" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label>{{ __('Harga Jual') }} <span class="text-danger">*</span></label>
                                    <input type="number" name="harga_jual[]" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label>{{ __('Harga Beli') }} <span class="text-danger">*</span></label>
                                    <input type="number" name="harga_beli[]" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label>{{ __('Tanggal Kadaluwarsa') }} <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_kadaluwarsa[]" class="form-control" required>
                                </div>
                            </div>
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
                            <label>{{ __('Distributor') }} <span class="text-danger">*</span></label>
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
                        <label>{{ __('Tanggal Faktur') }}</label>
                        <p id="detail-tanggal-faktur" class="form-control"></p>
                    </div>
                    <div class="form-group">
                        <label>{{ __('Surat Pesanan') }}</label>
                        <p id="detail-pesanan" class="form-control"></p>
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
                        <label>{{ __('Distributor') }}</label>
                        <p id="detail-supplier-id" class="form-control"></p>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
    <script src="{{ asset('assets/js/tooltip-init.js') }}"></script>
    <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker/date-picker/datepicker.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker/date-picker/datepicker.en.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            var pesananIdSelect = $('#pesanan-id');
            var supplierIdSelect = $('#supplier-id');
            var tambahInputDiv = $('#tambah-input');

            // Mendapatkan data obat
            var dataObat = {!! json_encode($data_obat) !!};

            // Fungsi untuk menambahkan input field baru
            function addNewInputField(obatData) {
            // Menghitung jumlah form input yang sudah ada
            var inputFieldCount = $('.form-group.row').length;

            // Menggandakan template input field
            var newInputField = $('#obat-row-0').clone().attr('id', 'obat-row-' + inputFieldCount);

            // Mengatur nilai pada select obat dan membersihkan nilai input lainnya
            newInputField.find('.obat').empty(); // kosongkan select

            // Menambahkan option pada select obat
            obatData.forEach(function(obat) {
                var option = $('<option>').val(obat.obat_id).text(obat.nama_obat);
                newInputField.find('.obat').append(option);
            });

            newInputField.find('.jumlah').val('');
            newInputField.find('.harga_jual').val('');
            newInputField.find('.harga_beli').val('');
            newInputField.find('.tanggal_kadaluwarsa').val('');

            // Menambahkan form input baru ke dalam div
            tambahInputDiv.append(newInputField);
            }

            pesananIdSelect.on('change', function() {
            var pesananId = $(this).val();
            var selectedPesanan = {!! json_encode($data_surat_pesanan) !!}.find(function(pesanan) {
                return pesanan.id == pesananId;
            });

            // Menghapus semua input field kecuali template
            tambahInputDiv.find('.form-group.row:gt(0)').remove();

            if (selectedPesanan) {
                supplierIdSelect.val(selectedPesanan.supplier_id).trigger('change');

                var obatData = JSON.parse(selectedPesanan.obat);

                obatData.forEach(function(obat, index) {
                if (index == 0) {
                    // Mengatur nilai pada input field pertama (template)
                    var firstInputField = $('#obat-row-0');
                    firstInputField.find('.obat').empty(); // kosongkan select
                    var option = $('<option>').val(obat.obat_id).text(obat.nama_obat);
                    firstInputField.find('.obat').append(option); // isi dengan obat dari data_surat_pesanan
                    firstInputField.find('.jumlah').val('');
                    firstInputField.find('.harga_jual').val('');
                    firstInputField.find('.harga_beli').val('');
                    firstInputField.find('.tanggal_kadaluwarsa').val('');
                } else {
                    // Menambahkan input field baru untuk obat lainnya
                    // addNewInputField(obatData);
                }
                });

                // Mengatur ulang semua opsi select obat lainnya untuk mencerminkan data obat baru
                $('.obat').each(function() {
                var select = $(this);
                select.empty();
                obatData.forEach(function(obat) {
                    var option = $('<option>').val(obat.obat_id).text(obat.nama_obat);
                    select.append(option);
                });
                });
            }
            });

            // Inisialisasi opsi obat dan supplier pada saat halaman dimuat
            pesananIdSelect.trigger('change');



            $('.select2').select2({
                minimumInputLength: 0,
            });

            $('#tanggal-faktur').datepicker({
                language: 'en',
                maxDate: new Date()
                //format: 'yyyy-mm-dd',
                //minDate: new Date() // Now can select only dates, which goes after today
            })

            $('#total-bayar').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0});

            var rowCounter = 1;

            $('#add-button').on('click', function() {
                    var pesananId = $('#pesanan-id').val();
                    var selectedPesanan = {!! json_encode($data_surat_pesanan) !!}.find(function(pesanan) {
                        return pesanan.id == pesananId;
                    });

                    var obatData = [];
                    if (selectedPesanan) {
                        obatData = JSON.parse(selectedPesanan.obat);
                    }

                    var obatOptions = obatData.map(obat => `<option value="${obat.obat_id}">${obat.nama_obat}</option>`).join('');

                    var html = `
                        <div class="form-group row" id="obat-row-${rowCounter}">
                        <div class="col-md-6">
                            <label>{{ __('Obat') }} <span class="text-danger">*</span></label>
                            <select class="form-control select2 obat" name="obat_id[]" required>
                            ${obatOptions}
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>{{ __('Jumlah') }} <span class="text-danger">*</span></label>
                            <input type="number" name="jumlah[]" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>{{ __('Harga Jual') }} <span class="text-danger">*</span></label>
                            <input type="number" name="harga_jual[]" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>{{ __('Harga Beli') }} <span class="text-danger">*</span></label>
                            <input type="number" name="harga_beli[]" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>{{ __('Tanggal Kadaluwarsa') }} <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_kadaluwarsa[]" class="form-control" required>
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
                ajax: '{{ route('data-faktur-datatable') }}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                    {
                        data: 'obat',
                        name: 'obat',
                        render: function(data) {
                            var parsedData = data.replace(/&quot;/g, '"');
                            var obatData = JSON.parse(parsedData);
                            var obatText = '';
                            for (var i = 0; i < obatData.length; i++) {
                                var namaObat = obatData[i].nama_obat;
                                var jumlahOut = obatData[i].jumlah;
                                obatText += namaObat + ' (' + jumlahOut + ')';
                                if (i < obatData.length - 1) {
                                    obatText += ', ';
                                }
                            }
                            return obatText;
                        }
                    },
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
                $('#pesanan-id').val('')

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
                    $('#pesanan-id').val(data.id_surat_pesanan).trigger('change')

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
                    $('#detail-tanggal-faktur').html(data.tanggal_faktur)
                    $('#detail-total-obat').html(data.total_obat)
                    $('#detail-total-bayar').html(new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(data.total_bayar))
                    $('#detail-supplier-id').html(data.data_supplier.nama_perusahaan)
                    $('#detail-pesanan').html(data.data_surat_pesanan.kode_pesanan)

                    var obatData = JSON.parse(data.obat);
                    var obatTable = '<table class="table table-bordered">';
                    obatTable += '<thead><tr><th>Nama Obat</th><th>Jumlah</th></tr></thead>';
                    obatTable += '<tbody>';

                    for (var i = 0; i < obatData.length; i++) {
                        var namaObat = obatData[i].nama_obat;
                        var jumlahOut = obatData[i].jumlah;

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
