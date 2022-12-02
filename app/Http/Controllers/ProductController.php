<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Product;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::get();
            return DataTables::of($data)->make(true);
        }

        return view('master.master', [
            'title' => 'Master Barang',
            'products' => Product::all(),
            'product_names' => Product::select('nama_produk')->groupBy('nama_produk')->get(),
        ]);
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'kd_produk' => 'required',
            'nama_produk' => 'required',
            'type' => 'required',
            'merk' => 'required',
            'qty' => 'required',
        ]);

        $input = $request->all();
        Product::create($input);

        return redirect()->route('master.index')->with('success', 'Data berhasil disimpan!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'kd_produk' => 'required',
            'nama_produk' => 'required',
            'type' => 'required',
            'merk' => 'required',
            'qty' => 'required',
        ]);

        $input = $request->except(['_token', 'submit']);

        Product::whereId($request->id)->update($input);
        return redirect()->route('master.index')->with('success', 'Data berhasil diupdate!');
    }

    public function hapus(Request $request)
    {
        $id = $request->input('id');

        $data = Product::findOrFail($id);

        $data->delete();

        return redirect()->route('master.index')->with('success', 'Data berhasil dihapus!');
    }

    public function cetakPdf(Request $request)
    {
        $startDate = Carbon::createFromFormat('Y-m-d H', $request['start_date'] . '0')->startOfDay()->toDateTimeString();
        $endDate = Carbon::createFromFormat('Y-m-d H', $request['end_date'] . '23')->endOfDay()->toDateTimeString();

        if (!$request['nama_produk']) {
            /* All Product */
            $result = Product::whereBetween('created_at', [$startDate, $endDate])->get();
        } else {
            /* Selected Product */
            $result = Product::select()->where([
                ['nama_produk', '=', $request['nama_produk']],
                ['created_at', '>=', $startDate],
                ['created_at', '<=', $endDate]
            ])->get();
        }

        $pdf = Pdf::loadView('master.master_pdf', [
            'products' => $result,
            'startDate' => Carbon::parse($startDate)->isoFormat('DD MMMM YYYY'),
            'endDate' => Carbon::parse($endDate)->isoFormat('DD MMMM YYYY'),
        ]);

        return $pdf->stream();
    }
}
