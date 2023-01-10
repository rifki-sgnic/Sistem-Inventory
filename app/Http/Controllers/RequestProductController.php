<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\RequestProduct;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\RequestProductDetail;
use Yajra\DataTables\Facades\DataTables;

class RequestProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = RequestProduct::get();

            return DataTables::of($data)->make(true);
        }

        return view('request-barang.request', [
            'title' => 'Request Barang'
        ]);
    }

    public function detail($id)
    {
        $detail = RequestProduct::with('request_product_detail', 'request_product_detail.products')->where('no_purchase_request', $id)->get()->first();

        return view('request-barang.detail', [
            'title' => 'Detail Request Barang',
            'detail' => $detail
        ]);
    }

    public function tambah()
    {
        return view('request-barang.tambah_request', [
            'title' => 'Tambah Request Barang',
            'products' => Product::all()
        ]);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $request_product = RequestProduct::create([
            "no_purchase_request" => $input['no_purchase_request'],
            "created_at" => $input['tanggal']
        ]);
        $request_product->request_product_detail()->createMany($input['list_barang']);

        return response()->json(['message' => 'Success']);
    }

    public function updateStatus(Request $request)
    {
        RequestProduct::where('no_purchase_request', $request['no_purchase_request'])->update(['status' => $request['status'], 'comment' => $request['comment']]);

        return redirect()->route('request-barang.index')->with('success', 'Status berhasil diupdate');
    }

    public function updateDetailProduct(Request $request)
    {
        $input = $request->all();
        $no_pr = $input['no_purchase_request'];

        RequestProductDetail::where('id', $input['id'])->update(['qty' => $input['qty'], 'harga' => $input['harga'], 'remarks' => $input['remarks']]);

        return redirect()->route('request-barang.detail', ['id' => $no_pr])->with('success', 'Produk berhasil diupdate');
    }

    public function deleteDetailProduct(Request $request)
    {
        $no_pr = $request['no_purchase_request'];
        $id = $request['id'];
        $data = RequestProductDetail::findOrFail($id);

        $data->delete();

        return redirect()->route('request-barang.detail', ['id' => $no_pr])->with('success', 'Produk berhasil dihapus');
    }

    public function addNoteDetailProduct(Request $request)
    {
        $input = $request->all();
        $no_pr = $request['no_purchase_request'];

        RequestProductDetail::where('id', $input['id'])->update(['note' => $input['note']]);

        return redirect()->route('request-barang.detail', ['id' => $no_pr])->with('success', 'Note berhasil ditambahkan');
    }

    public function cetakPdf(Request $request)
    {
        $startDate = Carbon::createFromFormat('Y-m-d H', $request['start_date'] . '0')->startOfDay()->toDateTimeString();
        $endDate = Carbon::createFromFormat('Y-m-d H', $request['end_date'] . '23')->endOfDay()->toDateTimeString();

        // if (!$request['status']) {
        //     /* All Status */
        //     $result = RequestProduct::whereBetween('created_at', [$startDate, $endDate])->get();
        // } else {
        //     /* Selected Status */
        // $result = RequestProduct::select()->where([
        //     ['status', '=', $request['status']],
        //     ['created_at', '>=', $startDate],
        //     ['created_at', '<=', $endDate]
        // ])->get();
        // }

        $result = RequestProduct::select()->where([
            ['status', '=', 'approved'],
            ['created_at', '>=', $startDate],
            ['created_at', '<=', $endDate]
        ])->get();


        $pdf = Pdf::loadView('request-barang.request_pdf', [
            'requests' => $result,
            'startDate' => Carbon::parse($startDate)->isoFormat('DD MMMM YYYY'),
            'endDate' => Carbon::parse($endDate)->isoFormat('DD MMMM YYYY'),
        ]);

        return $pdf->stream();

        // $result = RequestProduct::select()->where('status', '=', 'approved');
        // return view('request-barang.request_pdf', [
        //     'requests' => $result,
        // ]);
    }
}