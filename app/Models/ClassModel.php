<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory;

    protected $table = 'class';

    static public function getRecords()
    {
        $return = ClassModel::select('class.*', 'users.name as create_by_name')
                    ->join('users', 'users.id', '=', 'class.create_by')
                    ->orderBy('class.id', 'desc')
                    ->paginate(10);

        return $return;
    }
}
