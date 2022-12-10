@extends('layouts.main')

@section('main-content')

<div id="content-barangreturn">
  <h1 class="h3 mb-2 text-gray-800">Data Barang Return</h1>
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
        @hasrole('admin|superadmin')
        <button class="btn btn-sm btn-primary mx-1" data-toggle="modal" data-target="#modalTambahData"><i
            class="fa fa-plus text-white"></i> Tambah Data</button>
        @endhasrole
        <button class="btn btn-sm btn-success mx-1" data-toggle="modal" data-target="#modalCetakData"><i class="fa fa-print text-white"></i> Cetak Data</button>
      </div>

      <div class="table-responsive-sm">
        <table id="tableBarangReturn" class="table table-bordered table-hover table-sm text-center w-100">
          <thead class="w-100">
            <tr>
              <th>No</th>
              <th>Kode Transaksi</th>
              <th>Tanggal</th>
              <th>No Pre Order</th>
              <th>Produk</th>
              <th>Qty</th>
              <th>Note</th>
              <th>Status</th>
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
          <h4 class="modal-title">Input Barang Return</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <form action="{{ route('return.tambah') }}" method="post">
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <label for="no_pre_order">No Pre Order</label>
              <select name="list_products_id" id="no_pre_order" class="form-control" required>
                <option value="">Pilih no pre order ...</option>
                @foreach ($list_products as $list_product)
                <option value="{{ $list_product->id }}">{{ $list_product->no_pre_order }}
                </option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="produk">Produk</label>
              <select name="products_id" id="produk" class="form-control" required>
                <option value="">Pilih produk ...</option>
                @foreach ($products as $product)
                <option value="{{ $product->id }}">{{ $product->kd_produk . ' - ' . $product->nama_produk . ' - ' .
                  $product->merk }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="qty">QTY</label>
              <input type="number" name="qty" id="qty" placeholder="qty" class="form-control">
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
          <h4 class="modal-title">Update Barang Return</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <form action="{{ route('return.update') }}" method="post">
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <label for="no_pre_order">No Pre Order</label>
              <select name="no_pre_order" id="no_pre_order" class="form-control" required>
                <option value="">Pilih no po ...</option>
                @foreach ($list_products as $list_product)
                <option value="{{ $list_product->id }}">{{ $list_product->no_pre_order }}
                </option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="produk">Produk</label>
              <select name="products_id" id="produk" class="form-control" required>
                <option value="#">Pilih produk ...</option>
                @foreach ($products as $product)
                <option value="{{ $product->id }}">{{ $product->kd_produk . ' - ' . $product->nama_produk . ' - ' .
                  $product->merk }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="qty">QTY</label>
              <input type="number" name="qty" id="qty" placeholder="qty" class="form-control">
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
          <h4 class="modal-title">Hapus Barang Return</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <p class="my-2">Apakah Anda yakin ingin menghapus data "<strong class="text-dark"></strong>"?</p>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <form action="{{ route('return.hapus') }}" method="POST">
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
        <form action="{{ route('return.cetak') }}" method="post">
          <div class="modal-body">
            @csrf
            <div class="form-group row align-items-center">
              <label for="status" class="col-sm-4 col-form-label">Status</label>
              <div>:</div>
              <div class="col-sm-5">
                <select id="status" name="status" class="form-control">
                  <option value="">All Status</option>
                  <option value="on progress">On Progress</option>
                  <option value="done resolved">Done Resolved</option>
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
