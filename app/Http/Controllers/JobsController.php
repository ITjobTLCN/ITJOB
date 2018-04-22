<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cities;
use App\Skills;
use App\Employers;
use App\Job;
use App\Skill_job;
use App\Follow_jobs;
use App\Reviews;
use App\User;
use App\Applications;
use DB;
use View;
use Session;
use Cache;
use Auth;
use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;
use MongoDB\BSON\UTCDateTime;
use App\Traits\AliasTrait;
use App\Traits\LatestMethod;
class JobsController extends Controller
{
    use AliasTrait, LatestMethod;

    public function getIndex(Request $req, $limit = 20, $offset = 0) {
        $selects = [
            'name', 'alias', 'city', 'employer', 'skills_id', 'expired', 'employer_id'
        ];
        $listJobLastest = [];
        $req->offset ? $offset = $req->offset : $offset;
        if(Cache::has('listJobLastest')) {
            $listJobLastest = Cache::get('listJobLastest', '');
        } else {
            $listJobLastest = Job::with('employer')->select($selects)->where('status', 1)
                                                    ->orderBy('_id', 'desc')
                                                    ->offset($offset)
                                                    ->take($limit)
                                                    ->get();
            Cache::put('listJobLastest', $listJobLastest, config('constant.cacheTime'));
        }
        $countjob = count($listJobLastest);
        $cities = Cache::remember('listLocation', config('constant.cacheTime'), function() {
            return Cities::all();
        });
        return view('layouts.alljobs', ['countjob' => $countjob,
                                        'listJobLastest' => $listJobLastest, 
                                        'cities' => $cities,
                                        'match' => true
                                    ]);
    }
    //return to detail-job page
    public function getDetailsJob(Request $req) {
        $job_id = $req->_id;
        $jobs = Job::with('employer')->where('_id', $job_id)->first();
        $relatedJob = [];
        if(Cache::has('job'.$job_id)) {
            $relatedJob = Cache::get('job'.$job_id);
        } else {
            $relatedJob = Job::with('employer')->where('_id', '!=', $job_id)
                                ->whereIn('skills_id', $jobs->skills_id)
                                ->offset(0)
                                ->take(6)
                                ->get();
            Cache::put('job'.$job_id, $relatedJob, config('constant.cacheTime'));
        }
        return view('layouts.details-job', compact(['jobs', 'relatedJob']));
    }
    //get list skills and locations to filter jobs
    public function getAttributeFilter() {
    	$locations = Cache::get('listLocation');
        $skills = Cache::get('listSkill');
    	return response()->json(['locations' => $locations, 'skills' => $skills]);
    }
    //filter job by skills and locations
    public function FilterJob(Request $req) {
        $output = [];
        $city_a = [];
        $skill_a = [];
        $result = "";
        $info_skill = $req->info_skill;
        $info_city = $req->info_city;
        if(Session::has('city_id')) {
           $city_a[] = Session::get('city_id');
        }
        if(Session::has('skill_id')) {
            $skill_a[] = Session::get('skill_id');
        }
        if(!empty($info_city) || !empty($info_skill)) {
            if(!empty($info_city) && empty($info_skill)) {
                 foreach ($info_city as $key => $value) {
                    $jobs = Job::where('city._id', $value)
                                ->where('status', 1)
                                ->get();
                    if(!empty($jobs)) {
                        foreach ($jobs as $key => $value) {
                            $output[] = $value;
                        }   
                    }
                }
            }elseif(empty($info_city) && !empty($info_skill)) {
                $jobs = Job::whereIn('skill', $info_skill)->get();
                if(!empty($jobs)) {
                    foreach ($jobs as $key => $value) {
                        $output[] = $value;
                    }   
                }
            } else {
                foreach ($info_city as $key => $ca) {
                        $jobs = Job::where('city._id', $ca)->whereIn('skill', $info_skill)->get();
                        // $jobs = DB::table('job as j')
                        //                 ->select('j.id','j.name','j.alias','j.salary','j.city_id','j.emp_id','j.created_at')
                        //                 ->where('j.city_id', $ca)
                        //                 ->where('j.status', 1)
                        //                 ->join(DB::raw('(select job_id from skill_job where skill_id='.$sid.') as a'),function($join){
                        //                     $join->on('j.id','=','a.job_id');
                        //                 })->get();
                        if(!empty($jobs)) {
                            foreach ($jobs as $key => $value) {
                                $output[] = $value;
                            }   
                        }
                   
                }
            }
        } else {
             $listJobLastest = Cache::get('listJobSearch', Cache::get('listJobLastest'));
                foreach ($listJobLastest as $key => $tmp) {
                    $output[] = $tmp;
            }
        }
        $uniques = array();
        foreach ($output as $key => $temp) {
            if(!in_array($temp, $uniques)){
                $uniques[] = $temp;
            }
        }

        foreach ($uniques as $key => $job) {
            $location = Cities::where('id',$job->city_id)->value('name');
            $cn = Employers::where('id',$job->emp_id)->first();
            $date = Carbon::parse($job->created_at)->format('d-m-Y');
            $today = date('d-m-Y');
            $skills = DB::table('skills as s')
                        ->select('s.name','s.id')
                        ->join(DB::raw('(select skill_id from skill_job where job_id='.$job->id.') as a'),function($join){
                            $join->on('s.id','=','a.skill_id');
                        })->get();
            $result.='<div class="job-item">
                            <div class="row">
                                <div class="col-xs-12 col-sm-2 col-md-3 col-lg-2">
                                    <div class="logo job-search__logo">
                                        <a href=""><img title="" class="img-responsive" src="uploads/emp/logo/'.$cn->logo.'" alt="">
                                        </a>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                                    <div class="job-item-info">
                                        <h3 class="bold-red">
                                            <a href="it-job/'.$job->alias.'/'.$job->id.'" class="job-title" target="_blank" title="'.$job->name.'">'.$job->name.'</a>
                                        </h3>
                                        <div class="company">
                                            <span class="job-search__company">'.$cn->name.' </span>
                                            <span class="separator">|</span>
                                            <span class="job-search__location">'.$location.'</span>
                                        </div>
                                            <div class="company text-clip">';
                                            if(Auth::check()){
                                                $result.='<span class="salary-job"><a href="" data-toggle="modal" data-target="#loginModal">'.$job->salary.'</a></span>';
                                            }else{
                                                $result.='<span class="salary-job"><a href="" data-toggle="modal" data-target="#loginModal">Đăng nhập để  xem lương</a></span>';
                                            }
                                            $result.='<span class="separator">|</span>';
                                            if($date == $today){
                                                $result.='<span class="">Today</span>';
                                            }else{
                                                $result.='<span class="">'.$date.'</span>';
                                            }
                                            $result.='</div>
                                        <div class="job__skill">';
                foreach ($skills as $key => $s) {
                    $result.='<a href=""><span>'.$s->name.'</span></a>';
                }
                $result.='</div></div></div><div class="col-xs-12 col-sm-2 col-md-1 col-lg-2">';
                if(Auth::check()){
                    $result.='<div class="follow'.$job->id.'" id="followJob" job_id="'.$job->id.'" emp_id="'.$job->emp_id.'">';
                    if($this->getJobFollowed($job->id)){
                        $result.='<i class="fa fa-heart" aria-hidden="true" data-toggle="tooltip" title="UnFollow"></i>';
                    }else{
                        $result.='<i class="fa fa-heart-o" aria-hidden="true" data-toggle="tooltip" title="Follow"></i>';
                    }
                }else{
                    $result.='<i class="fa fa-heart-o" aria-hidden="true" id="openLoginModal" title="Login to follow"></i>';
                }
                $result.='</div></div></div></div>';
        }
       return Response([$result,count($uniques)]);
    }
    //get name and alias companies or skills to search job
    public function getSearchJob(Request $req) {
        $key = $req->search;
        $output = [];
        $wheres = [
            '$text' => [
                '$search' => $key
            ]
        ];
        if(!empty($key)) {
            $companies = Employers::select('name')
                                    ->where($wheres)
                                    ->get();
            $jobs = Job::select('name')
                                ->where($wheres)
                                ->get();
            if(!empty($jobs)) {
                foreach ($jobs as $key => $job) {
                    $output[] = [ "name" => $job->name ];
                }
            } 
            if(!empty($companies)) {
                foreach ($companies as $key => $company) {
                    $output[] = [ "name" => $company->name ];
                }   
            }
        }
        return $output;
    }
    public function getListJobSearch(Request $req) {
        Cache::forget('listJobSearch');
        $match = true;
        $key = $req->q;
        $city_alias = $req->calias;
        $jobs = new Job();
        if(empty($key) && empty($city_alias)) {
            $jobs = Job::offset(0)->take(10)->get();
        } else {
            if(empty($key)) {
                return redirect()->route('seachJobByCity', $city_alias);
            }
            $emp = $this->getEmployerByKey($key);
            if(!empty($emp)) {
                return redirect()->route('getEmployers', $emp->alias);  
            } else {
                $job = $this->getJobByKey($key);
                Session::flash('jobname', $key);
                if(empty($job)) {
                    $skill = $this->getSkillByKey($key);
                    if(empty($skill)) {
                        $match = false;
                    } else {
                        Session::flash('jobname', $key);
                        $jobs =  Job::whereIn('skills_id', [$skill->_id])->get();
                    }
                } else {
                    return redirect()->route('seachJobFullOption', [ $job->alias, $city_alias ]);
                }
            }         
        }
        return view('layouts.alljobs', ['countjob' => count($jobs),
                                        'listJobLastest' => $jobs,
                                        'match' => $match]);
    }
    public function getJobFullOption(Request $req) {
        $jobs = new Job();
        $match = true;
        $city = $this->getCityByKey($req->cityAlias);
        if(empty($this->getJobByKey($req->jobAlias)) || empty($city)) {
           $match = false;
        } else {
            $jobs = Job::where('alias', $req->jobAlias)
                        ->where('city', $city->name)
                        ->get();
        }
        Session::flash('jobname', Session::get('jobname', ''));
        return view('layouts.alljobs', ['countjob' => count($jobs),
                                        'listJobLastest' => $jobs,
                                        'match' => $match]);
    }
    //get list job by location
    public function getListJobByCity(Request $req) {
        $city = Cities::where('alias', $req->alias)->first();
        $match = true;
        $jobs = new Job();

        if(!empty($city)) {
            $jobs = Job::where('city', $city->name)->get();
            Cache::put('listJobSearch', $jobs, config('constant.cacheTime'));
        } else {
           $match = false;
        }
        Session::flash('city', $city->name);
        return view('layouts.alljobs', ['countjob' => count($jobs),
                                        'listJobLastest' => $jobs,
                                        'match' => $match]);
    }
    public function getQuickJobBySkill(Request $req) {
        $match = true;
        $skill = $this->getSkillByKey($req->alias);
        $listJobLastest = new Job();
        if(empty($skill)) {
            $match = false;
            Session::flash('jobname', $req->alias);
        } else {
            $listJobLastest = Job::whereIn('skills_id', [$skill->_id])->get();
            Session::flash('jobname', $skill->name);            
        }

        Cache::put('listJobSearch', $listJobLastest, config('constant.cacheTime'));
        return view('layouts.alljobs', ['countjob' => count($listJobLastest),
                                        'listJobLastest' => $listJobLastest,
                                        'match' => $match]);
    }
    public function getCities() {
        if(Cache::has('listLocation')) {
            $cities = Cache::get('listLocation','none');
        } else {
            $cities = Cities::get();
        }

        return $cities;
    }
    public function followJob(Request $req) {
        $job_id = $req->job_id;
        $com_id = $req->com_id;
        $user_id = Auth::user()->id;
        
        $follow = Follow_jobs::where('user_id', $user_id)
                                ->where('job_id', $job_id)
                                ->first();
        $job = new Job();
        $job = Job::find($job_id);
        if($follow) {
            $follow = Follow_jobs::where('user_id', $user_id)
                                    ->where('job_id', $job_id)
                                    ->delete();
            $job->follows -= 1;
            $job->save();
            return "delete";
        } else {
            $table = new Follow_jobs();
            $table->user_id = $user_id;
            $table->job_id = $job_id;
            $table->created_at =  new UTCDateTime(round(microtime(true) * 1000));
            $table->updated_at =  new UTCDateTime(round(microtime(true) * 1000));
            $table->save();

            $job->follows + 1;
            $job->save();

            return "add";
        }
    }

