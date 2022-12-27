<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\ListProduct;
use Illuminate\Http\Request;
use App\Models\ReturnProduct;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\StockTransaction;
use Yajra\DataTables\Facades\DataTables;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class ReturnController extends Controller
{
    public function index(Request $request)
    {
        $role = auth()->user()->roles->pluck('name')->first();

        if ($request->ajax()) {
            $data = ReturnProduct::with('products', 'list_products')->get();

            if ($role == 'admin' || $role == 'superadmin' || $role == 'testing') {
                return DataTables::of($data)
                    ->addColumn('status', function ($data) {
                        $label = '<span id="label_status" class="btn btn-sm btn-' . $this->statusLabel($data) . ' disabled">' . ucwords($data['status']) . '</span>';
                        return is_null($data['status']) ? '-' : $label;
                    })
                    ->addColumn('action', function () {
                        $btn = '<button type="button" value="update" class="btn btn-sm btn-warning"><i class="fa fa-pen text-white"></i> Edit</button>
                        <button type="button" value="delete" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</button>';
                        return $btn;
                    })
                    ->rawColumns(['status', 'action'])
                    ->make(true);
            } else {
                return DataTables::of($data)
                    ->addColumn('status', function ($data) {
                        $add_btn = '<div id="add" class="d-flex justify-content-center">
                        <button type="button" id="add_status" value="add_status" class="btn btn-sm btn-primary"><i class="fa fa-plus text-white"></i></button>
                        </div>';

                        $edit_btn = '<div id="edit" class="d-flex justify-content-center">
                        <span id="label_status" class="btn btn-sm btn-'. $this->statusLabel($data) .' mx-1 disabled">' . ucwords($data['status']) . '</span>
                        <button type="button" id="edit_status" value="edit_status" class="btn btn-sm btn-warning mx-1"><i class="fa fa-pen text-white"></i></button>
                        </div>';
                        return is_null($data['status']) ? $add_btn : $edit_btn;
                    })
                    ->rawColumns(['status'])
                    ->make(true);
            }
        }

        return view('return.return', [
            'title' => 'Return',
            'products' => Product::all(),
            'list_products' => ListProduct::all(),
        ]);
    }

    private function statusLabel($data)
    {
        $btn_class = '';

        if ($data['status'] == 'on progress') {
            $btn_class = 'primary';
        } else if ($data['status'] == 'done resolved') {
            $btn_class = 'success';
        } else if ($data['status'] == 'rejected') {
            $btn_class = 'danger';
        }
        return $btn_class;
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'created_at' => 'required',
            'products_id' => 'required',
            'qty' => 'required',
            'list_products_id' => 'required',
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
        Product::where('id', $input['products_id'])->decrement('qty', $stock->qty);

        return redirect()->route('return.index')->with('success', 'Data berhasil ditambah!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'created_at' => 'required',
            'products_id' => 'required',
            'qty' => 'required',
            'list_products_id' => 'required',
        ]);

        $input = $request->except(['_token', 'submit']);

        ReturnProduct::whereId($request->id)->update($input);
        return redirect()->route('return.index')->with('success', 'Data berhasil diupdate!');
    }

    public function updateStatus(Request $request)
    {
        if ($request['status'] == 'on progress') {
            $stock = StockTransaction::where('invoice_number', $request['invoice_number'])->get()->first();
            Product::where('id', $request['product_id'])->decrement('qty', $stock->qty);
        } else if ($request['status'] == 'done resolved') {
            $stock = StockTransaction::where('invoice_number', $request['invoice_number'])->get()->first();
            Product::where('id', $request['product_id'])->increment('qty', $stock->qty);
        }

        return ReturnProduct::whereId($request['id'])->update(['status' => $request['status']]);
    }

    public function hapus(Request $request)
    {
        $id = $request->input('id');
        $product_id = $request->input('products_id');
        $invoice_number = $request->input('invoice_number');

        $data = ReturnProduct::findOrFail($id);

        $stock = StockTransaction::where('invoice_number', $invoice_number)->get()->first();
        Product::where('id', $product_id)->increment('qty', $stock->qty);

        StockTransaction::where('invoice_number', $invoice_number)->delete();

        $data->delete();

        return redirect()->route('return.index')->with('success', 'Data berhasil dihapus!');
    }

    public function cetakPdf(Request $request)
    {
        $startDate = Carbon::createFromFormat('Y-m-d H', $request['start_date'] . '0')->startOfDay()->toDateTimeString();
        $endDate = Carbon::createFromFormat('Y-m-d H', $request['end_date'] . '23')->endOfDay()->toDateTimeString();

        if (!$request['status']) {
            /* All Status */
            $result = ReturnProduct::whereBetween('created_at', [$startDate, $endDate])->get();
        } else {
            /* Selected Status */
            $result = ReturnProduct::select()->where([
                ['status', '=', $request['status']],
                ['created_at', '>=', $startDate],
                ['created_at', '<=', $endDate]
            ])->get();
        }

        $pdf = Pdf::loadView('return.return_pdf', [
            'returnProducts' => $result,
            'startDate' => Carbon::parse($startDate)->isoFormat('DD MMMM YYYY'),
            'endDate' => Carbon::parse($endDate)->isoFormat('DD MMMM YYYY'),
        ]);

        return $pdf->stream();
    }
}
