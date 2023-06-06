@extends('layouts.master')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/select2.css') }}">
@endsection

@section('title')
    Profile
@endsection

@section('prefix')
    Setting
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
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i data-feather="home"></i></a>
                        </li>
                        <li class="breadcrumb-item">@yield('prefix')</li>
                        <li class="breadcrumb-item active">@yield('title')</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="edit-profile">
            <div class="row">
                <div class="col-xl-12">
                    <form class="card">
                        <div class="card-header pb-0">
                            <h4 class="card-title mb-0">My Profile</h4>
                            <div class="card-options"><a class="card-options-collapse" href="#"
                                                         data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a
                                    class="card-options-remove" href="#" data-bs-toggle="card-remove"><i
                                        class="fe fe-x"></i></a></div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <input type="hidden" name="user" id="user-id" value="{{ Auth::user()->id }}">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label f-w-500">Name</label>
                                        {{-- <p class="form-control">{{ Auth::user()->name }}</p> --}}
                                        <input type="text" name="name" id="name" class="form-control" value="{{ Auth::user()->name }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label f-w-500">Email</label>
                                        {{-- <p class="form-control">{{ Auth::user()->email }}</p> --}}
                                        <input type="email" name="email" id="email" class="form-control" value="{{ Auth::user()->email }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label f-w-500">Date Join</label>
                                        {{-- <p class="form-control">{{ Auth::user()->created_at }}</p> --}}
                                        <input type="text" name="created_at" id="created_at" class="form-control" value="{{ Auth::user()->created_at }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button class="btn btn-primary" id="save-btn" type="button">Update Profile</button>
                            <button class="btn btn-secondary" type="button" data-bs-toggle="modal" data-bs-target="#password-modal" id="change-password-btn">
                                {{ __('Change Password') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- modal Change Password --}}
    <div class="modal fade" id="password-modal" role="dialog" aria-labelledby="modal-form-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-form-label">Change {{ __('Password') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <form method="post" action="#" id="form-password">
                <div class="modal-body">
                        <div class="form-group">
                            <label class="label">{{ __('New Password') }}</label>
                            <div class="input-group mb-3">
                                <input type="password" name="password" autocomplete="off" required id="new-password" class="form-control" placeholder="{{ __('New Password') }}">
                                <div class="input-group-append">
					    	<span class="input-group-text">
					    		<a role="button" id="new-password-visibility">
					    			<i class="fa fa-eye"></i>
					    		</a>
					    	</span>
                                </div>
                            </div>
                            <small class="text-danger" id="new-password-warning"></small>
                        </div>
                        <div class="form-group">
                            <label class="label">{{ __('Old Password') }}</label>
                            <div class="input-group mb-3">
                                <input type="password" name="old_password" autocomplete="off" required id="old-password" class="form-control" placeholder="{{ __('Old Password') }}">
                                <div class="input-group-append">
					    	<span class="input-group-text">
					    		<a role="button" id="old-password-visibility">
					    			<i class="fa fa-eye"></i>
					    		</a>
					    	</span>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="save-btn" class="btn btn-sm btn-primary">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
    <script src="{{ asset('assets/js/tooltip-init.js') }}"></script>
    <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>

    <script type="text/javascript">

        $(document).ready(function () {
            $('#save-btn').on('click', function() {
                // Mendapatkan nilai input dari form
                var id = document.getElementById('user-id').value;
                var name = document.getElementById('name').value;
                var email = document.getElementById('email').value;

                // Membuat objek data yang akan dikirim
                var data = new FormData();
                data.append('id', id);
                data.append('name', name);
                data.append('email', email);

                // Mengirim data ke rute update-profile menggunakan AJAX
                fetch('{{ route('update-profile') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: data
                })
                .then(response => response.json())
                .then(result => {
                // Menghandle respons dari server
                if (result.status) {
                    // Jika update berhasil
                    Swal.fire({
                    title: 'Success',
                    text: result.message,
                    icon: 'success',
                    confirmButtonText: 'Ok'
                    });
                } else {
                    // Jika update gagal
                    Swal.fire({
                    title: 'Error',
                    text: result.message,
                    icon: 'error',
                    confirmButtonText: 'Ok'
                    });
                }
                })
                .catch(error => {
                console.error('Error:', error);
                })
            })

            $('#new-password-visibility').on('click', function() {
                let type = $('#new-password').attr('type')
                if (type == 'text') {
                    $('#new-password').attr('type', 'password')
                    $(this).find('i').removeClass('fa-eye-slash').addClass('fa-eye')
                } else {
                    $('#new-password').attr('type', 'text')
                    $(this).find('i').removeClass('fa-eye').addClass('fa-eye-slash')
                }
            })

            $('#old-password-visibility').on('click', function() {
                let type = $('#old-password').attr('type')
                if (type == 'text') {
                    $('#old-password').attr('type', 'password')
                    $(this).find('i').removeClass('fa-eye-slash').addClass('fa-eye')
                } else {
                    $('#old-password').attr('type', 'text')
                    $(this).find('i').removeClass('fa-eye').addClass('fa-eye-slash')
                }
            })

            $('#new-password').on('keyup', function(){
                let input = $(this).val()
                var regularExpression = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,36}$/;
                if (!regularExpression.test(input)) {
                    $('#new-password-warning').html('Password minimal 8 karakter dan berupa kombinasi angka, karakter unik, huruf kecil dan kapital.')
                    $('#save-password-btn').prop('disabled', true)
                } else {
                    $('#new-password-warning').html('')
                    $('#save-password-btn').prop('disabled', false)
                }
            })

            $('#password-modal').on('hidden.bs.modal', function() {
                $('#new-password').val('')
                $('#new-password-warning').html('')
                $('#old-password').val('')

                $('#new-password').attr('type', 'password')
                $('#new-password-visibility').find('i').removeClass('fa-eye-slash').addClass('fa-eye')
                $('#old-new-password').attr('type', 'password')
                $('#old-password-visibility').find('i').removeClass('fa-eye-slash').addClass('fa-eye')
            })

            $('#form-password').submit(function(e) {
                e.preventDefault()

                let url = '{{ route('change-password') }}'
                let params = {
                    new_password: btoa('{{ env('APP_KEY') }}'+$('#new-password').val()),
                    old_password: btoa('{{ env('APP_KEY') }}'+$('#old-password').val())
                }

                $.post(url, params, function(response) {
                    console.log('oke1');
                    Swal.fire({
                        title: 'Success',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'Ok'
                    })
                    $('#password-modal').modal('hide')
                }, 'json').fail((err) => {
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
