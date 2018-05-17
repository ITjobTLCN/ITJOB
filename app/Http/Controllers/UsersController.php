<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Applications;
use App\Employers;
use App\Roles;
use Auth;
use Illuminate\Support\MessageBag;
use Image;
use App\Events\SendMail;
use Validator;
use DB;
use Cache;
use Hash;
use App\Job;
use App\Traits\User\UserMethod;
use App\Traits\CommonMethod;

class UsersController extends Controller
{
    use UserMethod, CommonMethod;

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
                $role = Roles::where('_id', Auth::user()->role_id)->value('route');
                return redirect()->route($role);
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
        if ($req->isMethod('get')) {
            return view('layouts.dangky');
        } else {
            $user = User::where('email', $req->email)->first();
            if (!is_null($user) || !empty($user)) {
                return response()->json([
                    'error' => true,
                    'message' => 'Email đã tồn tại'
                ], 500);
            } else {
                $data = $req->only([ 'name', 'email', 'password' ]);
                try {
                    $this->insertUser($data);
                } catch(\Exception $e) {
                     return $e->getMessage();
                }
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
            ]);
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
        $topEmployers = [];
        $jobApplications = Job::with('employer')
                                ->where('apply_info.user_id', Auth::id())
                                ->get();
        if ( !empty($jobApplications)) {
            $topEmployers = Cache::remember('topEmployer', config('constant.cacheTime'), function() {
                return Employers::select('name', 'alias', 'images.avatar')
                                    ->orderBy('rating desc')
                                    ->orderBy('quantity_user_follow desc')
                                    ->offset(0)
                                    ->take(config('constant.limitCompany'))
                                    ->get();
            });
        }
        return view('layouts.job-applications', compact('jobApplications', 'topEmployers'));
    }
}
