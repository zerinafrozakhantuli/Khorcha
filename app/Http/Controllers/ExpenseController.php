<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Expense;
use Carbon\carbon;
use Session;
use Auth;

class ExpenseController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index(){
        $all=Expense::where('expense_status',1)->orderBy('expense_date','DESC')->get();
        return view('admin/expense/main/all',compact('all'));
    }

     public function add(){
     return view('admin/expense/main/add');
    }

     public function edit($slug){
        $data=Expense::where('expense_status',1)->where('expense_slug',$slug)->firstorfail();
      return view('admin/expense/main/edit',compact('data'));
    }

     public function view($slug){
        $data=Expense::where('expense_status',1)->where('expense_slug',$slug)->firstorfail();
        return view('admin/expense/main/view',compact('data'));

    }

     public function insert(Request $request){
        $this->validate($request,[
         'title'=>'required|max:100',
         'category'=>'required',
         'date'=>'required',
         'amount'=>'required',
        ],[

        'title.required'=>'Please Enter Expense Title',
        'category.required'=>'Please Select Expense Category',
        'date.required'=>'Please Select date',
        'amount.required'=>'Please Enter Amount',

        ]); 

        $slug='E'.uniqid(20);
        $creator=Auth::user()->id;


      $insert=Expense::insert([
        'expense_title'=>$request['title'],
        'expcate_id'=>$request['category'],
        'expense_date'=>$request['date'],
        'expense_amount'=>$request['amount'],
        'expense_creator'=>$creator,
        'expense_slug'=>$slug,
        'created_at'=>Carbon::now()->toDateTimeString(),

      ]);

      if($insert){
        Session::flash('success','Successfully Add Expense Information.');
        return redirect('dashboard/expense/add');
      }else{
        Session::flash('error','Operation Failed.');
        return redirect('dashboard/expense/add');
         }   
      }

      public function update(Request $request){
      
      $this->validate($request,[
       
       'title'=>'required|max:50',
       'category'=>'required',
       'date'=>'required',
       'amount'=>'required',

      ],[
       'title.required'=>'Please Enter Expense Title.',
       'category.required'=>'Please Select Expense Category.',
       'date.required'=>'Please Select Expense Date.',
       'amount.required'=>'Please Enter Amount.',
      ]);
      
      $id=$request['id'];
      $slug=$request['slug'];
      $editor=Auth::user()->id;

      $update=Expense::where('expense_status',1)->where('expense_id',$id)->update([
        'expense_title'=>$request['title'],
        'expcate_id'=>$request['category'],
        'expense_date'=>$request['date'],
        'expense_amount'=>$request['amount'],
        'expense_editor'=>$editor,
        'expense_slug'=>$slug,
        'updated_at'=>Carbon::now()->toDateTimeString(),

      ]);

      if($update){
        Session::flash('success','Successfully Update Expense  Information.');
        return redirect('dashboard/expense/view/'.$slug);
      }else{
        Session::flash('error','Operation Failed.');
        return redirect('dashboard/expense/edit/'.$slug);
      }
    }


     public function softdelete(){
     
     $id=$_POST['modal_id'];
      $soft=Expense::where('expense_status',1)->where('expense_id',$id)->update([
        'expense_status'=>0,
        'updated_at'=>Carbon::now()->toDateTimeString(),
      ]);
      if($soft){
        Session::flash('success','Successfully Delete Expense .');
        return redirect('dashboard/expense');
      }else{
        Session::flash('error','Opps!Operation Failed');
        return redirect('dashboard/expense');
      }

    }

     public function restore(){
      
      $id=$_POST['modal_id'];
      $restore=Expense::where('expense_status',0)->where('expense_id',$id)->update([
        'expense_status'=>1,
        'updated_at'=>Carbon::now()->toDateTimeString(),
      ]);
      if($restore){
        Session::flash('success','Successfully Restore Expense Category.');
        return redirect('dashboard/recycle/expense');
      }else{
        Session::flash('error','Opps!Operation Failed');
        return redirect('dashboard/recycle/expense');
      }
    }

     public function delete(){
     
     $id=$_POST['modal_id'];
      $delete=Expense::where('expense_status',0)->where('expense_id',$id)->delete();
      if($delete){
        Session::flash('success','Successfully Permanently Delete Expense Category.');
        return redirect('dashboard/recycle/expense');
      }else{
        Session::flash('error','Operation Failed');
        return redirect('dashboard/recycle/expense');
      }
    
    }


      }

