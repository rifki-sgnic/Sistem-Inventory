<?php

namespace App\Http\Controllers;

use App\Models\ListProduct;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\ReturnProduct;
use App\Models\StockTransaction;
use Yajra\DataTables\Facades\DataTables;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class ReturnController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ReturnProduct::with('products', 'list_products')->get();

            return DataTables::of($data)->make(true);
        }

        return view('admin.return', [
            'title' => 'Return',
            'products' => Product::all(),
            'list_products' => ListProduct::all(),
        ]);
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'created_at' => 'required',
            'products_id' => 'required',
            'qty' => 'required',
            'list_products_id' => 'required',
            'note' => 'required'
        ]);

        $invoice = IdGenerator::generate(['table' => 'return_products', 'field' => 'invoice_number', 'length' => 8, 'prefix' => 'BR-']);

        $input = $request->all();
        $input['invoice_number'] = $invoice;
        ReturnProduct::create($input);
        StockTransaction::create([
            'invoice_number' => $input['invoice_number'],
            'products_id' => $input['products_id'],
            'qty' => $input['qty'],
        ]);

        $stock = StockTransaction::where('invoice_number', $input['invoice_number'])->get()->first();
        Product::where('id', $input['products_id'])->increment('qty', $stock->qty);

        return redirect()->route('admin.return')->with('success', 'Data berhasil ditambah!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'created_at' => 'required',
            'products_id' => 'required',
            'qty' => 'required',
            'list_products_id' => 'required',
            'note' => 'required'
        ]);

        $input = $request->except(['_token', 'submit']);

        ReturnProduct::whereId($request->id)->update($input);
        return redirect()->route('admin.return')->with('success', 'Data berhasil diupdate!');
    }

    public function hapus(Request $request)
    {
        $id = $request->input('id');
        $product_id = $request->input('products_id');
        $invoice_number = $request->input('invoice_number');

        $data = ReturnProduct::findOrFail($id);

        $stock = StockTransaction::where('invoice_number', $invoice_number)->get()->first();
        Product::where('id', $product_id)->decrement('qty', $stock->qty);

        StockTransaction::where('invoice_number', $invoice_number)->delete();

        $data->delete();

        return redirect()->route('admin.return')->with('success', 'Data berhasil dihapus!');
    }
}
