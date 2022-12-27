@extends('layouts.main')

@section('main-content')

<div id="content-requestbarang">
  <h1 class="h3 mb-2 text-gray-800">Data Request Barang</h1>
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
        @hasrole('admin|superadmin|testing')
        <a href="{{ route('request-barang.tambah') }}" class="btn btn-sm btn-primary mx-1"><i
            class="fa fa-plus text-white"></i> Tambah Data</a>
        @endhasrole
        <button class="btn btn-sm btn-success mx-1" data-toggle="modal" data-target="#modalCetakData"><i
            class="fa fa-print text-white"></i> Cetak Data</button>
      </div>

      <div class="table-responsive-sm">
        <table id="tableBarangRequest" class="table table-bordered table-hover table-sm text-center w-100">
          <thead class="w-100">
            <tr>
              <th>No</th>
              <th>No Purchase Request</th>
              <th>Tanggal</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>

  <!-- The Modal -->
  <div class="modal" id="modalCetakData">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Cetak PDF</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <form action="{{ route('request-barang.cetak') }}" method="post">
          <div class="modal-body">
            @csrf
            <div class="form-group row align-items-center">
              <label for="status" class="col-sm-4 col-form-label">Nama Produk</label>
              <div>:</div>
              <div class="col-sm-5">
                <select id="status" name="status" class="form-control">
                  <option value="">All Status</option>
                  <option value="approved">Approved</option>
                  <option value="rejected">Rejected</option>
                </select>
              </div>
            </div>
            <div class="form-group row align-items-center">
              <label for="start_date" class="col-sm-4 col-form-label">Dari Tanggal</label>
              <div>:</div>
              <div class="col-sm-5">
                <input type="date" name="start_date" id="start_date" class="form-control" required>
              </div>
            </div>
            <div class="form-group row align-items-center">
              <label for="end_date" class="col-sm-4 col-form-label">Sampai Tanggal</label>
              <div>:</div>
              <div class="col-sm-5">
                <input type="date" name="end_date" id="end_date" class="form-control" required>
              </div>
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" name="submit">Cetak Data</button>
          </div>
        </form>

      </div>
    </div>
  </div>

</div>

@endsection
