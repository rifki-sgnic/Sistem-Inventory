@extends('layouts.main')

@section('main-content')

<div id="content-userdata">
  <h1 class="h3 mb-2 text-gray-800">Data User</h1>
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
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus text-white"></i> Tambah Data</button>
      </div>

      <div class="table-responsive-sm">
        <table id="tableUserData" class="table table-bordered text-center table-hover w-100 table-sm">
          <thead bgcolor="eeeeee" align="center" class="w-100">
            <tr>
              <th class="text-center">No.</th>
              <th class="text-center">Nama</th>
              <th class="text-center">Username</th>
              <th class="text-center">Level</th>
              <th class="text-center">Action</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>


  <!-- The Modal -->
  <div class="modal" id="myModal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Input Data User</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <form action="{{ route('user-management.tambah') }}" method="POST">
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <label for="username">Nama</label>
              <input type="text" name="name" placeholder="Nama" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" name="username" placeholder="username" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="text" name="password" placeholder="password" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="level">Level</label>
              <select class="form-control" name="role">
                <option>Pilih Level ...</option>
                @foreach ($roles as $role)
                  <option value="{{ $role->role }}">{{ $role->level }}</option>
                @endforeach
              </select>
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

  <!-- Modal Hapus Data -->
  <div class="modal" id="modalHapusData">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Hapus User</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <p class="my-2">Apakah Anda yakin ingin menghapus data "<strong class="text-dark"></strong>"?</p>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <form action="{{ route('user-management.hapus') }}" method="POST">
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
