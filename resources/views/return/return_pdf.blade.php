<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
    integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  <title>Data Return Barang PDF</title>
</head>

<body>
  <center>
    <h2>Data Return Barang</h2>
    <h4>{{ $startDate }} - {{ $endDate }}</h4>
  </center>
  <table class="table table-bordered text-center">
    <thead>
      <tr>
        <th>No.</th>
        <th>Kode Transaksi</th>
        <th>Tanggal</th>
        <th>No Pre Order</th>
        <th>Produk</th>
        <th>Qty</th>
        <th>Status</th>
        <th>Note</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($returnProducts as $product)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $product->invoice_number }}</td>
        <td>{{ Carbon\Carbon::parse($product->created_at)->isoFormat('DD MMMM YYYY') }}</td>
        <td>{{ $product->list_products->no_pre_order }}</td>
        <td>{{ $product->products->kd_produk }} - {{ $product->products->nama_produk }} - {{ $product->products->type }}</td>
        <td>{{ $product->qty }}</td>
        @if ($product->status == null)
        <td> - </td>
        @else
        <td>{{ ucwords($product->status) }}</td>
        @endif
        <td>{{ $product->note }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</body>

</html>
