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
            <form action="{{url('/admin/product/image/save/' . $data->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method("PUT")
                <label for="">Foto Produk</label>
                <div class="text-center">
                    <input type="file" class="text-center dropzone form-control" name="image_produk" id="">
                </div>
                <div class="form-group my-2">
                    <label for="">Keterangan Produk</label>
                    <textarea name="isi_produk" id="isi_produk" class="form-control" cols="30" rows="10">{{old('isi_produk')}}</textarea>
                </div>
                <div class="my-4">
                    <button class="btn btn-primary btn-md float-right ml-2 add">Simpan</button>
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