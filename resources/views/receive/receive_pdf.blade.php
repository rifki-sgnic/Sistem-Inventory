<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
    integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  <title>Data Barang Masuk PDF</title>
</head>

<body>
  <center>
    <h2>Data Barang Masuk</h2>
    <h4>{{ $startDate }} - {{ $endDate }}</h4>
  </center>

  <table class="table table-bordered text-center">
    <thead>
      <tr>
        <th>No</th>
        <th>Kode Transaksi</th>
        <th>Tanggal</th>
        <th>Produk</th>
        <th>Qty</th>
        <th>Supplier</th>
        <th>Note</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($receives as $receive)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $receive->invoice_number }}</td>
        <td>{{ Carbon\Carbon::parse($receive->created_at)->isoFormat('DD MMMM YYYY') }}</td>
        <td>{{ $receive->products->kd_produk }} - {{ $receive->products->nama_produk }} - {{ $receive->products->type }}</td>
        <td>{{ $receive->qty }}</td>
        <td>{{ $receive->suppliers->kd_supplier }} - {{ $receive->suppliers->nama_supplier }}</td>
        <td>{{ $receive->note }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</body>

</html>
