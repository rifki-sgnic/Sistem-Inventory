@extends('layouts.main')

@section('main-content')

<div id="content-barangmasuk">
  <h1 class="h3 mb-2 text-gray-800">Data Barang Masuk</h1>
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
        <button class="btn btn-sm btn-primary mx-1" data-toggle="modal" data-target="#modalTambahData"><i
            class="fa fa-plus text-white"></i> Tambah Data</button>
        <button class="btn btn-sm btn-success mx-1" data-toggle="modal" data-target="#modalCetakData"><i class="fa fa-print text-white"></i> Cetak Data</button>
      </div>

      <div class="table-responsive-sm">
        <table id="tableReceive" class="table table-bordered table-hover table-sm text-center w-100">
          <thead class="w-100">
            <tr>
              <th>No</th>
              <th>Kode Transaksi</th>
              <th>Tanggal</th>
              <th>Produk</th>
              <th>Qty</th>
              <th>Supplier</th>
              <th>Note</th>
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
          <h4 class="modal-title">Input Barang Masuk</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <form action="{{ route('receive.tambah') }}" method="post">
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <label for="produk">Produk</label>
              <select name="products_id" id="produk" class="form-control" required>
                <option value="">Pilih produk ...</option>
                @foreach ($products as $product)
                <option value="{{ $product->id }}">{{ $product->kd_produk . ' - ' . $product->nama_produk . ' - ' . $product->merk }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="qty">QTY</label>
              <input type="number" name="qty" id="qty" placeholder="qty" class="form-control">
            </div>
            <div class="form-group">
              <label for="supplier">Supplier</label>
              <select name="suppliers_id" id="supplier" class="form-control" required>
                <option value="#">Pilih supplier ...</option>
                @foreach ($suppliers as $supplier)
                <option value="{{ $supplier->id }}">{{ $supplier->kd_supplier . ' - ' . $supplier->nama_supplier }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="tanggal">Tanggal</label>
              <input type="date" name="created_at" id="tanggal" placeholder="tanggal" class="form-control">
            </div>
            <div class="form-group">
              <label for="note">Noted</label>
              <textarea class="form-control" name="note" id="note" rows="3"></textarea>
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
          <h4 class="modal-title">Update Barang Masuk</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <form action="{{ route('receive.update') }}" method="post">
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <label for="produk">Produk</label>
              <select name="products_id" id="produk" class="form-control" disabled>
                <option value="#">Pilih produk ...</option>
                @foreach ($products as $product)
                <option value="{{ $product->id }}">{{ $product->kd_produk . ' - ' . $product->nama_produk . ' - ' .
                  $product->merk }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="qty">QTY</label>
              <input type="number" name="qty" id="qty" placeholder="qty" class="form-control" disabled>
            </div>
            <div class="form-group">
              <label for="supplier">Supplier</label>
              <select name="suppliers_id" id="supplier" class="form-control">
                <option value="#">Pilih supplier ...</option>
                @foreach ($suppliers as $supplier)
                <option value="{{ $supplier->id }}">{{ $supplier->kd_supplier . ' - ' . $supplier->nama_supplier }}
                </option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="tanggal">Tanggal</label>
              <input type="date" name="created_at" id="tanggal" placeholder="tanggal" class="form-control">
            </div>
            <div class="form-group">
              <label for="note">Noted</label>
              <textarea class="form-control" name="note" id="note" rows="3"></textarea>
            </div>
            <input type="hidden" name="id" required readonly>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" name="submit">Simpan</button>
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
          <h4 class="modal-title">Hapus Barang Masuk</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <p class="my-2">Apakah Anda yakin ingin menghapus data "<strong class="text-dark"></strong>"?</p>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <form action="{{ route('receive.hapus') }}" method="POST">
            @csrf
            <input type="hidden" name="id" required readonly>
            <input type="hidden" name="products_id" required readonly>
            <input type="hidden" name="invoice_number" required readonly>
            <button type="submit" class="btn btn-primary">Hapus</button>
          </form>
        </div>
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
        <form action="{{ route('receive.cetak') }}" method="post">
          <div class="modal-body">
            @csrf
            <div class="form-group row align-items-center">
              <label for="nama_produk" class="col-sm-4 col-form-label">Nama Produk</label>
              <div>:</div>
              <div class="col-sm-5">
                <select id="nama_produk" name="nama_produk" class="form-control">
                  <option value="">All Item</option>
                  @foreach ($product_names as $product_name)
                  <option value="{{ $product_name->nama_produk }}">{{ $product_name->nama_produk }}</option>
                  @endforeach
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
            {{-- <a href="{{ route('receive.cetak') }}" class="btn btn-primary">Cetak Data</a> --}}
            <button type="submit" class="btn btn-primary" name="submit">Cetak Data</button>
          </div>
        </form>

      </div>
    </div>
  </div>

</div>

@endsection
