<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Illuminate\Support\MessageBag;
class UsersController extends Controller
{
	 public function _construct()
    {
    	$this->middleware('auth');
    }
    public function getLogin()
    {
    	return view('layouts.dangnhap');
    }
    public function logout()
    {
      Auth::logout();
      return redirect(\URL::previous());
    }
    public function getRegister()
    {
    	return view('layouts.dangky');
    }
    public function getProfile()
    {
      return view('layouts.profile');
    }
    public function getProfileUser()
    {
      if(Auth::check()){
          return $user=Auth::user();
      }
    }
    public function editEmail(Request $req)
    {
        if(Auth::check()){
            $user=new User();
            $id=Auth::user()->id;
            $email=$req->newEmail;
            $user=User::where('id',$id)->update(['email'=>$email]);
            // return "them thanh cong";
        }
        
    }
    public function editProfile(Request $req)
    {
        if(Auth::check()){
            $user=User::findOrFail(Auth::user()->id);
            $user->name=$req->name;
            $user->describe=$req->describe;
            $user->save();
        }
    }
    public function postLogin(Request $req)
    {
  		$email = $req->email;
  		$password=$req->password;

  		if(Auth::attempt(['email'=>$email,'password'=>$password])){
        $role_id=Auth::user()->role_id;
        if($role_id==1){
  			 return redirect()->intended('admin/index');
        }else if($role_id==2){
            return redirect()->route('/');
        }else{

        }
  		}else{
        $errors=new MessageBag(['errorLogin'=>'Email hoặc mật khẩu không']); 
        return redirect()->back()->withInput()->withErrors($errors);
      }
    }
}
