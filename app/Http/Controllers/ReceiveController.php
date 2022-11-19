<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Receive;
use App\Models\StockTransaction;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ReceiveController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Receive::with('products', 'suppliers')->get();

            return DataTables::of($data)->make(true);
        }

        return view('admin.receive', [
            'title' => 'Barang Masuk',
            'products' => Product::all(),
            'suppliers' => Supplier::all(),
        ]);
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'created_at' => 'required',
            'products_id' => 'required',
            'qty' => 'required',
            'suppliers_id' => 'required',
            'note' => 'required'
        ]);

        $input = $request->all();
        Receive::create($input);
        StockTransaction::create([
            'products_id' => $input['products_id'],
            'qty' => $input['qty'],
        ]);

        $stock = StockTransaction::where('products_id', $input['products_id'])->get();
        Product::where('id', $input['products_id'])->increment('qty', $stock->sum('qty'));

        return redirect()->route('admin.receive')->with('success', 'Data berhasil ditambah!');
    }

    public function hapus(Request $request)
    {
        $id = $request->input('id');

        $data = Receive::findOrFail($id);

        $data->delete();

        return redirect()->route('admin.receive')->with('success', 'Data berhasil dihapus!');
    }
}
