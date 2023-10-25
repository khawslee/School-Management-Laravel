<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ClassModel;

class ClassController extends Controller
{
    public function list()
    {
        $data['getRecords'] = ClassModel::getRecords();
        $data['header_title'] = 'Class List';
        return view('admin.class.list', $data);
    }

    public function add()
    {
        $data['header_title'] = 'Add New Class';
        return view('admin.class.add', $data);
    }

    public function insert(Request $request)
    {
        $user= new ClassModel();
        $user->name = trim($request->name);
        $user->status = trim($request->status);
        $user->create_by = Auth::user()->id;
        $user->save();

        return redirect('admin/class/list')->with('success', 'Class added successfully.');
    }

}
