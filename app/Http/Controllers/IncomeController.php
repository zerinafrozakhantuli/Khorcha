<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Exports\IncomeExport;
use App\Models\Income;
use Carbon\Carbon;
use Session;
use Auth;
use PDF;
use Excel;

class IncomeController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index(){
     $all=Income::where('income_status',1)->orderBy('income_date','DESC')->get();
     return view ('admin/income/main/all',compact('all'));
    }

     public function add(){
    return view('admin/income/main/add');
    }

     public function edit($slug){
        $data=Income::where('income_status',1)->where('income_slug',$slug)->firstorfail();
        return view('admin/income/main/edit',compact('data'));

    }

     public function view($slug){
      $data=Income::where('income_status',1)->where('income_slug',$slug)->firstorfail();
      return view('admin/income/main/view',compact('data'));
    }

     public function insert(Request $request){
      $this->validate($request,[
       
       'title'=>'required|max:50',
       'category'=>'required',
       'date'=>'required',
       'amount'=>'required',

      ],[
       'title.required'=>'Please Enter Income Title.',
       'category.required'=>'Please Select Income Category.',
       'date.required'=>'Please Select Income Date.',
       'amount.required'=>'Please Enter Amount.',
      ]);

      $slug='I'.uniqid(20);
      $creator=Auth::user()->id;

      $insert=Income::insert([
        'income_title'=>$request['title'],
        'incate_id'=>$request['category'],
        'income_date'=>$request['date'],
        'income_amount'=>$request['amount'],
        'income_creator'=>$creator,
        'income_slug'=>$slug,
        'created_at'=>Carbon::now()->toDateTimeString(),

      ]);

      if($insert){
        Session::flash('success','Successfully Add Income Information.');
        return redirect('dashboard/income/add');
      }else{
        Session::flash('error','Operation Failed.');
        return redirect('dashboard/income/add');
      }
    }

     public function update (Request $request){
      
      $this->validate($request,[
       
       'title'=>'required|max:50',
       'category'=>'required',
       'date'=>'required',
       'amount'=>'required',

      ],[
       'title.required'=>'Please Enter Income Title.',
       'category.required'=>'Please Select Income Category.',
       'date.required'=>'Please Select Income Date.',
       'amount.required'=>'Please Enter Amount.',
      ]);
      
      $id=$request['id'];
      $slug=$request['slug'];
      $editor=Auth::user()->id;

      $update=Income::where('income_status',1)->where('income_id',$id)->update([
        'income_title'=>$request['title'],
        'incate_id'=>$request['category'],
        'income_date'=>$request['date'],
        'income_amount'=>$request['amount'],
        'income_editor'=>$editor,
        'income_slug'=>$slug,
        'updated_at'=>Carbon::now()->toDateTimeString(),

      ]);

      if($update){
        Session::flash('success','Successfully Update Income Information.');
        return redirect('dashboard/income/view/'.$slug);
      }else{
        Session::flash('error','Operation Failed.');
        return redirect('dashboard/income/edit/'.$slug);
      }
    }

     public function softdelete(){
     
     $id=$_POST['modal_id'];
      $soft=Income::where('income_status',1)->where('income_id',$id)->update([
        'income_status'=>0,
        'updated_at'=>Carbon::now()->toDateTimeString(),
      ]);
      if($soft){
        Session::flash('success','Successfully Delete Income .');
        return redirect('dashboard/income');
      }else{
        Session::flash('error','Opps!Operation Failed');
        return redirect('dashboard/income');
      }

    }

     public function restore(){
      
      $id=$_POST['modal_id'];
      $restore=Income::where('income_status',0)->where('income_id',$id)->update([
        'income_status'=>1,
        'updated_at'=>Carbon::now()->toDateTimeString(),
      ]);
      if($restore){
        Session::flash('success','Successfully Restore Income Category.');
        return redirect('dashboard/recycle/income');
      }else{
        Session::flash('error','Opps!Operation Failed');
        return redirect('dashboard/recycle/income');
      }
    }

     public function delete(){
     
     $id=$_POST['modal_id'];
      $delete=Income::where('income_status',0)->where('income_id',$id)->delete();
      if($delete){
        Session::flash('success','Successfully Permanently Delete Income Category.');
        return redirect('dashboard/recycle/income');
      }else{
        Session::flash('error','Operation Failed');
        return redirect('dashboard/recycle/income');
      }
    
    }

    public function pdf(){
    $all=Income::where('income_status',1)->orderBy('income_date','DESC')->get();
     $pdf = PDF::loadView('admin/income/main/pdf', compact('all'));
        return $pdf->download('income_'.time().'.pdf');
    }

    public function excel(){
       return Excel::download(new IncomeExport, 'Income_.xlsx');
    }
}
