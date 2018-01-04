<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\User;
use App\Registration;
use App\Cities;
use App\Jobs;
use App\Employers;
use App\Skills;
use App\Skill_Job;
use App\Skill_Employer;
use App\Applications;
use App\Register_Employer;
use Excel;
use Illuminate\Support\Facades\Input;
use Validator;
use File;
use Hash;
use Storage;
use DateTime;

class HomeController extends Controller
{
    public function getLogOut(){
        Auth::logout();
        return redirect()->route('getlogin');
    }
    // ng-login
    public function ngPostLogin(Request $req){
        $email = $req->email;
        $password=$req->password;

        if(Auth::attempt(['email'=>$email,'password'=>$password])){
            $url="";
            $role_id=Auth::user()->role_id;
            if($role_id==2){
                $url="admin/dashboard";
            }
            return response()->json(['status'=>true,'message'=>'Đăng nhập thành công','url'=>$url]);
            
        }else{
            return response()->json(['status'=>false,'errors'=>'Email hoặc mật khẩu không đúng']);
        }
    }

    public function getDownloadEmpCV($name){
        try{
            return response()->download('uploads/emp/cv/'.$name);
        }catch(\Exception $e){
            return response()->json(['flag'=>false,'mess'=>'The filename invalid']);
        }
    }

    /**--------------REGISTER A EMPLOYER - Master Or Assitant-------------------*/
    public function ngLoadReg(){
        $cities = Cities::all();
        $emps = Employers::where('status',1)->get();

        return response()->json(['cities'=>$cities,'emps'=>$emps]);
    }
    public function getRegisterEmp(){
        return view('layouts.registeremp');
    }
    public function postRegisterEmp(Request $request){

        try{
            //check
            $type = (!Employers::where('id',$request->id)->first())?0:10; //0:master reg  10:assis reg
            // dd($type);


            //data
            $user = User::findOrFail(Auth::user()->id);
            $check = (Registration::where('user_id',$user->id)->first())?false:true; //de su dung sau
            if(!$check){
                return response()->json(['status'=>false,'message'=>'You have registered 1 employer']);
                // return redirect()->back()->withErrors('You have registered 1 employer');
            }
            $flag = true;
            //validate
            //success

            //case Master and Assistant
            //construct
            $res = new Registration();

            switch ($type) {
                case 0:
                   //create employers //NAME,CITY,ADDRESS,WEBSITE ->
                    $emp = new Employers();
                    $emp->status = 0; //not yet confirm
                    $emp->name= $request->name;         //nam
                    $emp->city_id  = $request->city_id; 
                    $emp->address = $request->address; 
                    $emp->website = $request->website;
                    $emp->save();

                    $res->emp_id = $emp->id;
                    break;
                case 10:
                    $res->emp_id = $request->id;
                    break;
                default:
                    $flag = false;
                    break;
            }
                
            if($flag){
                //create registration
                $res->user_id = $user->id;
                $res->status = $type;//master:0   assis:10 - waiting confirm
                $res->save();
            }


            return response()->json(['status'=>true,'message'=>'Register successfully']);
        }catch(Exception $e){
            return response()->json(['status'=>false,'message'=>'Register failed']);
        }
    }
}
