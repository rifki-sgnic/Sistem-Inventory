<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\StockTransaction;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Transaction::with('products')->get();

            return DataTables::of($data)->make(true);
        }

        return view('transaction.transaction', [
            'title' => 'Barang Keluar',
            'products' => Product::all(),
            'product_names' => Product::select('nama_produk')->groupBy('nama_produk')->get(),
        ]);
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'created_at' => 'required',
            'products_id' => 'required',
            'qty' => 'required',
            'pic' => 'required',
            "file" => "file|max:5120",
        ]);

        $input = $request->all();

        $prod_qty = Product::select('qty')->where('id', $input['products_id'])->get()->first();

        if ($input['qty'] > $prod_qty->qty) {
            return redirect()->route('transaction.index')->with('error', 'Jumlah produk melebihi batas! Produk tersisa '. $prod_qty->qty);
        } else {
            $invoice = IdGenerator::generate(['table' => 'transactions', 'field' => 'invoice_number', 'length' => 8, 'prefix' => 'BK-']);
            $input['invoice_number'] = $invoice;

            if ($request->file('file')) {
                $fileName = $request->file('file')->getClientOriginalName();
                $input['file'] = $fileName;

                $request->file('file')->storeAs('post-pdf', $fileName);
            }

            Transaction::create($input);
            StockTransaction::create([
                'invoice_number' => $input['invoice_number'],
                'products_id' => $input['products_id'],
                'qty' => $input['qty'],
            ]);

            $stock = StockTransaction::where('products_id', $input['products_id'])->get()->first();
            Product::where('id', $input['products_id'])->decrement('qty', $stock->qty);

            return redirect()->route('transaction.index')->with('success', 'Data berhasil ditambah!');
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'created_at' => 'required',
            'pic' => 'required',
        ]);

        $input = $request->except(['_token', 'submit']);

        Transaction::whereId($request->id)->update($input);
        return redirect()->route('transaction.index')->with('success', 'Data berhasil diupdate!');
    }

    public function hapus(Request $request)
    {
        $id = $request->input('id');
        $product_id = $request->input('products_id');
        $invoice_number = $request->input('invoice_number');

        $data = Transaction::findOrFail($id);

        Storage::disk('public')->delete('post-pdf/' . $data['file']);
        $data->delete();

        $stock = StockTransaction::where('products_id', $product_id)->get()->first();
        Product::where('id', $product_id)->increment('qty', $stock->qty);

        StockTransaction::where('invoice_number', $invoice_number)->delete();

        $data->delete();

        return redirect()->route('transaction.index')->with('success', 'Data berhasil dihapus!');
    }

    public function cetakPdf(Request $request)
    {
        $startDate = Carbon::createFromFormat('Y-m-d H', $request['start_date'] . '0')->startOfDay()->toDateTimeString();
        $endDate = Carbon::createFromFormat('Y-m-d H', $request['end_date'] . '23')->endOfDay()->toDateTimeString();

        if (!$request['nama_produk']) {
            /* All Product */
            $result = Transaction::with('products')->whereBetween('created_at', [$startDate, $endDate])->get();
        } else {
            /* Selected Product */
            $result = Transaction::with('products')
            ->whereRelation('products', 'nama_produk', '=', $request['nama_produk'])
            ->where([
                ['created_at', '>=', $startDate],
                ['created_at', '<=', $endDate]
            ])->get();
        }

        $pdf = Pdf::loadView('transaction.transaction_pdf', [
            'transactions' => $result,
            'startDate' => Carbon::parse($startDate)->isoFormat('DD MMMM YYYY'),
            'endDate' => Carbon::parse($endDate)->isoFormat('DD MMMM YYYY'),
        ]);

        return $pdf->stream();
    }
}