    public function getJobFollowed($job_id) {
        $follow = Follow_jobs::where('job_id', $job_id)
                                ->where('user_id', Auth::user()->id)
                                ->first();
        if($follow) {
            return true;
        }

        return false;
    }

    public function getListSkillJobv($job_id) {
        $skills = DB::table('skills as s')
                    ->select('s.name')
                    ->join(DB::raw('(select skill_id from skill_job where job_id='.$job_id.') as a'),function($join){
                        $join->on('s.id', '=', 'a.skill_id');
                    })->get();
        return $skills;
    }

    public function getListSkillJob(Request $req) {
        $listSkillJob = Job::select('skills_id')->where('_id', $req->job_id)->first();
        $skills = Skills::whereIn('_id', $listSkillJob['skills'])->get();
        return $skills;
    }

    public function getApplyJob(Request $req) {
        $job = Job::with('employer')->where('_id', $req->id)
                                    ->first();
        if(!isset($job) || empty($job)) {
            return view('errors.404');
        }
        $employer = $job->employer;

        Auth::check() ?
            $user = Auth::user() 
            : $user = new User();
        $topJob = $this->getTopJobs();
        return view('layouts.apply', compact('user', 'job', 'employer', 'topJob'));
    }

    public function applyJob(Request $req) {
        $application = new Applications();
        Auth::check() ?
            $application->user_id = Auth::id()
            :
            $application->user_id = 0;

        $temp = Applications::where('user_id', Auth::id())
                                ->where('job_id', $req->job_id)
                                ->first();
        if($temp) {
            return redirect()->back()
                             ->with(['hasApply' => 'Bạn đã apply công việc này rồi']);
        }

        $application->job_id = $req->job_id;
        $application->name = $req->fullname;
        $application->email = $req->email;

        if($req->hasFile('new_cv')) {
            $cv = $req->file('new_cv');
            $filename = $cv->getClientOriginalName();
            $application->cv = $filename;
            $cv->move('uploads/emp/cv/', $filename);
        }

        $application->note = $req->note;
        
        $application->save();
        return redirect()->back()
                         ->with(['success' => 'Nộp CV thành công']);
    }

