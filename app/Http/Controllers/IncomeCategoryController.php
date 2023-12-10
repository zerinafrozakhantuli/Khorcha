<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\IncomeCategory;
use Carbon\carbon;
use Session;
use Auth;

class IncomeCategoryController extends Controller
{
     
     public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $allData=IncomeCategory::where('incate_status',1)->orderBy('incate_id','DESC')->get();
      return view('admin/income/category/all',compact('allData'));
    }

     public function add(){
      return view('admin/income/category/add');
    }

     public function edit($slug){
      $data=IncomeCategory::where('incate_status',1)->where('incate_slug',$slug)->firstorfail();
      return view('admin/income/category/edit',compact('data'));
    }

     public function view($slug){
        $data=IncomeCategory::where('incate_status',1)->where('incate_slug',$slug)->firstorfail();
      return view('admin/income/category/view',compact('data'));
    }

     public function insert(Request $request){
        $this->validate($request,[
          'name'=>'required|max:50|unique:income_categories,incate_name',
        ],[
          
          'name.required'=>'Please Enter Income Category Name.'
        ]);

        $slug=Str::slug($request['name'],'-');
        $creator=Auth::user()->id;

      $insert=IncomeCategory::insert([
        'incate_name'=>$request['name'],
        'incate_remarks'=>$request['remarks'],
        'incate_creator'=>$creator,
        'incate_slug'=>$slug,
        'created_at'=>Carbon::now()->toDateTimeString(),
      ]);
     
     if($insert){
        Session::flash('success','Successfully add income category information.');
        return redirect('dashboard/income/category/add');
     }else{
        Session::flash('error','Opps! Operation failed.');
       return redirect('dashboard/income/category/add');
     }


    }

     public function update(Request $request){
         $id=$request['id'];
      $this->validate($request,[
          'name'=>'required|max:50|unique:income_categories,incate_name,'.$id.',incate_id',
        ],[
          
          'name.required'=>'Please Enter Income Category Name.'
        ]);
         

       
        $slug=Str::slug($request['name'],'-');
        $editor=Auth::user()->id;

      $update=IncomeCategory::where('incate_status',1)->where('incate_id',$id)->update([
        'incate_name'=>$request['name'],
        'incate_remarks'=>$request['remarks'],
        'incate_editor'=>$editor,
        'incate_slug'=>$slug,
        'updated_at'=>Carbon::now()->toDateTimeString(),
      ]);
     
     if($update){
        Session::flash('success','Successfully Update income category information.');
        return redirect('dashboard/income/category/view/'.$slug);
     }else{
        Session::flash('error','Opps! Operation failed.');
       return redirect('dashboard/income/category/edit/'.$slug);
     }

    }

     public function softdelete(){
        $id=$_POST['modal_id'];
      $soft=IncomeCategory::where('incate_status',1)->where('incate_id',$id)->update([
        'incate_status'=>0,
        'updated_at'=>Carbon::now()->toDateTimeString(),
      ]);
      if($soft){
        Session::flash('success','Successfully Delete Income Category.');
        return redirect('dashboard/income/category');
      }else{
        Session::flash('error','Opps!Operation Failed');
        return redirect('dashboard/income/category');
      }
    }

     public function restore(){
     
     $id=$_POST['modal_id'];
      $restore=IncomeCategory::where('incate_status',0)->where('incate_id',$id)->update([
        'incate_status'=>1,
        'updated_at'=>Carbon::now()->toDateTimeString(),
      ]);
      if($restore){
        Session::flash('success','Successfully Restore Income Category.');
        return redirect('dashboard/recycle/income/category');
      }else{
        Session::flash('error','Opps!Operation Failed');
        return redirect('dashboard/recycle/income/category');
      }
    }

     public function delete(){
      
      $id=$_POST['modal_id'];
      $delete=IncomeCategory::where('incate_status',0)->where('incate_id',$id)->delete();
      if($delete){
        Session::flash('success','Successfully Permanently Delete Income Category.');
        return redirect('dashboard/recycle/income/category');
      }else{
        Session::flash('error','Operation Failed');
        return redirect('dashboard/recycle/income/category');
      }
    }
}
