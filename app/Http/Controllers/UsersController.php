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
use Hash;
class UsersController extends Controller
{
    public function getLogin() {
        if(Auth::check()) 
            return redirect()->route('/');
    	return  view('layouts.dangnhap');
    }

    public function postLogin(Request $req) {
        $credentials = $req->only('email', 'password');

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

        $validator = Validator::make($credentials, $rules, $messages);
        if($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        } else {
            if(Auth::attempt($credentials)) {
                switch (Auth::user()->role_id) {
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
            } else {
                $errors = new MessageBag(['errorLogin' => 'Email hoặc mật khẩu không đúng']); 
                return redirect()->back()
                                 ->withInput()
                                 ->withErrors($errors);
            }
        }
    }

    public function logout() {
      Auth::logout();
      return redirect(\URL::previous());
    }

    public function register(Request $req) {
        if($req->isMethod('get')) {
            return view('layouts.dangky');
        } else {
            $user = User::where('email', $req->email)->first();

            if($user) {
                return response()->json([
                    'error' => true,
                    'message' => 'Email đã tồn tại'
                ], 200);
            } else {
                $user = User::create([
                    'name' => $req->name,
                    'email' => $req->email,
                    'password' => Hash::make($req->password),
                    'role_id' => 1
                ]);
                //event(new SendMail($user));
                return response()->json([
                    'error' => false,
                    'message'=>'Tạo thành công tài khoản'
                    ], 200);
            }
        }
    }

    public function getProfile() {
        $user = Auth::user();
        return view('layouts.profile', compact('user'));
    }

    public function postAvatar(Request $req) {
        if($req->hasFile('avatar')) {
            $avatar=$req->file('avatar');
            $filename=time().'.'.$avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300,300)->save(public_path('/uploads/user/avatar/'.$filename));

            $user=Auth::user();
            $user->image=$filename;
            $user->save();
        }

        return view('layouts.profile',array('user'=>Auth::user()));
    }
    public function editEmail(Request $req) {
        $email = $req->newEmail;
        
        if($email != Auth::user()->email){
            $find = User::where('email',$email);
             return response()->json([
                'error'=>true,
                'message'=>'Email đã tồn tại'
                ],200);
        }

        $user=User::where('id', Auth::id())->update(['email'=>$req->newEmail]);

        return response()->json([
                'error'=>false,
                'message'=>'Cập nhật email thành công'
                ],200);
    }

    public function editProfile(Request $req) {
        $user=User::findOrFail(Auth::user()->id);
        if($req->hasFile('cv')) {
            $cv = $req->file('cv');
            $filename = $cv->getClientOriginalName();
            $cv->move('uploads/user/cv/' , $filename);
            $user->cv = $filename;      
        }

        $user->name = $req->name;
        $user->describe=$req->describe;
        $user->save();
        return redirect()->back()->with(['success'=>'Cập nhật thông tin thành công']);
    }

    public function postLoginModal(Request $req) {
        $credentials = $req->only('email', 'password');

        if(Auth::attempt($credentials)) {
            return response()->json([
                    'error' => false,
                    'message' => 'Đăng nhập thành công'
                    ], 200);
        }

        return response()->json([
                'error' => true,
                'message' => 'Email hoặc mật khẩu không đúng'
            ], 401);
    }

    public function postRegisterModal(Request $req) {
        $user = User::where('email', $req->email)->first();
        if($user) {
            return response()->json([
                'error' => true,
                'message' => 'Email đã tồn tại'
            ],200);
        } else {
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

    public function getJobApplicationsOfUser() {
        $jobApplications = DB::table('job as j')
                                ->select('j.*','c.name as cn','e.name as en','e.logo')
                                ->join(DB::raw('(select job_id from applications where user_id='.Auth::id().') as a'),function($join){
                                    $join->on('j.id','=','a.job_id');
                                })
                                ->join('cities as c','j.city_id','=','c.id')
                                ->join('employers as e','j.emp_id','=','e.id')
                                ->orderBy('j.id','desc')
                                ->get();
        $top_emps = Cache::remember('top_emps', 10, function() {
            return Employers::select('id','name','alias','logo')->orderByRaw('rating desc,follow desc')->offset(0)->take(12)->get();
        });                        
        return view('layouts.job-applications',compact('jobApplications','top_emps'));
    }
}
