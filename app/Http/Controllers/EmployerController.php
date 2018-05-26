<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Registration;
use Auth;
use App\User;
use App\Follow_employers;
use App\Follows;
use App\Applications;
use App\Employers;
use App\Skills;
use App\Cities;
use App\Skill_employer;
use App\Skill_job;
use App\Job;
use Mail;
use App\Reviews;
use DateTime;
use Validator;
use Illuminate\Support\Facades\Input;
use File;
use Carbon\Carbon;
use Session;
use App\Notifications\ConfirmAssistant;
use App\Notifications\ConfirmPost;
use App\Notifications\NotifyNewPost;
use App\Traits\Company\CompanyMethod;
use App\Traits\User\ApplyMethod;
use App\Traits\CommonMethod;
use App\Traits\User\UserMethod;
use App\Traits\Job\JobMethod;

class EmployerController extends Controller
{
    use CompanyMethod, ApplyMethod, CommonMethod, UserMethod, JobMethod;

	/**
     * Function change from name to alias and remove Vietnamese
     */
    public function changToAlias($str) {
    	$str = strtr(utf8_decode($str), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
        $str =   str_replace('?', '',strtolower($str));
        return  str_replace(' ', '-',strtolower($str));
    }

	//Load trang
   	public function getIndex() {
        return redirect()->route('getEmpBasic');
    }

   	public function getAdvance() {
        $empid = Auth::user()->emp_id;
   		return view('employer.advance', compact('empid'));
   	}

   	/*-----------------TRANG QUẢN TRỊ CỦA EMPLOYER--------------------------
	*-----Thêm xóa sửa Assistant--- thong6 qua truy cập bảng Registration---
	*--Chấp nhận hoặc từ chối sự tham gia hỗ trợ đăng bài của thành viên----
   	*------------------Chỉnh sửa thông tin của Employer---------------------
   	*------------------------Route này của master---------------------------*/
	public function ngGetAdvance($id) {
        //list city,skills  -- các danh sách chung
        $cities = Cities::all();
        $skills = Skills::all();
        //
		$dataassis = $this->ngGetAssistantByEmpId($id);
		$assis = $dataassis['assis'];
		//info employer
		$emp = Employers::find($id);
		$city = $emp->city;
		//list skill
        $myskills = Skill_employer::where('skill_employers.emp_id', $id)
                                  ->join('skills','skills.id', '=', 'skill_employers.skill_id')
                                  ->select('skills.*')
                                  ->get();

        //Get list posts of Employer (pending-publish-expire-masterdeleted) ->Khong lay save va2 delete cua Assis
        $posts = Job::with('User', 'Applications')
                     ->where('emp_id', $id)
                     ->where(function($q) {
                        $q->orWhere('status', 10);   //->pending
                        $q->orWhere('status', 1);    //->publisher
                        $q->orWhere('status', 11);   //->expire
                        $q->orWhere('status', 12);   //->master deleted
                    })->get();

        return response()->json(['assis' => $assis,
                                 'emp' => $emp,
                                 'myskills' => $myskills,
                                 'city' => $city,
                                 'cities' => $cities,
                                 'skills' => $skills,
                                 'posts' => $posts]);
	}

		/*CONFIRM/DENY pending Employee*/

    public function ngGetConfirmAss($id,$user_id) {	//id: employer_id 
        try {
            $user = User::findOrFail($user_id);
            $emp = Employers::findOrFail($id);
            //with assistant
            $regis = Registration::where('emp_id', $id)
                                 ->where('user_id', $user_id)
                                 ->first();
            //
            $regis->status = 11;
            $regis->save();
            //
            $user->role_id = 4;
            $user->emp_id = $id;
            $user->save();

            $data = $this->ngGetAssistantByEmpId($id);
            $assis = $data['assis'];

            //send notification to this person
            $user->notify(new ConfirmAssistant($emp, true));

            return response()->json(['status' => true, 
                                     'message' => 'Confirm Successfully', 
                                     'assis' => $assis]);
        } catch(Exception $e) {
            return response()->json(['status' => false,
                                     'message' => 'Confirm failed']);
        }
    }

    public function ngGetDenyAss($id, $user_id) {
        try {
            $user = User::findOrFail($user_id);
            $emp = Employers::findOrFail($id);
            //with master
            $register = Registration::where('emp_id', $id)
                                    ->where('user_id', $user_id)
                                    ->first();
            //
            $register->status = 12;
            $register->save();

            $data = $this->ngGetAssistantByEmpId($id);
            $assis = $data['assis'];

            //send notification to this person
            $user->notify(new ConfirmAssistant($emp, true));

            return response()->json(['status' => true, 
                                     'message' => 'Deny Successfully', 
                                     'assis' => $assis]);
        } catch(Exception $e) {
            return response()->json(['status' => false,
                                     'message' => 'Deny failed']);
        }
    }

    /*-------Edit Info of Employer---------*/
    /*-------without logo and cover------------*/
    /*------updated: 1-12-2017 has logo and cover----*/
    public function ngGetUpdateEmpInfo(Request $request,$id) {
        /*id name website address alias city_id phone description schedule overtime ListSkills*/
        try {
            $emp = Employers::findOrFail($id);
            $emp->name = $request->emp['name'];
            $emp->alias = $this->changToAlias($request->emp['name']);
            $emp->website = $request->emp['website'];
            $emp->address = $request->emp['address'];
            $emp->city_id = $request->emp['city_id'];
            $emp->phone = $request->emp['phone'];
            $emp->description = $request->emp['description'];
            $emp->schedule = $request->emp['schedule'];
            $emp->overtime = $request->emp['overtime'];
            $emp->save();

            //xóa các skill cũ -> add lại skill mới
            Skill_employer::where('emp_id', $id)->delete();
            if (sizeof($request->skills) > 0) {
                foreach($request->skills as $skill) {
                    $ski = new Skill_employer();
                    $ski->emp_id = $id;
                    $ski->skill_id = $skill['id'];
                    $ski->save();
                }
            }
            return response()->json(['status' => true, 
                                        'message' => 'Update Successfully']);
            
        } catch(Exception $e) {
            return response()->json(['status' => false, 
                                        'message' => 'Failed']);
        }
    }
            //change logo and cover
    public function postChangeLogoCoverEmp(Request $request, $empid, $type) {
        //type:1-cover:2-logo
        $validator  = Validator::make($request->all(), [
            'file' => 'max:5000|mimes:jpg,jpeg,bmp,png'
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                                ->withErrors('Size of image too large or is not the 
                                following type:jpg, jpeg, bmp, png');
        }
        // dd($request->all());
        if (Input::hasfile('file') && $empid && $type) {
            try {
                $file = Input::file('file');
                //get extension of a image
                $file_extension = File::extension($file->getClientOriginalName());
                $employer = Employers::findOrFail($empid);

                if ($type ==1 ) {
                    $filename = "cover_employer_".$empid.".".$file_extension;
                    $file->move('uploads/emp/cover', $filename);
                    $employer->cover = $filename;
                } else {
                    if ($type == 2) {
                        $filename = "logo_employer_".$empid.".".$file_extension;
                        $file->move('uploads/emp/logo', $filename);
                        $employer->logo = $filename;
                    }
                }
                $employer->save();
            } catch(\Exception $e) {
                    return redirect()->back()->withErrors('Error while save!');
            }
        }else{
            return redirect()->back()->withErrors("File haven't choose!");
        }
        return redirect()->back()->with(['message' => 'Change successful!']);
    }

    /**
     * function get list assistant by EmployerId
     */
   	public function ngGetAssistantByEmpId($id) {
        $assis = Registration::where('registration.emp_id',$id)
                             ->where(function($q) {
                                    $q->orWhere('registration.status', 10);
                                    $q->orWhere('registration.status', 11);
                                    $q->orWhere('registration.status', 12);
                                })
                             ->join('users','users.id', '=', 'registration.user_id')
                             ->select('users.*', 'registration.*')
                             ->get();
		return ['assis' => $assis];
	}

    /**
     * function get user by id
     */
    public function getUser($id) {
        return User::findOrFail($id);
    }

   	/*------------------------------END TRANG QUẢN TRỊ-----------------------------*/

    /**
     * BASIC:Dashboar và post bài + quản lý bài mình post
     */
    public function getEmpBasic() {
        $employer = Employers::whereIn('employee', [Auth::id()])->first();
        return view('employer.basic', compact('employer'));
    }

    /**
     * Get data when load page Basic
     */
    public function ngGetBasic($empId) {
        $cities = $this->getAllCities();
        $skills = $this->getAllSkills();
        $today = Carbon::now()->startOfDay();
        //riêng
        $myPosts = $this->listPostOfUser();
        //Dashboard
        //posts
        $listPost = $this->getJobOfByCompany($empId);
        $postToday = $this->getJobsToday($empId);
        //applications
        $listApply = $this->getApplicationByCompany($empId);
        $listApplyToday = $this->getApplicationByCompany($empId, $today);
        //reviews
        $reviews = $this->getReviewOfCompany($empId);
        $reviewToday = $this->getReviewTodayOfCompany($empId, $today);
        //follow
        $follows = $this->getFollow($empId);
        return response()->json(['cities' => $cities,
                                'skills' => $skills,
                                'myPosts' => $myPosts,
                                'countPostToday' => count($postToday),
                                'countApplyToday' => count($listApplyToday),
                                'countReviewToday' => count($reviewToday),
                                'follows' => $follows,
                                'posts' => $listPost,
                                'applies'=> $listApply,
                                'reviews' => $reviews
                            ]);
    }

    /**
     * Create a job (post)
     */
    public function ngCreatePost(Request $request, $empid) {
        $user_id = Auth::user()->id;
        /*id name alias salary description require treatment quantity user_id emp_id city_id follow* status created_at updated_at date_expired* */
        try {
            $job = new Job();
            $job->name = $request->job['name'];
            $job->alias = $this->changToAlias($request->job['name']);
            if ( !empty($request->job['salary']))
                $job->salary = $request->job['salary'];
            if ( !empty($request->job['description']))
                $job->description = $request->job['description'];
            if ( !empty($request->job['require']))
                $job->require = $request->job['require'];
            if ( !empty($request->job['treatment']))
                $job->treatment = $request->job['treatment'];
            if ( !empty($request->job['quantity']))
                $job->quantity = $request->job['quantity'];

            if ( !empty($request->job['date_expire'])) {
                // $date =strtotime("Sun Jan 01 2017 08:00:00 GMT+0700 (Altai Standard Time)");
                //Loại bỏ cái trong ngoặc (Altai Standard Time)
                $substr = substr($request->job['date_expire'],0,strpos($request->job['date_expire'],"("));
                $date = new DateTime($substr);
                $date2 = $date->getTimestamp(); //chuyển sang unix datetime
                $job->date_expire = $date;
            }

            $job->user_id = $user_id;
            $job->emp_id = $empid;
            $job->city_id = $request->job['city_id'];

            $job->status=0;//0:saving, 10: pending, 1: publisher,11: expired,2: deleted
            $job->save();

            //xóa các skill cũ -> add lại skill mới
            Skill_job::where('job_id', $job->id)->delete();
            if (sizeof($request->skills) > 0) {
                foreach($request->skills as $skill) {
                    $ski = new Skill_job();
                    $ski->job_id = $job->id;
                    $ski->skill_id = $skill['id'];
                    $ski->save();
                }
            }
            return response()->json(['status' => true, 'message' => 'Saved post']);
        } catch(Exception $e) {
            return response()->json(['status' => false, 'message' => 'Failed to save this post']);
        }
    }

        /*--------------------------Edit the post---------------------------*/
    public function ngEditPost(Request $request, $empid, $id) {
        $user_id = Auth::user()->id;
        /*id name alias salary description require treatment quantity user_id emp_id city_id follow* status created_at updated_at date_expired* */
        try{
            $job = Job::findOrFail($id);

            $job->name = $request->job['name'];
            $job->alias = $this->changToAlias($request->job['name']);
            if ( !empty($request->job['salary']))
                $job->salary = $request->job['salary'];
            if ( !empty($request->job['description']))
                $job->description = $request->job['description'];
            if ( !empty($request->job['require']))
                $job->require = $request->job['require'];
            if ( !empty($request->job['treatment']))
                $job->treatment = $request->job['treatment'];
            if ( !empty($request->job['quantity']))
                $job->quantity = $request->job['quantity'];

            if ( !empty($request->job['date_expire'])) {
                // $date =strtotime("Sun Jan 01 2017 08:00:00 GMT+0700 (Altai Standard Time)");
                //Loại bỏ cái trong ngoặc (Altai Standard Time)
                $substr = substr($request->job['date_expire'], 0, strpos($request->job['date_expire'], "("));
                $date = new DateTime($substr);
                $date2 = $date->getTimestamp(); //chuyển sang unix datetime
                $job->date_expire = $date;
            }
            $job->city_id = $request->job['city_id'];

            //check user và emp
            if ($job->emp_id != $empid || $job->user_id != $user_id) {
                return response()->json(['status' => false,'message' => 'Employer or User is invalid']);
            }


            $job->status = 0;//0:saving, 10: pending, 1: publisher,11: expired,2: deleted
            $job->save();

            //xóa các skill cũ -> add lại skill mới
            Skill_job::where('job_id', $job->id)->delete();
            if (sizeof($request->skills) > 0) {
                foreach($request->skills as $skill) {
                    $ski = new Skill_job();
                    $ski->job_id = $job->id;
                    $ski->skill_id = $skill['id'];
                    $ski->save();
                }
            }

            return response()->json(['status' => true, 'message' => 'Saved post']);
        } catch(Exception $e) {
            return response()->json(['status' => false, 'message' => 'Failed to save this post']);
        }
    }

    /**
     * Get post by id
     */
    public function ngGetPost($id) {
        $post = Job::findOrFail($id);
        //post's skills
        $postskills = Skill_job::where('skill_job.job_id', $id)
                                ->join('skills','skills.id', '=', 'skill_job.skill_id')
                                ->select('skills.*')
                                ->get();
        return response()->json(['post' => $post, 'postskills' => $postskills]);
    }

    /**
     * Trash and Push posts
     */
    public function ngTrashPost($id) {
        try {
            $post = Job::findOrFail($id);
            $post->status = 2;
            $post->save();
            return response()->json(['status' => true, 'message' => 'Moved post to trash']);
        } catch(Exception $e) {
            return response()->json(['status' => false, 'message' => 'Failed to delete']);
        }
    }

    public function ngPushPost($id) {
        try {
            $post = Job::findOrFail($id);
            $post->status = 10;
            $post->save();
            return response()->json(['status' => true, 'message' => 'Pushed and waiting to confirm']);
        } catch(Exception $e) {
            return response()->json(['status' => false, 'message' => 'Failed to push']);
        }
    }
        /*--------------Confirm/Deny posts-------------------------*/

    public function ngConfirmPost($id) {
        try {
            $post = Job::findOrFail($id);
            //change status from Pending to Publisher: from 10 to 1
            $post->status = 1;
            $post->save();
            //notification to author
            $post->user->notify(new ConfirmPost($post,true));
            //notification to users has followed (recommend Queue)
            $userFollowed = Follow_employers::where('emp_id', $post->emp_id)->get();
            foreach($userFollowed as $user) {
                $user->user->notify(new NotifyNewPost($post, $post->Employer->name));
            }

            return response()->json(['status' => true, 'message' => 'Confirm Successfully']);
        } catch(Exception $e) {
            return response()->json(['status' => false, 'message' => 'Confirm failed']);
        }
    }

    public function ngDenyPost($id) {
        try {
            $post = Job::findOrFail($id);
            //change status from Pending to Master Deleted: from 10 to 12
            $post->status = 12;
            $post->save();

            //notification to user
            $post->user->notify(new ConfirmPost($post,false));

            return response()->json(['status' => true, 'message' => 'Deny Successfully']);
        } catch(Exception $e) {
            return response()->json(['status' => false, 'message' => 'Deny failed']);
        }
    }

    /*
    |                   SEND EMAIL TO CANDIDATE AND SET UP DATE: 
    |                       (date,hour,address)  
    |---------------------------------------------------------------------
    |                       Send email by SWIFTMAILER
    */
    public function postSendEmail(Request $request) {
        // dd($request->all());
        $data = ['contentemail' =>$request->contentemail];
        Mail::send('partials.email1', $data, function($msg) use ($request) {
            $msg->from('itjobchallenge@gmail.com', 'IT JOB - CHALLENGE YOUR DREAM');
            $msg->to($request->email,$request->email)->subject('Trả lời đơn xin việc của các ứng viên');
        });
        Session::flash('flash_message', 'Send email successfully!');
        return redirect()->back();
    }
    /*
    |-------------SEND NOTIFICATION----------------
    |For: Employer
    |Case:  co người apply, có người follow-review, 
    |       confirm assistant, comfirm post
    |For: User
    |Case: Công ty đã follow có post(publisher)
    |
    |Action:
    |       post publisher => add noti for all user has Followed
    |
    |       confirm emp => add noti for admin, user
    |
    |       confirm/deny assistant=> add noti for assistant
    |   
    |       apply => add noti for emp đã apply
    |       follow-review => add noti for emp đã apply
    |       
    */
}
