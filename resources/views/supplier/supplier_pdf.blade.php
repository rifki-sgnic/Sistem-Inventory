<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
    integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  <title>Data Supplier PDF</title>
</head>
<body>
  <center>
    <h2>Data Supplier</h2>
  </center>
  <table class="table table-bordered text-center">
    <thead>
      <tr>
        <th>No</th>
        <th>Kode Supplier</th>
        <th>Nama Supplier</th>
        <th>Nomor Telepon</th>
        <th>Alamat</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($suppliers as $supplier)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $supplier->kd_supplier }}</td>
          <td>{{ $supplier->nama_supplier }}</td>
          <td>{{ $supplier->no_tlp }}</td>
          <td>{{ $supplier->alamat }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</body>
</html>
