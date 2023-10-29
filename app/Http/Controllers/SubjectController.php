<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SubjectModel;

class SubjectController extends Controller
{
    public function list()
    {
        $data['getRecords'] = SubjectModel::getRecords();
        $data['header_title'] = 'Subject List';
        return view('admin.subject.list', $data);
    }

    public function add()
    {

        $data['header_title'] = 'Add New Subject';
        return view('admin.subject.add', $data);
    }
    public function insert(Request $request)
    {
        $user= new SubjectModel();
        $user->name = trim($request->name);
        $user->status = trim($request->status);
        $user->created_by = Auth::user()->id;
        $user->save();

        return redirect('admin/subject/list')->with('success', 'Subject added successfully.');
    }

    public function edit($id)
    {
        $data['getRecords'] = SubjectModel::getSingle($id);
        if(!empty($data['getRecords'])) {
            $data['header_title'] = 'Edit Subject';
            return view('admin.subject.edit', $data);
        }
        else{
            abort(404);
        }
    }

    public function delete($id)
    {
        $user = SubjectModel::getSingle($id);
        $user->is_deleted = 1;
        $user->save();

        return redirect('admin/subject/list')->with('success', 'Subject deleted successfully.');
    }

    public function update($id, Request $request)
    {
        $class = SubjectModel::getSingle($id);
        $class->name = trim($request->name);
        $class->status = $request->status;
        $class->type = $request->type;

        $class->save();

        return redirect('admin/subject/list')->with('success', 'Subject update successfully.');
    }

}
