<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DateTime;

class AdminController extends Controller
{
    //
    // public function __construct(){
    // 	$this->middleware('admin');
    // }
    public function getIndex(){
    	return view('admin.content.index');
    }
    public function getUser(){
        $users = User::all();
    	return view('admin.content.user',compact('users'));
    }
    public function getListUser(){
        return User::orderBy('created_at','DESC')->get();
    }

    public function postAddUser(Request $request){
        $user = new User();
        $user->name     =$request->name;
        $user->email    =$request->email;
        $user->password =bcrypt($request->password);
        $user->describe =$request->describe;
        $user->role_id  =$request->role_id;
        $user->status   =$request->status;
        $user->image    ='';
        // $user->created_at = new DateTime();
        $user->save();
        return "Thêm thành công";
    }
    public function getUserId($id){
        return User::find($id); //nếu sử dụng findOrFail thì sẽ xuất lỗi khi không tìm thấy
    }

    public function postEditUser(Request $request,$id){
        $user = User::find($id);
        $user->name     =$request->name;
        $user->email    =$request->email;
        $user->password =bcrypt($request->password);
        $user->describe =$request->describe;
        $user->role_id  =$request->role_id;
        $user->status   =$request->status;
        $user->image    ='';
        $user->updated_at = new DateTime();
        $user->save();
        return "Sửa thành công";
    }
    public function getDelUser($id){
        $user = User::findOrFail($id);
        $user->delete();
        return "Đã Xóa";
    }
}
