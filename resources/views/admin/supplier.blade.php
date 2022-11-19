@extends('layouts.main')

@section('main-content')

<div id="content-supplier">
  <h1 class="h3 mb-2 text-gray-800">Data Supplier</h1>
  <p class="mb-4">Inventory <sup>App</sup></p>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
    </div>
    <div class="card-body">

      @if ($message = session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ $message }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      @elseif($errors->any())
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      @endif

      <div class="d-flex flex-row mb-3">
        <button class="btn btn-sm btn-primary mx-1" data-toggle="modal" data-target="#modalTambahData"><i class="fa fa-plus text-white"></i> Tambah Data</button>
        <button class="btn btn-sm btn-success mx-1"><i class="fa fa-print text-white"></i> Cetak Data</button>
      </div>

      <div class="table-responsive-sm">
        <table id="tableSupplier" class="table table-bordered text-center table-hover w-100 table-sm">
          <thead bgcolor="eeeeee" align="center" class="w-100">
            <tr>
              <th>No</th>
              <th>KD supplier</th>
              <th>Nama supplier</th>
              <th>Nomor telepon</th>
              <th>Alamat</th>
              <th class="text-center"> Action </th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>

  <!-- Modal Tambah Data -->
  <div class="modal" id="modalTambahData">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Input Data Supplier</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <form action="{{ route('supplier.tambah') }}" method="post">
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <label for="kd supplier">KD Supplier</label>
              <input type="text" name="kd_supplier" placeholder="kd supplier" class="form-control">
            </div>
            <div class="form-group">
              <label for="nama supplier">Nama Supplier</label>
              <input type="text" name="nama_supplier" placeholder="nama supplier" class="form-control">
            </div>
            <div class="form-group">
              <label for="nomor telepon">Nomor Telepon</label>
              <input type="text" name="no_tlp" placeholder="nomor telepon" class="form-control">
            </div>
            <div class="form-group">
              <label for="alamat">Alamat</label>
              <input type="text" name="alamat" placeholder="alamat" class="form-control">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" name="simpanSupplier">Simpan</button>
          </div>
        </form>

      </div>
    </div>
  </div>

  <!-- Modal Ubah Data -->
  <div class="modal" id="modalUpdateData">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Update Master Barang</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <form action="{{ route('supplier.update') }}" id="masterForm" method="POST">
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <label for="kd supplier">KD Supplier</label>
              <input type="text" name="kd_supplier" placeholder="kd supplier" class="form-control">
            </div>
            <div class="form-group">
              <label for="nama supplier">Nama Supplier</label>
              <input type="text" name="nama_supplier" placeholder="nama supplier" class="form-control">
            </div>
            <div class="form-group">
              <label for="nomor telepon">Nomor Telepon</label>
              <input type="text" name="no_tlp" placeholder="nomor telepon" class="form-control">
            </div>
            <div class="form-group">
              <label for="alamat">Alamat</label>
              <input type="text" name="alamat" placeholder="alamat" class="form-control">
            </div>
            <input type="hidden" name="id" required readonly>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" name="submit">Update</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal Hapus Data -->
  <div class="modal" id="modalHapusData">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Hapus Data Supplier</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <p class="my-2">Apakah Anda yakin ingin menghapus data "<strong class="text-dark"></strong>"?</p>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <form action="{{ route('supplier.hapus') }}" method="POST">
            @csrf
            <input type="hidden" name="id" required readonly>
            <button type="submit" class="btn btn-primary">Hapus</button>
          </form>
        </div>
      </div>
    </div>
  </div>

</div>

@endsection
