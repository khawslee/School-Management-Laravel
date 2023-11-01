<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class ClassSubjectModel extends Model
{
    use HasFactory;

    protected $table = 'class_subject';

    static public function getRecords()
    {
        $return = ClassSubjectModel::select('class_subject.*', 'users.name as created_by_name')
                    ->join('users', 'users.id', '=', 'class_subject.created_by');

                    if(!empty(Request::get('name')))
                    {
                        $return = $return->where('class_subject.name', 'like', '%'.Request::get('name').'%');
                    }

                    if(!empty(Request::get('date')))
                    {
                        $return = $return->where('class_subject.created_at', '=', Request::get('date'));
                    }

                    $return = $return->where('class_subject.is_deleted', '=', '0')
                    ->orderBy('class_subject.id', 'desc')
                    ->paginate(10);

        return $return;
    }

    static public function getSingle($id)
    {
        return self::find($id);
    }
}
