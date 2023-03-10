@extends('layouts.app')

@section('title') Tambah Karyawan @endsection

@push('css')
    
@endpush

@section('content') 
    <div class="card">
        <div class="card-header">
            <h6>Formulir Pendaftaran Karyawan Baru</h6>
        </div>
        <div class="card-body">
            <form action="#" method="POST" id="krywn-form">
                <div class="form-group mb-2">
                    <label for="">Nama Lengkap</label>
                    <input type="text" name="name" id="name" class="form-control" autocomplete="off">
                </div>
                <div class="form-group mb-2">
                    <label for="">Jenis Kelamin</label>
                    <select name="jk" id="jk" class="form-control">
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
                <div class="form-group mb-2">
                    <label for="">Email</label>
                    <input type="email" name="email" id="email" class="form-control" autocomplete="off">
                </div>
                <div class="form-group mb-2">
                    <label for="">No Induk Kependudukan</label>
                    <input type="number" name="nik" id="nik" class="form-control" autocomplete="off">
                </div>
                <div class="form-group mb-2">
                    <label for="">Tanggal Lahir</label>
                    <input type="date" name="tgl_lahir" id="tgl_lahir" class="form-control" autocomplete="off">
                </div>
                <div class="form-group mb-2">
                    <label for="">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" autocomplete="off">
                </div>
                <div class="form-group mb-2">
                    <label for="">Password</label>
                    <input type="password" name="password" id="password" class="form-control" autocomplete="off">
                </div>

                <div class="my-4">
                    <button class="btn btn-primary btn-md float-right ml-2 add">Tambah</button>
                    <button type="reset" class="btn btn-secondary btn-md float-right">reset</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script type="text/javascript" src="{{asset('js/plugins/bootstrap-notify.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            $('.add').click(function(e) {
                e.preventDefault();
                let name = $('#name').val(); 
                let email = $('#email').val(); 
                let nik = $('#nik').val(); 
                let jk = $('#jk').val(); 
                let tgl_lahir = $('#tgl_lahir').val(); 
                let tempat_lahir = $('#tempat_lahir').val(); 
                let password = $('#password').val(); 

                $.ajax({
                    url: '/admin/karyawan/add',
                    method: 'POST',
                    data: {
                        name: name,
                        email: email,
                        nik: nik,
                        jk: jk,
                        tgl_lahir: tgl_lahir,
                        tempat_lahir: tempat_lahir,
                        password: password
                    },
                    dataType: 'json',
                    cache: false,
                    success: function(response) {
                        if (response.errors) {
                            $.each(response.errors, function(key, val) {
                                $.notify({
                                    title: "Opsss : ",
                                    message: val,
                                    icon: 'fa fa-xmarx' 
                                },{
                                    type: "danger"
                                });
                            });
                        } else {
                            $.notify({
                                title: "Success : ",
                                message: "Berhasil Menambahkan Karyawan .",
                                icon: 'fa fa-check' 
                            },{
                                type: "success"
                            });
                            $('#krywn-form')[0].reset();
                        }
                    },
                    error: function(err) {
                        $.notify({
                            title: "Status 400 : ",
                            message: "Server Error .",
                            icon: 'fa fa-xmarx' 
                        },{
                            type: "danger"
                        });
                    }
                })
            });
        });
    </script>
@endpush