<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
    integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  <title>Data Request Barang PDF</title>
  <style>
    .nama {
      text-decoration: underline
    }
  </style>
</head>

<body>
  <center>
    <h2>Data Request Barang</h2>
    <h4>{{ $startDate }} - {{ $endDate }}</h4>
  </center>
  <table class="table table-bordered text-center">
    <thead>
      <tr>
        <th>No.</th>
        <th>No Purchase Request</th>
        <th>Tanggal</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($requests as $request)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $request->no_purchase_request }}</td>
        <td>{{ Carbon\Carbon::parse($request->created_at)->isoFormat('DD MMMM YYYY') }}</td>
        @if ($request->status == null)
        <td> - </td>
        @else
        <td>{{ ucwords($request->status) }}</td>
        @endif
      </tr>
      @endforeach
    </tbody>
  </table>
  <div style="d-flex flex-row-reverse">
    <div>
      <p>Disetujui oleh : </p>
      <img src="img/ttd.png" width="200" />
      <p class="nama">Manager</p>
    </div>
  </div>
</body>

</html>
