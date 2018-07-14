<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use App\User;
use App\Applications;
use App\Employers;
use App\Roles;
use App\Job;

use App\Events\SendMail;
use App\Traits\User\UserMethod;
use App\Traits\CommonMethod;

use Auth;
use Image;
use Validator;
use Cache;
use File;

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
                ], 200);
            } else {
                $data = $req->only([ 'name', 'email', 'password' ]);
                try {
                    $this->insertUser($data);
                } catch(\Exception $e) {
                     return $e->getMessage();
                }
                $user = User::where('email', $data['email'])->first();
                dispatch(new \App\Jobs\SendMail($user));
                return response()->json([
                    'error' => false,
                    'message'=>'Tạo thành công tài khoản'
                    ], 200);
            }
        }
    }

    public function getPageProfile() {
        return view('layouts.profile', ['user' => Auth::user()]);
    }

    public function getInfoUser() {
        return response()->json([
            'error' => false,
            'data' => Auth::user()
        ]);
    }

    public function postAvatar(Request $req) {
        if($req->hasFile('avatar')) {
            $avatar = $req->file('avatar');
            $image_path = public_path('uploads/avatar/' . Auth::user()->avatar);
            if(File::exists($image_path)) {
                File::delete($image_path);
            }

            $filename = $this->changToAlias(Auth::user()->name) . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300, 300)->save(public_path('/uploads/avatar/' . $filename));

            $user = Auth::user();
            $user->avatar = $filename;
            $user->save();
        }

        return redirect()->route('profile');
    }
    public function editEmail(Request $req) {
        $email = $req->newEmail;
        $findEmail = User::where('email', $email)->first();
        if (!empty($findEmail)) {
            return response()->json([
                    'error' => true,
                    'message' => 'Email has been already'
                ]);
        }
        try {
            $user = User::where('_id', Auth::id())
                            ->update(['email' => $email]);
            return response()->json([
                            'error' => false,
                            'message' => 'Update Email Successfully',
                            'email' => $email
                        ]);
        } catch(\Exception $e) {
            return response()->json([
                            'error' => true,
                            'message' => 'Can NOT update email'
                        ]);
        }
    }

    public function editProfile(Request $req) {
        $user = User::findOrFail(Auth::id());
        if ($req->hasFile('cv')) {
            $cv = $req->file('cv');
            $file_extension = File::extension($cv->getClientOriginalName());
            $filename = 'cv-' . $this->changToAlias(Auth::user()->name) . '.' . $file_extension;

            if (file_exists(public_path() . "/uploads/user/cv/{$filename}")) {
                File::delete(public_path() . "/uploads/user/cv/{$filename}");
            }

            $cv->move('uploads/user/cv/' , $filename);
            $user->cv = $filename;
        }

        $user->name = $req->name;
        $user->description = $req->description;
        $user->save();

        return redirect()->back()->with('success', 'Update Profile Successfully');
    }

    public function postLoginModal(Request $req) {
        $credentials = $req->only('email', 'password');
        if (Auth::attempt($credentials)) {
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
        if (!empty($user)) {
            return response()->json([
                'error' => true,
                'message' => 'Email đã tồn tại'
            ]);
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
                ]);
        }
    }

    public function getJobApplicationsOfUser() {
        $topEmployers = [];
        $jobApplications = Applications::with('employer', 'job')
                                            ->where('user_id', Auth::id())
                                            ->get();
        if (!is_null($jobApplications) || !empty($jobApplications)) {
            $topEmployers = Cache::remember('topEmployer', config('constant.cacheTime'), function() {
                return Employers::select('name', 'alias', 'images.avatar')
                                    ->orderBy('quantity_user_follow desc')
                                    ->offset(0)
                                    ->take(config('constant.limit.company'))
                                    ->get();
            });
        }

        return view('layouts.job-applications', compact('jobApplications', 'topEmployers'));
    }
}
