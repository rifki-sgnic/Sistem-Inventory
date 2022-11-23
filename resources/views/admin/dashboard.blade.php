@extends('layouts.main')

@section('main-content')
<div id="content-dashboard">
  <h1 class="h3 mb-2 text-gray-800">Dashboard</h1>
  <p>{{ auth()->user()->role }}</p>
  <div id="piechart"></div>

  <!-- DataTable -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Data History Transaksi</h6>
    </div>
    <div class="card-body">

      <nav>
        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
          <a class="nav-item nav-link active" id="custom-nav-a-tab" data-toggle="tab" href="#custom-nav-a" role="tab"
            aria-controls="custom-nav-a" aria-selected="true">History Barang Masuk Hari Ini</a>
          <a class="nav-item nav-link" id="custom-nav-b-tab" data-toggle="tab" href="#custom-nav-b" role="tab"
            aria-controls="custom-nav-b" aria-selected="false">History Barang Keluar Hari Ini </a>
        </div>
      </nav>

      <div class="tab-content" id="nav-tabContent">
        <div class="tab-content pl-3 pt-2" id="nav-tabContent">

          <div class="tab-pane fade show active" id="custom-nav-a" role="tabpanel" aria-labelledby="custom-nav-a-tab">
            <table style="margin-top: 20px;" id="tableBarangMasukHariIni" class="table table-hover table-bordered">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Tanggal</th>
                  <th>Rack No</th>
                  <th>Id Produk</th>
                  <th>Nama Produk</th>
                  <th>Qty</th>
                  <th>Satuan</th>
                  <th>Status</th>
                  <th>PIC</th>
                  <th>Note</th>
                </tr>
              </thead>
            </table>
          </div>

          <div class="tab-pane fade" id="custom-nav-b" role="tabpanel" aria-labelledby="custom-nav-b-tab">
            <table style="margin-top: 20px;" id="tableBarangKeluarHariIni" class="table table-hover table-bordered">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Tanggal</th>
                  <th>Rack No</th>
                  <th>Id Produk</th>
                  <th>Nama Produk</th>
                  <th>Qty</th>
                  <th>Satuan</th>
                  <th>Status</th>
                  <th>PIC</th>
                  <th>Note</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>No</td>
                  <td>Tanggal</td>
                  <td>Rack No</td>
                  <td>ID Produk</td>
                  <td>Nama Produk</td>
                  <td>Qty</td>
                  <td>Satuan</td>
                  <td>Status</td>
                  <td>PIC</td>
                  <td>Note</td>
                </tr>
              </tbody>
            </table>
          </div>

        </div>
      </div>

    </div>

  </div>
</div>
@endsection
