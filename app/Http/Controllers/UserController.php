<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\carbon;
use Session;
use Image;
use Auth;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('superadmin');
    }

    public function index(){
        $allU=User::where('status',1)->orderBy('id','DESC')->get();
       return view('admin/user/all',compact('allU'));
    }

     public function add(){
      return view('admin/user/add');
    }

     public function edit($slug){
        $all=User::where('status',1)->where('slug',$slug)->firstorfail();
      return view('admin/user/edit',compact('all'));
    }

     public function view($slug){
        $all=User::where('status',1)->where('slug',$slug)->firstorfail();
      return view('admin/user/view',compact('all'));
    }

     public function insert(Request $request){
        $this->validate($request,[
     
     'name'=>'required|max:50',
     'email'=>'required|email|max:50|unique:users',
     'password'=>'required',
     'confirm_password'=>'required_with:password|same:password|min:6',
     'username'=>'required',
     'role'=>'required',  

     ],[
    
    'name.required'=>'Please Enter Your Name.',
    'email.required'=>'Please Enter Email.',
    'password.required'=>'Please Enter password.',
    'confirm_password.required'=>'Please Enter confirm_password.',
    'username.required'=>'Please Enter Username.',
    'role.required'=>'Please Select Role.',

     ]);
        $slug='U'.uniqid(20);

        $insert=User::insertGetId([
       'name'=>$request['name'],
       'phone'=>$request['phone'],
       'email'=>$request['email'],
       'username'=>$request['username'],
       'password'=>Hash::make($request['password']),
       'role'=>$request['role'],
       'slug'=>$slug,
       'created_at'=>Carbon::now()->toDateTimeString(),
        ]);

        if($request->hasfile('photo')){
            $image=$request->file('photo');
            $imageName='user_'.$insert.'_'.time().'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(250,250)->save(base_path('public/uploads/users/'.$imageName));

            User::where('id',$insert)->update([
              'photo'=>$imageName,
              'updated_at'=>Carbon::now()->toDateTimeString(),
            ]);
        }

        if($insert){
            Session::flash('success','Successfully Add User Registration.');
            return redirect('dashboard/user/add');
        }else{
            Session::flash('error','Operation Failed.');
            return redirect('dashboard/user/add');
        }

    }

     public function update(Request $request){
        $id=$request['id'];

        $this->validate($request,[

          'name'=>'required|max:50',
          'email'=>'required|email|max:50|unique:users,email,'.$id.',id',
          'role'=>'required',
        ],[
         
          'name.required'=>'Please Enter Name.',
          'email.required'=>'Please Enter Email.',
          'role.required'=>'Please Select Role.',

        ]);

        $slug=$request['slug'];

        $update=User::where('status',1)->where('id',$id)->update([
        'name'=>$request['name'],
        'phone'=>$request['phone'],
        'email'=>$request['email'],
        'role'=>$request['role'],
        
        'updated_at'=>Carbon::now()->toDateTimeString(),
        ]);

        if($request->hasfile('photo')){
            $image=$request->file('photo');
            $imageName='user_'.$id.'_'.time().'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(250,250)->save(base_path('public/uploads/users/'.$imageName));

            User::where('id',$id)->update([
                'photo'=>$imageName,
                'updated_at'=>Carbon::now()->toDateTimeString(),
            ]);
        }

        if($update){
            Session::flash('success','Successfully Update User Information');
            return redirect('dashboard/user/view/'.$slug);
        }else{
            Session::flash('error','Opps Operation Failed');
            return redirect('dashboard/user/edit/'.$slug);
        }

    }

     public function softdelete(){
       
       $id=$_POST['modal_id'];
      $soft=User::where('status',1)->where('id',$id)->update([
        'status'=>0,
        'updated_at'=>Carbon::now()->toDateTimeString(),
      ]);
      if($soft){
        Session::flash('success','Successfully Delete user .');
        return redirect('dashboard/user');
      }else{
        Session::flash('error','Opps!Operation Failed');
        return redirect('dashboard/user');
      }
    }

     public function restore(){
     
      $id=$_POST['modal_id'];
      $restore=User::where('status',0)->where('id',$id)->update([
        'status'=>1,
        'updated_at'=>Carbon::now()->toDateTimeString(),
      ]);
      if($restore){
        Session::flash('success','Successfully Restore User Information.');
        return redirect('dashboard/recycle/User');
      }else{
        Session::flash('error','Opps!Operation Failed');
        return redirect('dashboard/recycle/user');
      }
    }

     public function delete(){
     
      $id=$_POST['modal_id'];
      $delete=User::where('status',0)->where('id',$id)->delete();
      if($delete){
        Session::flash('success','Successfully Permanently Delete User.');
        return redirect('dashboard/recycle/user');
      }else{
        Session::flash('error','Operation Failed');
        return redirect('dashboard/recycle/user');
      }
    }

}
