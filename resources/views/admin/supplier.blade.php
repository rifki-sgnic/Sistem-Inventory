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

      <div class="d-flex flex-row mb-3">
        <button class="btn btn-primary mx-1" data-toggle="modal" data-target="#modalTambahData"><i class="fa fa-plus text-white"></i> Tambah Data</button>
        <a href="404.php" role="button" class="btn btn-success mx-1"><i class="fa fa-print text-white"></i> Cetak Data</a>
      </div>

      <div class="table-responsive-sm">
        <table id="tableSupplier" class="table table-bordered table-hover w-100">
          <thead bgcolor="eeeeee" align="center" class="w-100">
            <tr>
              <th>No.</th>
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
        <div class="modal-body">
          <form method="post" action="">
            <div class="form-group">
              <label for="kd supplier">KD Supplier</label>
              <input type="text" name="kd supplier" placeholder="kd supplier" class="form-control">
            </div>
            <div class="form-group">
              <label for="nama supplier">Nama Supplier</label>
              <input type="text" name="nama_supplier" placeholder="nama supplier" class="form-control">
            </div>
            <div class="form-group">
              <label for="nomor telepon">Nomor Telepon</label>
              <input type="text" name="nomor telepon" placeholder="nomor telepon" class="form-control">
            </div>
            <div class="form-group">
              <label for="alamat">Alamat</label>
              <input type="text" name="alamat" placeholder="alamat" class="form-control">
            </div>
          </form>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="simpanSupplier">Simpan</button>
        </div>

      </div>
    </div>
  </div>

</div>

@endsection
