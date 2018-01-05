<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Applications;
use App\Employers;
use Auth;
use Illuminate\Support\MessageBag;
use Image;
use App\Events\SendMail;
use Validator;
use DB;
use Cache;
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
        $email = $req->newEmail;
        
        if($email != Auth::user()->email){
            $find = User::where('email',$email);
             return response()->json([
                'error'=>true,
                'message'=>'Email đã tồn tại'
                ],200);
        }
        $user=User::where('id',Auth::id())->update(['email'=>$req->newEmail]);
         return response()->json([
                'error'=>false,
                'message'=>'Cập nhật email thành công'
                ],200);
    }
    public function editProfile(Request $req)
    {
        $user=User::findOrFail(Auth::user()->id);
        dd($user);
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
        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ];
        $messages = [
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'password.required' => 'Mật khẩu không được để trống',
            'password.min' => 'Mật khẩu ít nhất 6 ký tự',
        ];
        $validator = Validator::make($req->all(),$rules,$messages);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $email = $req->email;
            $password = $req->password;

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
                $errors=new MessageBag(['errorLogin'=>'Email hoặc mật khẩu không đúng']); 
                return redirect()->back()->withInput()->withErrors($errors);
            }
        }
  		
    }
    public function postLoginModal(Request $req){
        $email = $req->email;
        $password=$req->password;

        if(Auth::attempt(['email'=>$email,'password'=>$password])){

            return response()->json([
                'error'=>false,
                'message'=>''
                ],200);
        }
        return response()->json([
                'error'=>true,
                'message'=>'Email hoặc mật khẩu không đúng'
            ],200);
    }
    public function postRegisterModal(Request $req){
        $user = User::where('email',$req->email)->first();
        if($user) {
            return response()->json([
                'error' => true,
                'message' => 'Email đã tồn tại'
            ],200);
        }else {
            $user = User::create([
                'name' => $req->name,
                'email' => $req->email,
                'password' => bcrypt($req->password)
            ]);
            event(new SendMail($user));
            return response()->json([
                'error'=>false,
                'message'=>'Tạo thành công tài khoản'
                ],200);
        }
    }
    public function getJobApplicationsOfUser(){
        $jobApplications = DB::table('jobs as j')
                                ->select('j.*','c.name as cn','e.name as en')
                                ->join(DB::raw('(select job_id from applications where user_id='.Auth::id().') as a'),function($join){
                                    $join->on('j.id','=','a.job_id');
                                })
                                ->join('cities as c','j.city_id','=','c.id')
                                ->join('employers as e','j.emp_id','=','e.id')
                                ->orderBy('j.id','desc')
                                ->get();
        $top_emps = Cache::remember('top_emps', 10, function(){
            return Employers::select('id','name','alias','logo')->orderByRaw('rating desc,follow desc')->offset(0)->take(12)->get();
        });                        
        return view('layouts.job-applications',compact('jobApplications','top_emps'));
    }
}
