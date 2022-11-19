@extends('layouts.main')

@section('main-content')
<div id="content-master">

  <h1 class="h3 mb-2 text-gray-800">Master Produk</h1>
  <p class="mb-4">Inventory <sup>App</sup></p>

  <div class="card shadow mb-4">
    <div class="card-header py-3"></div>
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
        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalTambahData"><i class="fa fa-plus text-white"></i> Tambah Data</button>
      </div>

      <div class="table-responsive-sm">
        <table id="tableMasterBarang" class="table table-striped table-hover text-center w-100 table-sm">
          <thead class="w-100">
            <tr>
              <th>No</th>
              <th>KD Produk</th>
              <th>Nama Produk</th>
              <th>Type</th>
              <th>Merk</th>
              <th>Qty</th>
              <th>Action</th>
            </tr>
          </thead>
        </table>
      </div>

    </div>
  </div>

  <!-- Modal Tambah Data -->
  <div class="modal" id="modalTambahData">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Input Master Barang</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <form action="{{ route('master.tambah') }}" id="masterForm" method="POST">
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <label for="kd_produk">KD Produk</label>
              <input type="text" id="kd_produk" name="kd_produk" placeholder="kd produk" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="nama">Nama Produk</label>
              <input type="text" id="nama" name="nama_produk" placeholder="nama produk" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="type">Type</label>
              <input type="text" id="type" name="type" placeholder="type" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="merk">Merk</label>
              <input type="text" id="merk" name="merk" placeholder="merk" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="qty">Qty</label>
              <input type="number" id="qty" name="qty" placeholder="qty" class="form-control" required>
            </div>

          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" name="submit">Simpan</button>
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
        <form action="{{ route('master.update') }}" id="masterForm" method="POST">
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <label for="kd_produk">KD Produk</label>
              <input type="text" id="kd_produk" name="kd_produk" placeholder="kd produk" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="nama">Nama Produk</label>
              <input type="text" id="nama" name="nama" placeholder="nama produk" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="type">Type</label>
              <input type="text" id="type" name="type" placeholder="type" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="merk">Merk</label>
              <input type="text" id="merk" name="merk" placeholder="merk" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="qty">Qty</label>
              <input type="number" id="qty" name="qty" placeholder="qty" class="form-control" required>
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
          <h4 class="modal-title">Hapus Master Barang</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <p class="my-2">Apakah Anda yakin ingin menghapus data "<strong class="text-dark"></strong>"?</p>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <form action="{{ route('master.hapus') }}" method="POST">
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
