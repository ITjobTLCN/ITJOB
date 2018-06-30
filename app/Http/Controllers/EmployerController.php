<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Registration;
use Auth;
use App\User;
use App\Follow_employers;
use App\Follows;
use App\Employers;
use App\Skills;
use App\Cities;
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
use App\Notifications\PushPost;

use App\Traits\Company\CompanyMethod;
use App\Traits\User\ApplyMethod;
use App\Traits\CommonMethod;
use App\Traits\User\UserMethod;
use App\Traits\Job\JobMethod;
use MongoDB\BSON\UTCDateTime;

class EmployerController extends Controller
{
    use CompanyMethod, ApplyMethod, CommonMethod, UserMethod, JobMethod;

    // public function __construct() {
    //     $this->middleware('auth');
    // }
	/**
     * Function change from name to alias and remove Vietnamese
     */
    public function changToAlias($str) {
    	$str = strtr(utf8_decode($str), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
        $str =   str_replace('?', '', strtolower($str));
        return  str_replace(' ', '-', strtolower($str));
    }

	//Load trang
   	public function getIndex() {
        if (Auth::user()->role_id == '5ac85f51b9068c2384007d9e')
            return redirect()->route('getEmpAdvance');
        return redirect()->route('getEmpBasic');
    }

   	public function getAdvance() {
        $employer = $this->getCompanyWithUser('master');
   		return view('employer.advance', compact('employer'));
   	}

   	/*-----------------TRANG QUẢN TRỊ CỦA EMPLOYER--------------------------
	*-----Thêm xóa sửa Assistant--- thong6 qua truy cập bảng Registration---
	*--Chấp nhận hoặc từ chối sự tham gia hỗ trợ đăng bài của thành viên----
   	*------------------Chỉnh sửa thông tin của Employer---------------------
   	*------------------------Route này của master---------------------------*/
	public function ngGetAdvance() {
        //info employer
        $employer = $this->getCompanyWithUser('master');
        //list city,skills  -- các danh sách chung
        $cities = $this->getAllCities();
        $skills = $this->getAllSkills();
        //
		$assis = $this->ngGetAssistantByEmpId($employer['_id']);
		//list skill
        $myskills = $employer['skills'];

        //Get list posts of Employer (pending-publish-expire-masterdeleted) -> Khong lay save va delete cua Assis
        $posts = $this->getJobsOfCompany($employer['_id']);

        return response()->json(['assis' => $assis,
                                 'employer' => $employer,
                                 'myskills' => $myskills,
                                 'cities' => $cities,
                                 'skills' => $skills,
                                 'posts' => $posts]);
	}

		/*CONFIRM/DENY pending Employee*/

    public function ngGetConfirmAss(Request $req) {	//id: employer_id
        try {
            $user = User::where('_id', $req->userId)->first();
            $emp = Employers::findOrFail($req->empId);
            //with assistant
            $register = Registration::where('emp_id', $req->empId)
                                    ->where('user_id', $req->userId)
                                    ->first();
            //
            $register->status = 11;
            $register->save();
            //
            $user->role_id = '5ac85f51b9068c2384007d9f';
            $user->save();
            $employee = $emp->employee;
            array_push($employee, $req->userId);
            $emp->employee = array_unique($employee);
            $emp->save();

            $assis = $this->ngGetAssistantByEmpId($req->empId);
            //send notification to this person
            $user->notify(new ConfirmAssistant($emp, true, $user));

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

    public function ngGetUpdateEmpInfo(Request $request, $empId) {
        try {
            $arrData = $request->employer;

            $this->updateInfoCompany($arrData, $empId);

            return response()->json(['status' => true,
                                        'message' => 'Update Successfully']);

        } catch(Exception $e) {
            return response()->json(['status' => false,
                                        'message' => 'Failed']);
        }
    }
            //change logo and cover
    public function postChangeImageEmployer(Request $request, $empId, $type) {
        //type:1-cover:2-logo
        $validator  = Validator::make($request->all(), [
            'file' => 'max:5000|mimes:jpg,jpeg,bmp,png'
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                                ->withErrors('Size of image too large or is not the
                                following type:jpg, jpeg, bmp, png');
        }

        if (Input::hasfile('file') && $empId && $type) {
            $file = Input::file('file');
            //get extension of a image
            $file_extension = File::extension($file->getClientOriginalName());
            $filename = $empId . "." . $file_extension;
            if (file_exists(public_path() . "/uploads/emp/{$type}/{$filename}")) {
                File::delete(public_path() . "/uploads/emp/{$type}/{$filename}");
            }

            $file->move("uploads/emp/{$type}", $filename);

            $arrUpdate["images.{$type}"] = $filename;
            try {
                Employers::where('_id', $empId)->update($arrUpdate);
            } catch(\Exception $e) {
                return redirect()->back()->withErrors('Something went wrong!');
            }
        } else {
            return redirect()->back()->withErrors("File haven't choose!");
        }

        return redirect()->back()->with(['message' => 'Change successful!']);
    }

    /**
     * function get list assistant by EmployerId
     */
   	public function ngGetAssistantByEmpId($empId) {
        $arrWheres = [
            'emp_id' => $empId,
            '$or' => [
                [
                    'status' => [
                        '$in' => config('constant.statusAssistant')
                    ]
                ]
            ]
        ];

        return Registration::with('user')
                            ->where($arrWheres)
                            ->get();
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
        $employer = $this->getCompanyWithUser('employee');
        return view('employer.basic', compact('employer'));
    }

    /**
     * Get data when load page Basic
     */
    public function ngGetBasic() {
        $employer = $this->getCompanyWithUser('employee');
        $empId = $employer['_id'];
        $cities = $this->getAllCities();
        $skills = $this->getAllSkills();
        $today = Carbon::now()->startOfDay();
        //riêng
        $myPosts = $this->listPostOfUser($empId);
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
                                'emp' => $employer,
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
    public function ngCreatePost(Request $request, $empId) {
        $user_id = Auth::id();
        /*id name alias salary description require treatment quantity user_id emp_id city_id follow* status created_at updated_at date_expired* */
        try {
            $job = new Job();
            // return response()->json(['status' => true, 'message' => $req->job]);
            $arrData = $request->job;
            $id = $this->saveJob($arrData, $empId, $request->skills);
            if ($id) {
                $wheres = [
                    'type' => 'company',
                    'followed_info' => [
                        '_id' => $empId,
                        'deleted' => false
                    ]
                ];
                $arrUser = [];
                $userFollowed = Follows::where($wheres)->get();
                foreach ($userFollowed as $key => $value) {
                    array_push($arrUser, $value['user_id']);
                }
                $user = User::whereIn('_id', $arrUser)->get();
            }
            return response()->json(['status' => true, 'message' => 'Saved post']);
        } catch(Exception $e) {
            return response()->json(['status' => false, 'message' => 'Failed to save this post']);
        }
    }

        /*--------------------------Edit the post---------------------------*/
    public function ngEditPost(Request $request, $empId, $id) {
        $user_id = Auth::user()->id;
        /*id name alias salary description require treatment quantity user_id emp_id city_id follow* status created_at updated_at date_expired* */
        try {
            $arrData = $request->job;
            $this->editJob($arrData, $empId, $request->skills, $id);

            return response()->json(['status' => true, 'message' => 'Saved post']);
        } catch(Exception $e) {
            return response()->json(['status' => false, 'message' => 'Failed to save this post']);
        }
    }

    /**
     * Get post by id
     */
    public function ngGetPost($jobId) {
        $post = Job::findOrFail($jobId);
        //post's skills
        $postSkills = Skills::whereIn('_id', $post['skills_id'])
                                ->get();
        return response()->json(['post' => $post, 'postSkills' => $postSkills]);
    }

    /**
     * Trash and Push posts
     */
    public function ngTrashPost($jobId) {
        try {
            $post = Job::findOrFail($jobId);
            $post->status = 2;
            $post->save();

            return response()->json(['status' => true, 'message' => 'Moved post to trash']);
        } catch(Exception $e) {
            return response()->json(['status' => false, 'message' => 'Failed to delete']);
        }
    }

    public function ngPushPost($jobId) {
        try {
            $post = Job::findOrFail($jobId);
            $post->status = 10;
            $post->save();

            $employer = Employers::where('_id', array_get($post, 'employer_id', ''))->first();
            if (!empty($employer)) {
                // send notify approval to master of company
                foreach ($employer['master'] as $value) {
                    $user = User::findOrFail($value);
                    $user->notify(new PushPost($post));
                }
            }

            return response()->json(['status' => true, 'message' => 'Pushed and waiting to confirm']);
        } catch(Exception $e) {
            return response()->json(['status' => false, 'message' => 'Failed to push']);
        }
    }
        /*--------------Confirm/Deny posts-------------------------*/

    public function ngConfirmPost($jobId) {
        try {
            $post = Job::findOrFail($jobId);
            $employer = Employers::findOrFail($post['employer_id']);
            $curHirring = intval($employer['quantity_job']['hirring']);
            //change status from Pending to Publisher: from 10 to 1
            $post->status = 1;
            $post->save();

            $arrUpdate = [
                'quantity_job' => [
                    'hirring' => $curHirring + 1
                ],
            ];
            Employers::where('_id', $post['employer_id'])->update($arrUpdate);
            $this->sendMailToUserFollow($post['employer_id'], $post);
            //notification to author
            $post->user->notify(new ConfirmPost($post, true, Auth::user()));
            //notification to users has followed (recommend Queue)
            $wheres = [
                'type' => 'company',
                'followed_info' => [
                    '_id' => $employer['_id'],
                    'deleted' => false
                ]
            ];

            $arrUser = [];
            $userFollowed = Follows::select('user_id')->where($wheres)->get();
            foreach ($userFollowed as $key => $value) {
                array_push($arrUser, $value['user_id']);
            }

            $user = User::whereIn('_id', $arrUser)->get();
            foreach($user as $u) {
                $u->notify(new NotifyNewPost($post, $post->employer->name));
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
            $post->user->notify(new ConfirmPost($post, false, Auth::user()));

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
        dispatch(new \App\Jobs\MailInterview($request->contentemail, $request->email));
        Session::flash('flash_message', 'Send email successfully!');

        return redirect()->back();
    }

    public function ngRestorePost(Request $request) {
        $job = Job::where('_id', $request->jobId)->first();
        if (empty($job)) {
            return response()->json([ 'status' => false, 'message' => 'Can not found job']);
        }

        $job->status = 10;
        $job->save();

        return response()->json([ 'status' => true, 'message' => 'Restore job successfully']);
    }
}
