<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Basic;
use App\Models\SocialMedia;
use App\Models\ContactInformation;
use Carbon\carbon;
use Session;
use Image;
use Auth;

class ManageController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return redirect('dashboard');
    }

    public function basic(){
        $Basic=Basic::where('basic_status',1)->where('basic_id',1)->firstorfail();
        return view('admin/manage/basic',compact('Basic'));

    }
    
     public function basic_update(Request $request){
        $this->validate($request,[
          'company'=>'required|max:100',
        ],[
        'company.required'=>'Please Enter Company Name.',
         ]);
        
        $editor=Auth::user()->id;

        $Bupdate=Basic::where('basic_id',1)->update([
         
         'basic_company'=>$request['company'],
         'basic_title'=>$request['title'],
         'basic_editor'=>$editor,
         'updated_at'=>Carbon::now()->toDateTimeString(),
        ]);

         if($request->hasfile('logo')){
            $logo=$request->file('logo');
            $logoName='logo_'.time().'.'.$logo->getClientOriginalExtension();
            Image::make($logo)->resize(250,250)->save(base_path('public/uploads/basic/'.$logoName));

            Basic::where('basic_id',1)->update([
              'basic_logo'=>$logoName,
              'updated_at'=>Carbon::now()->toDateTimeString(),
            ]);
        }

        if($request->hasfile('faviconfavicon')){
            $favicon=$request->file('faviconfavicon');
            $faviconName='favicon_'.time().'.'.$favicon->getClientOriginalExtension();
            Image::make($favicon)->resize(250,250)->save(base_path('public/uploads/basic/'.$faviconName));

            Basic::where('basic_id',1)->update([
              'basic_favicon'=>$faviconName,
              'updated_at'=>Carbon::now()->toDateTimeString(),
            ]);
        }

        if($request->hasfile('flogo')){
            $flogo=$request->file('flogo');
            $flogoName='logo_'.time().'.'.$flogo->getClientOriginalExtension();
            Image::make($flogo)->resize(250,250)->save(base_path('public/uploads/basic/'.$flogoName));

            Basic::where('basic_id',1)->update([
              'basic_flogo'=>$flogoName,
              'updated_at'=>Carbon::now()->toDateTimeString(),
            ]);
        }

        if($Bupdate){
            Session::flash('success','Successfully Update Basic Information');
            return redirect('dashboard/manage/basic');
        }else{
            Session::flash('error','Operation Failed');
            return redirect('dashboard/manage/basic');
        }
    }




    public function social(){
        $social=SocialMedia::where('sm_status',1)->where('sm_id',1)->firstorfail();
        return view('admin/manage/social',compact('social'));
    }



     public function social_update(Request $request){
        $this->validate($request,[

        ],[

        ]);

        $editor=Auth::user()->id;

        $Supdate=SocialMedia::where('sm_id',1)->update([
        'sm_facebook'=>$request['facebook'],
        'sm_twitter'=>$request['twitter'],
        'sm_linkedin'=>$request['linkedin'],
        'sm_pinterest'=>$request['pinterest'],
        'sm_behance'=>$request['behance'],
        'sm_instagram'=>$request['instagram'],
        'sm_youtube'=>$request['youtube'],
        'sm_whatsapp'=>$request['whatsapp'],
        'sm_telegram'=>$request['telegram'],
        'sm_github'=>$request['github'],
        'sm_editor'=>$editor,
        'updated_at'=>Carbon::now()->toDateTimeString(),

        ]);
        if($Supdate){
            Session::flash('success','Successfully Update Social Media Information');
            return redirect('dashboard/manage/social');
        }else{
            Session::flash('error','Operation Failed');
            return redirect('dashboard/manage/social');
        }
        
    }

    public function contact(){
        $Contact=ContactInformation::where('ci_status',1)->where('ci_id',1)->firstorfail();
        return view('admin/manage/contact',compact('Contact'));
    }

    public function contact_update(Request $request){
        $this->validate($request,[

        ],[


        ]);

        $editor=Auth::user()->id;

        $Cupdate=ContactInformation::where('ci_id',1)->update([

        'ci_phone1'=>$request['phone1'],
        'ci_phone2'=>$request['phone2'],
        'ci_phone3'=>$request['phone3'],
        'ci_phone4'=>$request['phone4'],
        'ci_email1'=>$request['email1'],
        'ci_email2'=>$request['email2'],
        'ci_email3'=>$request['email3'],
        'ci_email4'=>$request['email4'],
        'ci_address1'=>$request['address1'],
        'ci_address2'=>$request['address2'],
        'ci_address3'=>$request['address3'],
        'ci_address4'=>$request['address4'],
        'ci_editor'=>$editor,
        'updated_at'=>Carbon::now()->toDateTimeString(),

        ]);

        if($Cupdate){
            Session::flash('success','Successfully Update Contact Information');
            return redirect('dashboard/manage/contact');
        }else{
            Session::flash('error','Operation Failed');
            return redirect('dashboard/manage/contact');
        }

        
    }
}