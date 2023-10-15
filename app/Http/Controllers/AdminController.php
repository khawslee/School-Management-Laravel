<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminController extends Controller
{
    public function list()
    {
        $data['getRecords'] = User::getAdmin();
        $data['header_title'] = 'Admin List';
        return view('admin.admin.list', $data);
    }

    public function add()
    {
        $data['header_title'] = 'Add New Admin';
        return view('admin.admin.add', $data);
    }

    public function insert(Request $request)
    {
        // $data['header_title'] = 'Add New Admin';
        // return view('admin.admin.add', $data);
        //dd($request->all());
        $request->validate([
            'email' => 'required|email|unique:users',
        ]);

        $user= new User();
        $user->name = trim($request->name);
        $user->email = trim($request->email);
        $user->password = Hash::make($request->password);
        $user->user_type = 1;
        $user->is_delete = 0;
        $user->save();

        return redirect('admin/admin/list')->with('success', 'Admin added successfully.');
    }

    public function edit($id)
    {
        $data['getRecord'] = User::getSingle($id);
        if(!empty($data['getRecord'])) {
            $data['header_title'] = 'Edit Admin';
            return view('admin.admin.edit', $data);
        }
        else{
            abort(404);
        }
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,'.$id,
        ]);

        $user = User::getSingle($id);
        $user->name = trim($request->name);
        $user->email = trim($request->email);

        if(!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect('admin/admin/list')->with('success', 'Admin update successfully.');
    }

    public function delete($id)
    {
        $user = User::getSingle($id);
        $user->is_delete = 1;
        $user->save();

        return redirect('admin/admin/list')->with('success', 'Admin deleted successfully.');
    }

}
