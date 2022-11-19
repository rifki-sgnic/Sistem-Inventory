<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::get();
            return DataTables::of($data)->make(true);
        }

        return view('admin.master', [
            'title' => 'Master Barang',
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

        return redirect()->route('admin.master')->with('success', 'Data berhasil disimpan!');
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
        return redirect()->route('admin.master')->with('success', 'Data berhasil diupdate!');
    }

    public function hapus(Request $request)
    {
        $id = $request->input('id');

        $data = Product::findOrFail($id);

        $data->delete();

        return redirect()->route('admin.master')->with('success', 'Data berhasil dihapus!');
    }
}
