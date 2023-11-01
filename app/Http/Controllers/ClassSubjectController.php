<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ClassSubjectModel;
use App\Models\ClassModel;
use App\Models\SubjectModel;
use PhpParser\Builder\Class_;

class ClassSubjectController extends Controller
{
    public function list()
    {
        $data['getRecords'] = ClassSubjectModel::getRecords();
        $data['header_title'] = 'Subject Assign List';
        return view('admin.assign_subject.list', $data);
    }

    public function add(Request $request)
    {
        $data['getClass'] = ClassModel::getClass();
        $data['getSubject'] = SubjectModel::getSubject();
        $data['header_title'] = 'Assign New Subject';
        return view('admin.assign_subject.add', $data);
    }

    public function insert(Request $request)
    {
        $user= new ClassSubjectModel();
        $user->name = trim($request->name);
        $user->status = trim($request->status);
        $user->created_by = Auth::user()->id;
        $user->save();

        return redirect('admin/assign_subject/list')->with('success', 'Assign successfully.');
    }

    public function edit($id)
    {
        $data['getRecords'] = ClassSubjectModel::getSingle($id);
        if(!empty($data['getRecords'])) {
            $data['header_title'] = 'Edit Subject';
            return view('admin.assign_subject.edit', $data);
        }
        else{
            abort(404);
        }
    }

    public function delete($id)
    {
        $user = ClassSubjectModel::getSingle($id);
        $user->is_deleted = 1;
        $user->save();

        return redirect('admin/assign_subject/list')->with('success', 'Subject deleted successfully.');
    }

    public function update($id, Request $request)
    {
        $class = ClassSubjectModel::getSingle($id);
        $class->name = trim($request->name);
        $class->status = $request->status;

        $class->save();

        return redirect('admin/assign_subject/list')->with('success', 'Subject update successfully.');
    }
}
