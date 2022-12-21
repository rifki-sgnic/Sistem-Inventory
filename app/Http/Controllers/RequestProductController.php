<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\RequestProduct;
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
}
