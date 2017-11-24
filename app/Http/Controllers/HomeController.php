<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\User;
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

}
