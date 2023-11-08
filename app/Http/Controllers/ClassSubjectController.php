<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ClassSubjectModel;
use App\Models\ClassModel;
use App\Models\SubjectModel;

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
        if(!empty($request->subject_id))
        {
            foreach($request->subject_id as $subject_id)
            {
                $getAlreadyAssign = ClassSubjectModel::getAlreadyAssign($request->class_id, $subject_id);

                if(!empty($getAlreadyAssign))
                {
                    $getAlreadyAssign->status = $request->status;
                    $getAlreadyAssign->save();
                }
                else
                {
                    $class = new ClassSubjectModel();
                    $class->class_id = $request->class_id;
                    $class->subject_id = $subject_id;
                    $class->status = $request->status;
                    $class->created_by = Auth::user()->id;
                    $class->save();
                }
            }

        }

        return redirect('admin/assign_subject/list')->with('success', 'Assign successfully.');
    }

    public function edit($id)
    {
        $getRecord = ClassSubjectModel::getSingle($id);
        if(!empty($getRecord))
        {
            $data['getRecord'] = $getRecord;
            $data['getAssignSubjectID'] = ClassSubjectModel::getAssignSubjectID($getRecord->class_id);
            $data['getClass'] = ClassModel::getClass();
            $data['getSubject'] = SubjectModel::getSubject();
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

    public function update(Request $request)
    {
        ClassSubjectModel::deleteSubject($request->class_id);

        if(!empty($request->subject_id))
        {
            foreach($request->subject_id as $subject_id)
            {
                $getAlreadyAssign = ClassSubjectModel::getAlreadyAssign($request->class_id, $subject_id);

                if(!empty($getAlreadyAssign))
                {
                    $getAlreadyAssign->status = $request->status;
                    $getAlreadyAssign->save();
                }
                else
                {
                    $class = new ClassSubjectModel();
                    $class->class_id = $request->class_id;
                    $class->subject_id = $subject_id;
                    $class->status = $request->status;
                    $class->created_by = Auth::user()->id;
                    $class->save();
                }
            }
        }
        return redirect('admin/assign_subject/list')->with('success', 'Subject update successfully.');
    }

    public function edit_single($id)
    {
        $getRecord = ClassSubjectModel::getSingle($id);
        if(!empty($getRecord))
        {
            $data['getRecord'] = $getRecord;
            $data['getClass'] = ClassModel::getClass();
            $data['getSubject'] = SubjectModel::getSubject();
            $data['header_title'] = 'Edit Subject';
            return view('admin.assign_subject.edit_single', $data);
        }
        else{
            abort(404);
        }
    }

    public function update_single($id, Request $request)
    {
        $getAlreadyAssign = ClassSubjectModel::getAlreadyAssign($request->class_id, $request->subject_id);

        if(!empty($getAlreadyAssign))
        {
            $getAlreadyAssign->status = $request->status;
            $getAlreadyAssign->save();
            return redirect('admin/assign_subject/list')->with('success', 'Status update successfully.');
        }
        else
        {
            $class = ClassSubjectModel::getSingle($id);
            $class->class_id = $request->class_id;
            $class->subject_id = $request->subject_id;
            $class->status = $request->status;
            $class->save();
            return redirect('admin/assign_subject/list')->with('success', 'Subject update successfully.');
        }

    }

}
