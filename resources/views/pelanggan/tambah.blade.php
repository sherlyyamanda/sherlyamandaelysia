@extends('layouts.template')
@section('judulh1','Admin - Pelanggan')
@section('konten')
<div class="col-md-6">
 @if ($errors->any())
 <div class="alert alert-danger">
 <strong>Whoops!</strong> There were some problems with your 
input.<br><br>
 <ul>
 @foreach ($errors->all() as $error)
 <li>{{ $error }}</li>
 @endforeach
 </ul>
 </div>
 @endif
 <div class="card card-success">
 <div class="card-header">
 <h3 class="card-title">Tambah Data Pelanggan</h3>
 </div>
 <!-- /.card-header -->
 <!-- form start -->
 <form action="{{ route('pelanggan.store') }}" method="POST">
 @csrf
 <div class="form-group">
 <label for="nama">Nama Pelanggan</label>
 <input type="nama" class="form-control" id="nama"
 name="nama">
 <div class="form-group">
 <label for="hp">No telepon</label>
 <input type="text" class="form-control" id="hp"
 name="hp">
 <div class="form-group">
 <label for="alamat">Alamat</label>
 <textarea id="alamat" name="alamat" class=" form-control" rows="4"></textarea>
 </div>
 </div>
</div>
 <!-- /.card-body -->
 <div class="card-footer">
 <button type="submit" class="btn btn-success float-right">Simpan</button>
 </div>
 </form>
 </div>
</div>
@endsection