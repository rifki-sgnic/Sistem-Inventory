<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(Request $request) {

        if ($request->ajax()) {
            $data = User::with('roles')->get();
            return DataTables::of($data)->make(true);
        }

        return view('admin.usermanagement', [
            'title' => 'User Management',
            'roles' => Role::all()->pluck('name'),
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

        User::create($input)->assignRole($input['role']);

        return redirect()->route('admin.user-management')->with('success', 'User berhasil ditambah!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'role' => 'required',
        ]);

        $input = $request->except(['_token', 'submit']);
        $user = User::find($request->id);

        if ($input['password'] != null) {
            $input['password'] = bcrypt($request->password);

            $user->update($input);
        } else {
            $user->update(['name' => $input['name'], 'username' => $input['username'], 'role' => $input['role']]);
        }


        DB::table('model_has_roles')->where('model_id', $input['id'])->delete();
        $user->assignRole($input['role']);

        return redirect()->route('admin.user-management')->with('success', 'User berhasil diubah!');
    }

    public function hapus(Request $request)
    {
        $id = $request->input('id');

        $data = User::findOrFail($id);

        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $data->delete();

        return redirect()->route('admin.user-management')->with('success', 'User berhasil dihapus!');
    }
}
