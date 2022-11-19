<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Supplier::get();
            return DataTables::of($data)->make(true);
        }

        return view('admin.supplier', [
            'title' => 'Supplier'
        ]);
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'kd_supplier' => 'required',
            'nama_supplier' => 'required',
            'no_tlp' => 'required',
            'alamat' => 'required'
        ]);

        $input = $request->all();

        Supplier::create($input);

        return redirect()->route('admin.supplier')->with('success', 'Data berhasil ditambah!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'kd_supplier' => 'required',
            'nama_supplier' => 'required',
            'no_tlp' => 'required',
            'alamat' => 'required'
        ]);

        $input = $request->except(['_token', 'submit']);

        Supplier::whereId($request->id)->update($input);

        return redirect()->route('admin.supplier')->with('success', 'Data berhasil diupdate!');
    }

    public function hapus(Request $request)
    {
        $id = $request->id;

        $data = Supplier::findOrFail($id);

        $data->delete();

        return redirect()->route('admin.supplier')->with('success', 'Data berhasil dihapus!');
    }
}
