<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
    integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  <title>Data Master Barang PDF</title>
</head>

<body>
  <center>
    <h2>Data Produk</h2>
    <h4>{{ $startDate }} - {{ $endDate }}</h4>
  </center>
  <table class="table table-bordered text-center">
    <thead>
      <tr>
        <th>No</th>
        <th>KD Produk</th>
        <th>Nama Produk</th>
        <th>Type</th>
        <th>Merk</th>
        <th>Qty</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($products as $product)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $product->kd_produk }}</td>
        <td>{{ $product->nama_produk }}</td>
        <td>{{ $product->type }}</td>
        <td>{{ $product->merk }}</td>
        <td>{{ $product->qty }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</body>

</html>
