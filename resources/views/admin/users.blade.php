@extends('layouts.app')

@section('title') Data Karyawan @endsection

@push('css')
    
@endpush

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped text-center" id="krywn-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>Nik</th>
                            <th>Email</th>
                            <th>TTL</th>
                            <th>Terdafar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($data as $item)
                            <tr>
                                <th>{{$no++}}</th>
                                <td>{{$item->name}}</td>
                                <td>{{$item->jk}}</td>
                                <td>{{$item->nik}}</td>
                                <td>{{$item->email}}</td>
                                <td>{{$item->tempat_lahir}},{{date('d F Y', strtotime($item->tgl_lahir))}}</td>
                                <td>{{date('d F Y', strtotime($item->created_at))}}</td>
                                <td>
                                    <a href="{{url('/admin/karyawan/'. $item->id .'/edit')}}">Edit</a>
                                    <span>|</span>
                                    <a href="{{url('/admin/karyawan/'. $item->id .'/hapus')}}">Hapus</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script type="text/javascript" src="{{asset('js/plugins/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/plugins/dataTables.bootstrap.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#krywn-table').DataTable();
        });
    </script>
@endpush