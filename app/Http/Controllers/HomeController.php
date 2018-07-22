<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\User;
use App\Registration;
use App\Cities;
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
use App\Traits\User\UserMethod;
use App\Traits\CommonMethod;
use App\Traits\Company\CompanyMethod;
use Session;

class HomeController extends Controller
{
    use CommonMethod, CompanyMethod, UserMethod;

    public function getLogOut() {
        Auth::logout();
        return redirect()->route('getlogin');
    }

    public function ngPostLogin(Request $req) {
        $email = $req->email;
        $password = $req->password;

        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            // Get user id of current user by email
            $user_id = User::where('email', $req->email)->select('_id')->get();
            // Save data in access log
            $this->insertAccessLog($user_id);

            $url = "";
            $role_id = Auth::user()->role_id;
            if ($role_id == 2) {
                $url = "admin/dashboard";
            }
            return response()->json(['status' => true,
                                      'message' => 'Đăng nhập thành công',
                                      'url' => $url]);
        } else {
            return response()->json(['status' => false,
                                     'errors' => 'Email hoặc mật khẩu không đúng']);
        }
    }

    public function getDownloadEmpCV($name) {
        try {
            return response()->download('uploads/emp/cv/'.$name);
        } catch(\Exception $e) {
            return response()->json(['flag' => false,'mess' => 'The filename invalid']);
        }
    }

    /**--------------REGISTER A EMPLOYER - Master Or Assitant-------------------*/
    public function loadRegisterEmployer() {
        $cities = $this->getAllCities();
        $emps = Employers::where('deleted', false)->get();
        return response()->json(['cities' => $cities, 'emps' => $emps]);
    }
    public function getRegisterEmployer(Request $request) {
        return view('layouts.registeremp');
    }
    public function postRegisterEmployer(Request $request) {
        //check
        if ( !empty(Registration::where('user_id', Auth::id())->first())) {
            return response()->json(['status' => false, 'message' => 'You have registered 1 employer']);
        }

        $flag = true;
        //case Master and Assistant
        $emp_id = 0;
        //0:master reg  10:assis reg
        (!isset($request->_id) || empty($request->_id)) ? $type = 0 : $type = 10;
        switch ($type) {
            case 0:
               //create employers //NAME,CITY,ADDRESS,WEBSITE ->
                $data = $request->only(['name', 'city_id', 'address', 'website']);
                try {
                    $id = $this->saveEmployer($data);
                    $emp_id = strval($id);
                } catch(\Exception $ex) {
                    return response()->json(['status' => false, 'message' => 'Can NOT create employer']);
                }
                break;
            case 10:
                $emp_id = $request->_id;
                break;
            default:
                $flag = false;
                break;
        }

        if ($flag) {
            //create registration
            $data = [
                'emp_id' => $emp_id,
                'type' => $type
            ];
            if ($this->saveRegisterEmployer($data)) {
                return response()->json(['status' => true, 'message' => 'Register employer successfully']);
            }

            return response()->json(['status' => false, 'message' => 'Register employer failed']);
        }

        return false;
    }
}
