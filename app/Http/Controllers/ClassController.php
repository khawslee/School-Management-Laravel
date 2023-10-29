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
        $user->created_by = Auth::user()->id;
        $user->save();

        return redirect('admin/class/list')->with('success', 'Class added successfully.');
    }

    public function edit($id)
    {
        $data['getRecords'] = ClassModel::getSingle($id);
        if(!empty($data['getRecords'])) {
            $data['header_title'] = 'Edit Class';
            return view('admin.class.edit', $data);
        }
        else{
            abort(404);
        }
    }

    public function delete($id)
    {
        $user = ClassModel::getSingle($id);
        $user->is_deleted = 1;
        $user->save();

        return redirect('admin/class/list')->with('success', 'Class deleted successfully.');
    }

    public function update($id, Request $request)
    {
        $class = ClassModel::getSingle($id);
        $class->name = trim($request->name);
        $class->status = $request->status;

        $class->save();

        return redirect('admin/class/list')->with('success', 'Class update successfully.');
    }

}
