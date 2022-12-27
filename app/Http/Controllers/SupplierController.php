<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\Facades\DataTables;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $role = auth()->user()->roles->pluck('name')->first();

        if ($request->ajax()) {
            $data = Supplier::get();
            if ($role == 'superadmin' || $role == 'purchasing' || $role == 'testing') {
                return DataTables::of($data)
                    ->addColumn('action', function () {
                        $btn = '<button type="button" value="update" class="btn btn-sm btn-warning"><i class="fa fa-pen text-white"></i> Edit</button>
                            <button type="button" value="delete" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</button>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            } else {
                return DataTables::of($data)->make(true);
            }
        }

        return view('supplier.supplier', [
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

        return redirect()->route('supplier.index')->with('success', 'Data berhasil ditambah!');
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

        return redirect()->route('supplier.index')->with('success', 'Data berhasil diupdate!');
    }

    public function hapus(Request $request)
    {
        $id = $request->id;

        $data = Supplier::findOrFail($id);

        $data->delete();

        return redirect()->route('supplier.index')->with('success', 'Data berhasil dihapus!');
    }

    public function cetakPdf()
    {
        $suppliers = Supplier::all();

        $pdf = Pdf::loadView('supplier.supplier_pdf', ['suppliers' => $suppliers]);
        return $pdf->stream();

        // return view('supplier.supplier_pdf', [
        //     'suppliers' => Supplier::all(),
        // ]);
    }
}
