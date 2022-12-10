<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Receive;
use App\Models\Supplier;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $role = auth()->user()->roles->pluck('name')->first();

        if ($role == 'admin' || $role == 'superadmin') {
            $data_stock = Product::sum('qty');
            $data_receive = Receive::sum('qty');
            $data_transaction = Transaction::sum('qty');
            $data_supplier = Supplier::count('id');

            return view('dashboard', [
                'title' => 'Admin Dashboard',
                'total_stock' => $data_stock,
                'total_receive' => $data_receive,
                'total_transaction' => $data_transaction,
                'total_supplier' => $data_supplier,
            ]);
        } else {
            return redirect()->route('list-barang.index');
        }
    }

    public function chart()
    {
        return Product::select('nama_produk', DB::raw('SUM(qty) as qty'))
                ->groupBy('nama_produk')
                ->get();
    }
}
