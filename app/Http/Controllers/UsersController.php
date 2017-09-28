<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Users;
use Auth;
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
  			return redirect()->intended('admin/index');
  		}
    }
}
