@extends('layouts.app')

@section('title') Data Produck @endsection

@push('css')
    
@endpush

@section('content')
    @if (session('message'))
        <div class="alert alert-success">
            <strong>{{session('message')}}</strong>
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center" id="prdct-table">
                    <thead>
                        <tr>
                            <th>Kode Produk</th>
                            <th>Nama Produk</th>
                            <th>Kategori Produk</th>
                            <th>Stock Produk</th>
                            <th>Harga Produk</th>
                            <th>Produk Terjual</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                            
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script type="text/javascript" src="{{asset('js/plugins/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/plugins/dataTables.bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/plugins/bootstrap-notify.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let table = $('#prdct-table').DataTable({
                serverSide: true,
                retrieve: true,
                ajax: '/admin/product',
                columns: [
                    {data: 'kd_product'},
                    {data: 'nm_produk'},
                    {data: 'kategori'},
                    {data: 'stock_produk'},
                    {data: 'harga_produk'},
                    {data: 'terjual_produk'},
                    {data: 'action'},
                ]
            });

            $(document).on('click', '.delete', function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Warning!',
                    text: "Anda yakin ingin menghapus data ini?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/admin/product/'+id,
                            method: 'DELETE',
                            success: function(response) {
                                $.notify({
                                    title: "Success : ",
                                    message: response.message,
                                    icon: 'fa fa-check' 
                                },{
                                    type: "success"
                                });
                                table.draw();
                            },
                            error: function(err) {
                                console.log(err);
                            }
                        });
                    }
                })
            });
        });
    </script>
@endpush