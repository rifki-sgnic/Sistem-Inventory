@extends('layouts.main')

@section('main-content')

<div id="content-tambahrequestbarang">

  <h1 class="h3 mb-2 text-gray-800">Tambah Data Request Barang</h1>
  <p class="mb-4">Inventory <sup>App</sup></p>

  <div class="card shadow mb-4">
    <div class="card-header py-3"></div>
    <div class="card-body">

      <div id="inputRequest" class="form-row">
        <div class="col-md-6">
          <label for="no_purchase_request">No Purchase Request</label>
          <input type="text" class="form-control" id="no_purchase_request">
          <div class="invalid-tooltip">
            No Purchase Request harus diisi.
          </div>
        </div>
        <div class="col-md-4">
          <label for="tanggal">Tanggal</label>
          <input type="date" class="form-control" id="tanggal">
          <div class="invalid-tooltip">
            Tanggal harus diisi.
          </div>
        </div>
        <div class="align-self-end">
          <button id="tambah_request" type="button" class="btn btn-primary">Tambah</button>
        </div>
        <div class="col align-self-end invalid-feedback">
          Input barang harus diisi.
        </div>
      </div>

      <div class="row">
        <div class="col-6">
          <div class="card mt-4">
            <div class="card-header">
              Input Barang
            </div>
            <div class="card-body">
              <div id="inputBarang" class="form-row">
                <div class="form-group col-md-6">
                  <label for="products_id">Produk</label>
                  <select name="products_id" id="products_id" class="form-control" required>
                    <option value="">Pilih produk ...</option>
                    @foreach ($products as $product)
                    <option value="{{ $product->id }}">{{ $product->kd_produk . ' - ' . $product->nama_produk . ' - ' . $product->merk }}
                    </option>
                    @endforeach
                  </select>
                  <div class="invalid-tooltip">
                    Nama Barang harus diisi.
                  </div>
                </div>
                <div class="form-group col-md-6">
                  <label for="jumlah">Jumlah</label>
                  <input type="number" class="form-control" id="jumlah" required>
                  <div class="invalid-tooltip">
                    Jumlah harus diisi.
                  </div>
                </div>
                <div class="form-group col-md-6">
                  <label for="harga">Harga</label>
                  <input type="number" class="form-control" id="harga" required>
                  <div class="invalid-tooltip">
                    Harga harus diisi.
                  </div>
                </div>
                <div class="form-group col-md-6">
                  <label for="remarks">Remarks</label>
                  <input type="text" class="form-control" id="remarks" required>
                  <div class="invalid-tooltip">
                    Remarks harus diisi.
                  </div>
                </div>
              </div>
              <button id="tambah_barang" type="button" class="btn btn-primary">Tambah</button>

              <div class="table-responsive-sm">
                <table id="tableRequest" class="table table-bordered table-hover table-sm text-center w-100 mt-4">
                  <thead class="w-100">
                    <tr>
                      <th>No</th>
                      <th>Nama Barang</th>
                      <th>Jumlah</th>
                      <th>Harga</th>
                      <th>Remarks</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        {{-- <div class="col align-self-center">
          <div class="spinner" hidden>
            <svg viewBox="25 25 50 50" class="circular">
              <circle stroke-miterlimit="10" stroke-width="3" fill="none" r="20" cy="50" cx="50" class="path"></circle>
            </svg>
          </div>
        </div> --}}
      </div>

    </div>
  </div>

</div>

@endsection
