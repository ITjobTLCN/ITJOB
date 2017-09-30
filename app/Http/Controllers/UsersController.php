<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Users;
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
