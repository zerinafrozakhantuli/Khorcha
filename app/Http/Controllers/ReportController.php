<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\carbon;
use Session;
use Auth;
class ReportController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return redirect('dashboard');
        
    }

    public function summary(){
        return view('admin/report/summary');
    }

    public function current_month(){
        return view('admin/report/current-month');
    }
    public function search(Request $request){
        $this->validate($request,[
            'starting'=>'required',
            'ending'=>'required',
        ],[
          'starting.required'=>'Please Select Starting Date',
          'ending.required'=>'Please Select Ending Date',
        ]);
         
      return view('admin/report/search') ;
    }
}
