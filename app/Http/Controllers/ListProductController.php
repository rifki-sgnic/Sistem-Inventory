<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Receive;
use App\Models\ListProduct;
use Illuminate\Http\Request;
use App\Models\RequestProduct;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\StockTransaction;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class ListProductController extends Controller
{

    public function index(Request $request)
    {
        $role = auth()->user()->roles->pluck('name')->first();

        if ($request->ajax()) {
            $data = ListProduct::with('request_products')->get();

            switch ($role) {
                case 'admin':
                case 'superadmin':
                    return DataTables::of($data)
                        ->addColumn('no_pre_order', function ($data) {
                            return is_null($data['no_pre_order']) ? '-' : $data['no_pre_order'];
                        })
                        ->addColumn('status', function ($data) {
                            $label = '<span id="label_status" class="btn btn-sm btn-' . $this->statusLabel($data) . ' disabled">' . ucwords($data['status']) . '</span>';
                            return is_null($data['status']) ? '-' : $label;
                        })
                        ->addColumn('action', function () {
                            $btn = '<button type="button" value="update" class="btn btn-sm btn-warning"><i class="fa fa-pen text-white"></i> Edit</button>
                        <button type="button" value="delete" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</button>';
                            return $btn;
                        })
                        ->rawColumns(['no_pre_order', 'status', 'action'])
                        ->make(true);

                case 'warehouse':
                    return DataTables::of($data)
                        ->addColumn('no_pre_order', function ($data) {
                            return is_null($data['no_pre_order']) ? '-' : $data['no_pre_order'];
                        })
                        ->addColumn('status', function ($data) {
                            $add_btn = '<div id="add-status" class="d-flex justify-content-center">
                        <button type="button" id="add_status" value="add_status" class="btn btn-sm btn-primary"><i class="fa fa-plus text-white"></i></button>
                        </div>';

                            $edit_btn = '<div id="edit-status" class="d-flex justify-content-center">
                        <span id="label_status" class="btn btn-sm btn-' . $this->statusLabel($data) . ' mx-1 disabled">' . ucwords($data['status']) . '</span>
                        <button type="button" id="edit_status" value="edit_status" class="btn btn-sm btn-warning mx-1"><i class="fa fa-pen text-white"></i></button>
                        </div>';
                            return is_null($data['status']) ? $add_btn : $edit_btn;
                        })
                        ->rawColumns(['no_pre_order', 'status'])
                        ->make(true);

                case 'purchasing':
                    return DataTables::of($data)
                        ->addColumn('no_pre_order', function ($data) {
                            $edit_btn = '<div id="edit-po" class="d-flex justify-content-center align-items-center"><div id="no_po" class="flex-fill">' . ucwords($data['no_pre_order']) . '</div>
                        <button type="button" id="edit_no_po" value="edit_no_po" class="btn btn-sm btn-warning mx-1"><i class="fa fa-pen text-white"></i></button>
                        </div>';

                            return is_null($data['no_pre_order']) ? '-' : $edit_btn;
                        })
                        ->addColumn('status', function ($data) {
                            $label = '<span id="label_status" class="btn btn-sm btn-' . $this->statusLabel($data) . ' disabled">' . ucwords($data['status']) . '</span>';
                            return is_null($data['status']) ? '-' : $label;
                        })
                        ->rawColumns(['no_pre_order', 'status'])
                        ->make(true);
                case 'trm':
                    return DataTables::of($data)
                        ->addColumn('no_pre_order', function ($data) {
                            return is_null($data['no_pre_order']) ? '-' : $data['no_pre_order'];
                        })
                        ->addColumn('status', function ($data) {
                            $label = '<span id="label_status" class="btn btn-sm btn-' . $this->statusLabel($data) . ' disabled">' . ucwords($data['status']) . '</span>';
                            return is_null($data['status']) ? '-' : $label;
                        })
                        ->rawColumns(['no_pre_order', 'status'])
                        ->make(true);
            }
        }

        // $data = ListProduct::with('request_products', 'request_products.request_product_detail')->whereId(1)->get()->first();
        // dd($data);

        return view('list-barang.listbarang', [
            'title' => 'List Barang',
            'req_products' => RequestProduct::select()->where('status', '=', 'approved')->get(),
        ]);
    }

    private function statusLabel($data)
    {
        $btn_class = '';

        if ($data['status'] == 'receive') {
            $btn_class = 'success';
        } else if ($data['status'] == 'indend') {
            $btn_class = 'primary';
        }
        return $btn_class;
    }

    public function tambah(Request $request)
    {
        $request->validate([
            "request_products_id" => "required",
            "created_at" => "required",
            "file" => "file|max:5120",
        ]);

        $invoice = IdGenerator::generate(['table' => 'list_products', 'field' => 'invoice_number', 'length' => 8, 'prefix' => 'LB-']);

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
            "request_products_id" => "required",
            "created_at" => "required",
            "file" => "file|max:5120",
        ]);

        $input = $request->except('_token', 'submit');

        ListProduct::whereId($request->id)->update($input);

        if ($request['status'] == 'receive') {
            $data = ListProduct::with('request_products', 'request_products.request_product_detail')->whereId($request['id'])->get()->first();
            $invoice = IdGenerator::generate(['table' => 'receives', 'field' => 'invoice_number', 'length' => 8, 'prefix' => 'BM-']);
            $selectedProduct = collect($data->request_products->request_product_detail)->map(function ($value) use($invoice) {

                StockTransaction::create([
                    'invoice_number' => $invoice,
                    'products_id' => $value['products_id'],
                    'qty' => $value['qty'],
                ]);

                $stock = StockTransaction::where('invoice_number', $invoice)->get()->first();
                Product::where('id', $value['products_id'])->increment('qty', $stock->qty);

                return [
                    'invoice_number' => $invoice,
                    'products_id' => $value['products_id'],
                    'qty' => $value['qty'],
                    'created_at' => $value['created_at'],
                    'updated_at' => $value['updated_at']
                ];
            });

            Receive::insert($selectedProduct->toArray());
        }

        return redirect()->route('list-barang.index')->with('success', 'Data berhasil diupdate!');
    }

    public function updateStatus(Request $request)
    {
        if ($request['status'] == 'receive') {
            $data = ListProduct::with('request_products', 'request_products.request_product_detail')->whereId($request['id'])->get()->first();
            $invoice = IdGenerator::generate(['table' => 'receives', 'field' => 'invoice_number', 'length' => 8, 'prefix' => 'BM-']);
            $selectedProduct = collect($data->request_products->request_product_detail)->map(function ($value) use ($invoice) {

                StockTransaction::create([
                    'invoice_number' => $invoice,
                    'products_id' => $value['products_id'],
                    'qty' => $value['qty'],
                ]);

                $stock = StockTransaction::where('invoice_number', $invoice)->get()->first();
                Product::where('id', $value['products_id'])->increment('qty', $stock->qty);

                return [
                    'invoice_number' => $invoice,
                    'products_id' => $value['products_id'],
                    'qty' => $value['qty'],
                    'created_at' => $value['created_at'],
                    'updated_at' => $value['updated_at']
                ];
            });

            Receive::insert($selectedProduct->toArray());
        }

        return ListProduct::whereId($request['id'])->update(['status' => $request['status']]);
    }

    public function updateNoPo(Request $request)
    {
        return ListProduct::whereId($request['id'])->update(['no_pre_order' => $request['no_pre_order']]);
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

        if (!$request['status']) {
            /* All Status */
            $result = ListProduct::whereBetween('created_at', [$startDate, $endDate])->get();
        } else {
            /* Selected Status */
            $result = ListProduct::select()->where([
                ['status', '=', $request['status']],
                ['created_at', '>=', $startDate],
                ['created_at', '<=', $endDate]
            ])->get();
        }


        $pdf = Pdf::loadView('list-barang.listbarang_pdf', [
            'listProducts' => $result,
            'startDate' => Carbon::parse($startDate)->isoFormat('DD MMMM YYYY'),
            'endDate' => Carbon::parse($endDate)->isoFormat('DD MMMM YYYY'),
        ]);

        return $pdf->stream();
    }
}
