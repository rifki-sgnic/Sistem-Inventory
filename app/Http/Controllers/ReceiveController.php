<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Receive;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\StockTransaction;
use Yajra\DataTables\Facades\DataTables;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class ReceiveController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Receive::with('products', 'suppliers')->get();

            return DataTables::of($data)->make(true);
        }

        return view('receive.receive', [
            'title' => 'Barang Masuk',
            'products' => Product::all(),
            'suppliers' => Supplier::all(),
            'product_names' => Product::select('nama_produk')->groupBy('nama_produk')->get(),
        ]);
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'created_at' => 'required',
            'products_id' => 'required',
            'qty' => 'required',
            'suppliers_id' => 'required',
        ]);

        $invoice = IdGenerator::generate(['table' => 'receives', 'field' => 'invoice_number', 'length' => 8, 'prefix' => 'BM-']);

        $input = $request->all();
        $input['invoice_number'] = $invoice;
        Receive::create($input);
        StockTransaction::create([
            'invoice_number' => $input['invoice_number'],
            'products_id' => $input['products_id'],
            'qty' => $input['qty'],
        ]);

        $stock = StockTransaction::where('invoice_number', $input['invoice_number'])->get()->first();
        Product::where('id', $input['products_id'])->increment('qty', $stock->qty);

        return redirect()->route('receive.index')->with('success', 'Data berhasil ditambah!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'created_at' => 'required',
            'products_id' => 'required',
            'qty' => 'required',
            'suppliers_id' => 'required',
            'note' => 'required'
        ]);

        $input = $request->except(['_token', 'submit']);

        Receive::whereId($request->id)->update($input);
        return redirect()->route('receive.index')->with('success', 'Data berhasil diupdate!');
    }

    public function hapus(Request $request)
    {
        $id = $request->input('id');
        $product_id = $request->input('products_id');
        $invoice_number = $request->input('invoice_number');

        $data = Receive::findOrFail($id);

        $stock = StockTransaction::where('invoice_number', $invoice_number)->get()->first();
        Product::where('id', $product_id)->decrement('qty', $stock->qty);

        StockTransaction::where('invoice_number', $invoice_number)->delete();

        $data->delete();

        return redirect()->route('receive.index')->with('success', 'Data berhasil dihapus!');
    }

    public function cetakPdf(Request $request)
    {
        $startDate = Carbon::createFromFormat('Y-m-d H', $request['start_date'] . '0')->startOfDay()->toDateTimeString();
        $endDate = Carbon::createFromFormat('Y-m-d H', $request['end_date'] . '23')->endOfDay()->toDateTimeString();

        if (!$request['nama_produk']) {
            /* All Product */
            $result = Receive::with('products', 'suppliers')->whereBetween('created_at', [$startDate, $endDate])->get();
        } else {
            /* Selected Product */
            $result = Receive::with('products', 'suppliers')
                ->whereRelation('products', 'nama_produk', '=', $request['nama_produk'])
                ->where([
                    ['created_at', '>=', $startDate],
                    ['created_at', '<=', $endDate]
                ])->get();
        }

        $pdf = Pdf::loadView('receive.receive_pdf', [
            'receives' => $result,
            'startDate' => Carbon::parse($startDate)->isoFormat('DD MMMM YYYY'),
            'endDate' => Carbon::parse($endDate)->isoFormat('DD MMMM YYYY'),
        ]);

        return $pdf->stream();
    }
}
