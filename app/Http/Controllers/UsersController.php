<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Illuminate\Support\MessageBag;
use Image;
class UsersController extends Controller
{
	public function _construct(){
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
      return view('layouts.profile',array('user'=>Auth::user()));
    }
    public function postAvatar(Request $req){
        if($req->hasFile('avatar')){
            $avatar=$req->file('avatar');
            $filename=time().'.'.$avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300,300)->save(public_path('/uploads/user/avatar/'.$filename));

            $user=Auth::user();
            $user->image=$filename;
            $user->save();
        }
        return view('layouts.profile',array('user'=>Auth::user()));
    }
    public function editEmail(Request $req){
        $user=new User();
        $id=Auth::user()->id;
        $email=$req->newEmail;
        $user=User::where('id',$id)->update(['email'=>$email]);
    }
    public function editProfile(Request $req)
    {
        $user=User::findOrFail(Auth::user()->id);
        if($req->hasFile('cv')){
            $cv=$req->file('cv');
            $filename = $cv->getClientOriginalName();
            $cv->move('uploads/user/cv/' , $filename);
            $user->cv=$filename;      
        }
        $user->name=$req->name;
        $user->describe=$req->describe;
        $user->save();
        return redirect()->back()->with(['success'=>'Cập nhật thông tin thành công']);
        
    }
    public function postLogin(Request $req){
  		$email = $req->email;
  		$password=$req->password;

  		if(Auth::attempt(['email'=>$email,'password'=>$password])){
            $role_id=Auth::user()->role_id;
            switch ($role_id) {
                case 1:
                     return redirect()->route('profile');
                     break;
                case 2:
                    return redirect()->intended('admin/dashboard');
                    break;
                default:
                    return redirect()->route('getemp');
                    break;
            }
  		}else{
            $errors=new MessageBag(['errorLogin'=>'Email hoặc mật khẩu không']); 
            return redirect()->back()->withInput()->withErrors($errors);
        }
    }
    public function postLoginModal(Request $req){
        $email = $req->email;
        $password=$req->password;

        if(Auth::attempt(['email'=>$email,'password'=>$password])){
            return redirect()->back();
        }
        return response()->json([
                'error'=>true,
                'message'=>'Email hoặc mật khẩu không đúng'
            ],200);
    }
}
