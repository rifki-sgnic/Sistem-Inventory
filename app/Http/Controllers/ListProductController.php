<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\ListProduct;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class ListProductController extends Controller
{

    public function index(Request $request)
    {
        $role = auth()->user()->roles->pluck('name')->first();

        if ($request->ajax()) {
            $data = ListProduct::get();
            if ($role == 'admin' || $role =='superadmin') {
                return DataTables::of($data)
                ->addColumn('action', function ($data) {
                    $btn = '<button type="button" value="update" class="btn btn-sm btn-warning"><i class="fa fa-pen text-white"></i> Edit</button>
                    <button type="button" value="delete" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
            } else {
                return DataTables::of($data)
                ->removeColumn('action')
                ->make(true);
            }
        }

        return view('list-barang.listbarang', [
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

        $invoice = IdGenerator::generate(['table' => 'receives', 'field' => 'invoice_number', 'length' => 8, 'prefix' => 'LB-']);

        $input = $request->all();
        $input['invoice_number'] = $invoice;

        if ($request->file('file')) {
            $fileName = $request->file('file')->getClientOriginalName();
            $input['file'] = $fileName;

            $request->file('file')->storeAs('post-pdf', $fileName);
        }
        ListProduct::create($input);

        return redirect()->route('list-barang.index')->with('success', 'Data berhasil ditambah!');
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

        return redirect()->route('list-barang.index')->with('success', 'Data berhasil diupdate!');
    }

    public function updateStatus(Request $request)
    {
        return ListProduct::whereId($request['id'])->update(['status' => $request['status']]);
    }

    public function hapus(Request $request)
    {
        $id = $request->input('id');

        $data = ListProduct::findOrFail($id);

        Storage::disk('public')->delete('post-pdf/' . $data['file']);
        $data->delete();

        return redirect()->route('list-barang.index')->with('success', 'Data berhasil dihapus!');
    }

    public function cetakPdf(Request $request)
    {
        $startDate = Carbon::createFromFormat('Y-m-d H', $request['start_date'] . '0')->startOfDay()->toDateTimeString();
        $endDate = Carbon::createFromFormat('Y-m-d H', $request['end_date'] . '23')->endOfDay()->toDateTimeString();

        $result = ListProduct::select()->where([
            ['created_at', '>=', $startDate],
            ['created_at', '<=', $endDate]
        ])->get();

        $pdf = Pdf::loadView('list-barang.listbarang_pdf', [
            'listProducts' => $result,
            'startDate' => Carbon::parse($startDate)->isoFormat('DD MMMM YYYY'),
            'endDate' => Carbon::parse($endDate)->isoFormat('DD MMMM YYYY'),
        ]);

        return $pdf->stream();
    }
}
