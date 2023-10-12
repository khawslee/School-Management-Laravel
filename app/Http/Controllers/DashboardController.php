<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function dashboard()
    {
        $data['header_title'] = 'Dashboard';

        switch(Auth::user()->user_type) {
            case 1:
                return view('admin.dashboard', $data);
            case 2:
                return view('teacher.dashboard', $data);
            case 3:
                return view('student.dashboard', $data);
            case 4:
                return view('parent.dashboard', $data);
        }
    }

}
