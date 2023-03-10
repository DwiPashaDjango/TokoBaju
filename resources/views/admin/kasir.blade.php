@extends('layouts.app')

@section('title') Kasir @endsection

@push('css')
    <style>
        #qty {
            width: 10%;
            outline: none;
            border: none;   
            text-align: center;
            background-color: rgb(242, 237, 237);
        }
    </style>
@endpush

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="#" method="POST" id="form-transaction">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="form-group">
                            <input type="text" name="nm_pembeli" id="nm_pembeli" class="form-control" placeholder="Nama Pembeli">
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            <select name="products_id" id="products_id" class="form-control">
                                <option>Pilih Produk</option>
                                @foreach ($data as $item)
                                    <option value="{{$item->id}}">{{$item->nm_produk}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <button class="btn btn-primary kirim">Pesan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body p-">
            <div class="col-12 table-responsive">
                <table class="table table-striped table-bordered table-hover text-center">
                    <thead>
                        <tr>
                        <th>Aksi</th>
                        <th>Kode Transaksi</th>
                        <th>Costumer</th>
                        <th>Produk</th>
                        <th>Qty</th>
                        <th>Harga Satauan</th>
                        <th>Grand Total</th>
                        </tr>
                    </thead>
                    <tbody id="transaction">
                        
                    </tbody>
                </table>
                <div class="mt-3">
                    <button id="btn_nota" class="btn btn-secondary print float-right"><i class="fa fa-print"></i> Print Nota</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script type="text/javascript" src="{{asset('')}}js/plugins/select2.min.js"></script>
    <script type="text/javascript" src="{{asset('js/plugins/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/plugins/dataTables.bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/plugins/bootstrap-notify.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            get_transaction();
            $("#products_id").select2();

            $('.kirim').click(function(e) {
                e.preventDefault();
                let nm_pembeli = $('#nm_pembeli').val();
                let products_id = $('#products_id').val();

                $.ajax({
                    url: '/admin/kasir',
                    method: 'POST',
                    data: {
                        nm_pembeli: nm_pembeli,
                        products_id: products_id
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
                            $('#form-transaction')[0].reset();
                            get_transaction();
                        }
                    },
                    error: function(err) {
                        console.log(err);
                    }
                })
            });

            function get_transaction() {
                $.ajax({
                    url: '/admin/kasir/json',
                    method: 'GET',
                    success: function(response) {
                        console.log(response);
                        if (response.data.length > 0) {
                            let transaction = '';
                            $.each(response.data, function(key, val) {
                                transaction += `<tr>`;
                                    transaction += `<td><a id="hps" href="javascript:void(0)" data-id="${val.id}">Hapus</a></td>`;
                                    transaction += `<td>${val.kd_transaksi}</td>`;
                                    transaction += `<td>${val.nm_pembeli}</td>`;
                                    transaction += `<td>${val.produk.nm_produk}</td>`;
                                    if (val.qty > 0) {
                                        transaction += `<td><button id="minus" data-id="${val.id}" class="btn btn-sm btn-danger mr-2"><i class="fa fa-minus"></i></button><input type="text" value="${val.qty}" id="qty" readonly><button id="plus" data-id="${val.id}" class="btn btn-sm btn-primary ml-2"><i class="fa fa-plus"></i></button></td>`;
                                    } else {
                                        transaction += `<td><input type="text" value="${val.qty}" id="qty" readonly><button id="plus" data-id="${val.id}" class="btn btn-sm btn-primary ml-2"><i class="fa fa-plus"></i></button></td>`;
                                    }
                                    transaction += `<td>${val.produk.harga_produk}</td>`;
                                    transaction += `<td>${val.qty * val.produk.harga_produk}</td>`;
                                    transaction += `</tr>`;
                            });
                            $('#transaction').html(transaction);
                        } else {
                            let transaction = '';
                            transaction += `<tr>`;
                            transaction += `<td colspan="7" class="text-center"> Tidak Ada Transaksi`;
                            transaction += `</td>`;
                            transaction += `</tr>`;
                            $('#transaction').html(transaction);
                        }
                    },
                    error: function(err) {
                        console.log(err);
                    }
                })
            }

            $(document).on('click','#plus',function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                plusQty(id);
                get_transaction();
            });

            function plusQty(id) {
                let qty = $('#qty').val();
                $.ajax({
                    url: '/admin/kasir/plus/'+id,
                    method: 'PUT',
                    data: {
                        qty: qty,
                    },
                    success: function(res) {
                        if (res.errors) {
                            $.notify({
                                message: res.errors,
                                icon: 'fa fa-xmarx' 
                            },{
                                type: "danger"
                            });
                        } else {
                            console.log(res);
                        }
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            }

            $(document).on('click','#minus',function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                minusQty(id);
                get_transaction();
            });

            function minusQty(id) {
                let qty = $('#qty').val();
                $.ajax({
                    url: '/admin/kasir/minus/'+id,
                    method: 'PUT',
                    data: {
                        qty: qty,
                    },
                    success: function(res) {
                        console.log(res);
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            }

            $(document).on('click', '#hps',function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                deleteTransaction(id);
                get_transaction();
            });

            function deleteTransaction(id) {
                $.ajax({
                    url: '/admin/kasir/'+id,
                    method: 'PUT',
                    success: function(res) {
                        $.notify({
                            message: 'Berhasil Menghapus Data Transaksi',
                            icon: 'fa fa-check' 
                        },{
                            type: "success"
                        });
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            }

            $('#btn_nota').click(function(e) {
                e.preventDefault();
                var printWindow =  window.open('/admin/kasir/print/nota', 'Print Data', 'height=600,width=800');
                printWindow.print();
                printWindow.onafterprint = function() {
                    printWindow.close();
                };
            }); 
        });
    </script>
@endpush