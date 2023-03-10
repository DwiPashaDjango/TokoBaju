@extends('layouts.app')

@section('title') Tambah Produk Baru @endsection

@push('css')
<link rel="stylesheet" href="{{asset('css/bs-dropzone.min.css')}}" />
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endpush

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Opsss... Ada Yang Belum Di Isi Nih</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session('message'))
        <div class="alert alert-success">
            <strong>{{session('message')}}</strong>
        </div>
    @endif
    <div class="card">
        <div class="card-header">
            <h6>Tambah Produk Baru</h6>
        </div>
        <div class="card-body">
            <form action="{{url('/admin/product/add/save')}}" method="POST" id="prdct-form" enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-2">
                    <label for="">Nama Produk Baru</label>
                    <input type="text" name="nm_produk" value="{{old('nm_produk')}}" id="nm_produk" class="form-control" autocomplete="off">
                </div>
                <div class="form-group mb-2">
                    <label for="">Kategori Produk</label>
                    <select name="categoris_id" id="categoris_id" class="form-control">
                        <option>Pilih</option>
                        @foreach ($data as $item)
                            <option value="{{$item->id}}">{{$item->nm_kategori}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-2">
                    <label for="">Stock Produk</label>
                    <input type="number" value="{{old('stock_produk')}}" name="stock_produk" id="stock_produk" class="form-control" autocomplete="off">
                </div>
                <div class="form-group mb-2">
                    <label for="">Harga Produk</label>
                    <input type="number" value="{{old('harga_produk')}}" name="harga_produk" id="harga_produk" class="form-control" autocomplete="off">
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
    <script type="text/javascript" src="{{asset('')}}js/plugins/select2.min.js"></script>
    <script type="text/javascript" src="{{asset('')}}js/plugins/bs-dropzone.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#categoris_id').select2();
            $('#demo').bs_dropzone({
                dropzoneTemplate:'<div class="bs-dropzone"><div class="bs-dropzone-area"></div><div class="bs-dropzone-message"></div><div class="bs-dropzone-preview"></div></div>',
                parentTemplate:'<div class="row"></div>',
                childTemplate:'<div class="col"></div>',
            });
        });
    </script>
@endpush