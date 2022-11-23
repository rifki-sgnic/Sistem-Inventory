<?php

namespace App\Http\Controllers;

use App\Models\ListProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ListProductController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ListProduct::get();
            return DataTables::of($data)->make(true);
        }

        return view('admin.listbarang', [
            'title' => 'List Barang',
        ]);
    }

    public function tambah(Request $request)
    {
        $request->validate([
            "no_request_product" => "required",
            "created_at" => "required",
            "file" => "file|max:5120",
        ]);

        $input = $request->all();

        if ($request->file('file')) {
            $fileName = $request->file('file')->getClientOriginalName();
            $input['file'] = $fileName;

            $request->file('file')->storeAs('post-pdf', $fileName);
        }
        ListProduct::create($input);

        return redirect()->route('admin.list-barang')->with('success', 'Data berhasil ditambah!');
    }

    public function update(Request $request)
    {
        $request->validate([
            "no_request_product" => "required",
            "created_at" => "required",
            "file" => "file|max:5120",
        ]);

        $input = $request->except('_token', 'submit');

        ListProduct::whereId($request->id)->update($input);

        return redirect()->route('admin.list-barang')->with('success', 'Data berhasil diupdate!');
    }

    public function hapus(Request $request)
    {
        $id = $request->input('id');

        $data = ListProduct::findOrFail($id);

        Storage::disk('public')->delete('post-pdf/' . $data['file']);
        $data->delete();

        return redirect()->route('admin.list-barang')->with('success', 'Data berhasil dihapus!');
    }

}
