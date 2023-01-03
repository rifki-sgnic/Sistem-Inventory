@extends('layouts.main')

@section('main-content')

<div id="content-detailrequestbarang">
  <h1 class="h3 mb-2 text-gray-800">Detail Request Barang</h1>
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

      <div class="d-flex justify-content-between">
        <h3>No PR: {{ $detail->no_purchase_request }}</h3>
        {{ Carbon\Carbon::parse($detail->created_at)->isoFormat('DD MMMM YYYY') }}
      </div>

      <div class="row mt-4">
        <div class="col-8">
          <div class="table-responsive-sm">
            <table id="tableDetailRequest" class="table table-bordered table-hover table-sm text-center">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Produk</th>
                  <th>Jumlah</th>
                  <th>Harga</th>
                  <th>Remarks</th>
                  @hasrole('warehouse|testing')
                  <th>Note</th>
                  @endhasrole
                  @hasrole('superadmin|purchasing|testing')
                  <th>Aksi</th>
                  @endhasrole
                </tr>
              </thead>
              <tbody>
                @foreach ($detail->request_product_detail as $item)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td id="produk">{{ $item->products->kd_produk }} - {{ $item->products->nama_produk }} - {{ $item->products->type }}</td>
                  <td id="qty">{{ $item->qty }}</td>
                  <td id="harga">{{ $item->harga }}</td>
                  <td id="remarks">{{ $item->remarks }}</td>
                  <td id="id" hidden>{{ $item->id }}</td>
                  @hasrole('warehouse|testing')
                  @if ($item->note != '')
                    <td id="note">{{ $item->note }}</td>
                  @else
                    <td id="note"><button type="button" value="add-note" class="btn btn-sm btn-success"><i class="fa fa-plus text-white"></i>
                      Add</button>
                    </td>
                  @endif
                  @endhasrole
                  @hasrole('superadmin|purchasing|testing')
                  <td>
                    <button type="button" value="update" class="btn btn-sm btn-warning"><i class="fa fa-pen text-white"></i>
                      Edit</button>
                    <button type="button" value="delete" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</button>
                  </td>
                  @endhasrole
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
        @hasrole('superadmin|testing')
        <div class="col">
          <form action="{{ route('request-barang.update-status') }}" method="POST">
            @csrf
            <div class="form-group">
              <label for="status">Status</label>
              <select class="form-control form-control-sm col-md-4" name="status" id="status">
                <option value="" @selected($detail->status == '')>Choose...</option>
                <option value="approved" @selected($detail->status == 'approved')>Approved</option>
                <option value="rejected" @selected($detail->status == 'rejected')>Rejected</option>
              </select>
            </div>
            <div class="form-group">
              <label for="comment">Comment</label>
              <textarea name="comment" class="form-control" id="comment" rows="3">{{ $detail->comment }}</textarea>
            </div>
            <input type="hidden" name="no_purchase_request" value="{{ $detail->no_purchase_request }}">
            <button type="submit" class="btn btn-primary btn-sm my-1">Update</button>
          </form>
        </div>
        @endhasrole
        @hasrole('admin|purchasing')
        <div class="col">
          <div class="form-group">
            <label for="status">Status : </label>
            @if ($detail->status == 'approved')
            <span class="btn btn-sm btn-success disabled">Approved</span>
            @elseif ($detail->status == 'rejected')
            <span class="btn btn-sm btn-danger disabled">Rejected</span>
            @else
            <span class="btn btn-sm btn-secondary disabled"> - </span>
            @endif
          </div>
          <div class="form-group">
            <label for="comment">Comment</label>
            <textarea name="comment" class="form-control" id="comment" rows="3" disabled>{{ $detail->comment }}</textarea>
          </div>
        </div>
        @endhasrole
      </div>

    </div>
  </div>

  <!-- Modal Ubah Data -->
  <div class="modal" id="modalUpdateData">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Update Detail Request Barang</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <form action="{{ route('request-barang.update-produk') }}" method="POST">
        @csrf
          <div class="modal-body">
            <div class="form-group">
              <label for="produk">Produk</label>
              <input type="text" id="produk" name="produk" placeholder="Produk" class="form-control" disabled>
            </div>
            <div class="form-group">
              <label for="qty">Qty</label>
              <input type="number" id="qty" name="qty" placeholder="qty" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="harga">Harga</label>
              <input type="number" id="harga" name="harga" placeholder="Harga" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="remarks">Remarks</label>
              <input type="text" id="remarks" name="remarks" placeholder="Remarks" class="form-control" required>
            </div>
            <input type="hidden" name="id" required readonly>
            <input type="hidden" name="no_purchase_request" required readonly value="{{ $detail->no_purchase_request }}">
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
        </form>
      </div>
    </div>
  </div>

<!-- Modal Tambah Note -->
<div class="modal" id="modalAddNote">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add Note Detail Request Barang</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <form action="{{ route('request-barang.add-note-produk') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="note">Note</label>
            <textarea class="form-control" id="note" name="note" rows="3"></textarea>
          </div>
          <input type="hidden" name="id" required readonly>
          <input type="hidden" name="no_purchase_request" required readonly value="{{ $detail->no_purchase_request }}">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
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
          <form action="{{ route('request-barang.hapus-produk') }}" method="POST">
            @csrf
            <input type="hidden" name="id" required readonly>
            <input type="hidden" name="no_purchase_request" required readonly value="{{ $detail->no_purchase_request }}">
            <button type="submit" class="btn btn-primary">Hapus</button>
          </form>
        </div>
      </div>
    </div>
  </div>

</div>

@endsection
