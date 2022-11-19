<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(Request $request) {

        if ($request->ajax()) {
            $data = User::get();
            return DataTables::of($data)->make(true);
        }

        return view('admin.usermanagement', [
            'title' => 'User Management',
            'roles' => Role::all(),
        ]);
    }

    public function tambah(Request $request) {
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'password' => 'required',
            'role' => 'required',
        ]);

        $input = $request->all();
        $input['password'] = bcrypt($request->password);

        User::create($input);

        return redirect()->route('admin.user-management')->with('success', 'User berhasil ditambah!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'password' => 'required',
            'role' => 'required',
        ]);

        $input = $request->except(['_token', 'submit']);
        $input['password'] = bcrypt($request->password);

        User::whereId($request->id)->update($input);
        return redirect()->route('admin.user-management')->with('success', 'User berhasil diubah!');
    }

    public function hapus(Request $request)
    {
        $id = $request->input('id');

        $data = User::findOrFail($id);

        $data->delete();

        return redirect()->route('admin.user-management')->with('success', 'User berhasil dihapus!');
    }
}
