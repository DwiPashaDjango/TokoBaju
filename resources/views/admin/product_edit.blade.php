@extends('layouts.app')

@section('title') {{$data->nm_produk}} @endsection

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
            <h6>Edit {{$data->nm_produk}}</h6>
        </div>
        <div class="card-body">
            <form action="{{url('/admin/product/edit/save/' . $data->id)}}" method="POST" id="prdct-form" enctype="multipart/form-data">
                @csrf
                @method("PUT")
                <div class="form-group mb-2">
                    <label for="">Nama Produk Baru</label>
                    <input type="text" name="nm_produk" value="{{$data->nm_produk}}" id="nm_produk" class="form-control" autocomplete="off">
                </div>
                <div class="form-group mb-2">
                    <label for="">Kategori Produk</label>
                    <select name="categoris_id" id="categoris_id" class="form-control">
                        <option value="{{$data->kategori->id}}">{{$data->kategori->nm_kategori}}</option>
                        @foreach ($cat as $item)
                            <option value="{{$item->id}}">{{$item->nm_kategori}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-2">
                    <label for="">Stock Produk</label>
                    <input type="number" value="{{$data->stock_produk}}" name="stock_produk" id="stock_produk" class="form-control" autocomplete="off">
                </div>
                <div class="form-group mb-2">
                    <label for="">Harga Produk</label>
                    <input type="number" value="{{$data->harga_produk}}" name="harga_produk" id="harga_produk" class="form-control" autocomplete="off">
                </div>
                <div class="my-3">
                    <label for="">Foto Produk</label>
                    <input type="file" class="text-center dropzone form-control" value="{{$data->image_produk}}" name="image_produk" id="demo">
                </div>
                <div class="form-group mb-2">
                    <label for="">Keterangan Produk</label>
                    <textarea name="isi_produk" id="isi_produk" class="form-control" cols="30" rows="10">{!!$data->isi_produk!!}</textarea>
                </div>

                <div class="my-4">
                    <button class="btn btn-primary btn-md float-right ml-2 add">Edit</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script type="text/javascript" src="{{asset('')}}js/plugins/select2.min.js"></script>
    <script type="text/javascript" src="{{asset('')}}js/plugins/dropzone.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#categoris_id').select2();
            $('#isi_produk').summernote();
        });
    </script>
@endpush