    public function getJobsCompany(Request $req) {
        $output = "";
        $emp_id = $req->emp_id;

        $jobs = Job::where('employer_id', $emp_id)
                    ->offset((int)$req->offset)
                    ->limit(config('constant.limitJob'))
                    ->get();
        return $jobs;
        foreach ($jobs as $key => $job) {
           $output.= "<div class='job-item'>
                        <div class='job-item-info'>
                            <div class='row'>
                                <div class='col-xs-12 col-sm-10 col-md-10 col-lg-10'>
                                    <h3>
                                        <a href='detai-jobs/$job->alias/$job->_id' class='job-title' target='_blank'>$job->name</a>
                                    </h3>
                                    <ul>
                                        <li><i class='fa fa-calendar' aria-hidden='true'></i>".$job->created_at->format('d-M Y')."</li>
                                        <li><a href='' class='salary-job'><i class='fa fa-money' aria-hidden='true'></i> Login to see salary</a></li>
                                        <li></li>
                                    </ul>
                                    <div class='company text-clip'>
                                    </div>
                                </div>
                                <div class='hidden-xs col-sm-2 col-md-2 col-lg-2 view-detail'>
                                    <a href='detai-jobs/$job->alias/$job->_id' target=_blank>Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>";
        }

        return $output;
    }
}
