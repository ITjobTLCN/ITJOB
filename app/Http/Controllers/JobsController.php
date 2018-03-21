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

class JobsController extends Controller
{
    public function getIndex() {
        $listJobLastest = Cache::remember('listJobLastest', config('constant.cacheTime'), function() {
            return DB::table('job as j')->select('j.*', 'e.name as en','e.logo as le')
                                ->join('employers as e','j.emp_id','=','e.id')
                                ->where('j.status', 1)
                                ->orderBy('j.id','desc')
                                ->offset(0)
                                ->take(20)
                                ->get();
        });

        $countjob = Job::count();
        $cities = Cache::remember('listLocation', config('constant.cacheTime'), function() {
            return Cities::all();
        });

    	return view('layouts.alljobs', compact('countjob', 'listJobLastest', 'cities'));
    }
    //return to detail-job page
    public function getDetailsJob(Request $req) {
        $id = $req->id;
        $jobs = DB::table('employers as e')
                    ->select('a.*','e.name as en','e.alias as el','e.image','e.logo','e.address','e.description as ed','c.name as cn')
                    ->join(DB::raw('(select * from job where id ='.$id.') as a'),function($join){
                        $join->on('e.id','=','a.emp_id');
                    })->join('cities as c','a.city_id','=','c.id')->get();
        $relatedJob = Cache::remember('relatedJob', 10, function() use ($id){
            return DB::table('skills as s')
                    ->select('e.name as en','e.address','e.logo','c.name as cn','j.id','j.name','j.alias','j.salary')
                    ->join(DB::raw('(select skill_id from skill_job where job_id='.$id.') as a'),function($join){
                        $join->on('s.id','=','a.skill_id');
                    })->join('skill_job as sj','s.id','sj.skill_id')
                    ->join(DB::raw('(select id,name,alias,salary,emp_id from job where id !='.$id.') as j'),function($join){
                        $join->on('j.id','=','sj.job_id');
                    })->join('employers as e','j.emp_id','=','e.id')
                    ->join('cities as c','e.city_id','=','c.id')
                    ->offset(0)
                    ->take(8)
                    ->get();
        });
        Session::flash('relatedJob',$relatedJob);
        return view('layouts.details-job',compact('jobs'));
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
        if(count($info_city) !=0 || count($info_skill) != 0) {
            if(count($info_city) !=0) {
                foreach ($info_city as $key => $ifc) {
                    $city_a[] = $ifc;
                } 
            }
            if(count($info_skill) !=0) {
                foreach ($info_skill as $key => $ifs) {
                    $skill_a[] = $ifs;
                }
            }
            if(count($city_a) !=0 && count($skill_a) ==0) {
                 foreach ($city_a as $key => $ca) {
                    $jobs = Job::select('id','name','alias','salary','city_id','emp_id','created_at')
                            ->where('city_id',$ca)
                            ->where('status',1)
                            ->get();
                    if(count($jobs) !=0) {
                        foreach ($jobs as $key => $jo) {
                            $output[] = $jo;
                        }   
                    }
                }
            }else if(count($city_a) == 0 && count($skill_a) !=0) {
                foreach ($skill_a as $key => $sa) {
                    $sid = $sa;
                    $jobs = DB::table('job as j')
                            ->select('j.id','j.name','j.alias','j.salary','j.city_id','j.emp_id','j.created_at')
                            ->join(DB::raw('(select job_id from skill_job where skill_id='.$sid.') as a'),function($join){
                                $join->on('j.id','=','a.job_id');
                            })
                            ->where('j.status',1)
                            ->get();
                    if(count($jobs) !=0) {
                        foreach ($jobs as $key => $jo) {
                            $output[] = $jo;
                        }   
                    }
                }
            } else {
                foreach ($city_a as $key => $ca) {
                    foreach ($skill_a as $key => $sa) {
                        $jobs = new Job();
                        $sid = $sa;
                        $jobs = DB::table('job as j')
                                        ->select('j.id','j.name','j.alias','j.salary','j.city_id','j.emp_id','j.created_at')
                                        ->where('j.city_id', $ca)
                                        ->where('j.status', 1)
                                        ->join(DB::raw('(select job_id from skill_job where skill_id='.$sid.') as a'),function($join){
                                            $join->on('j.id','=','a.job_id');
                                        })->get();
                        if(count($jobs) !=0) {
                            foreach ($jobs as $key => $jo) {
                                $output[] = $jo;
                            }   
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
        if($key != "") {
            $companies = Employers::select('id','name','alias')->where('name','like','%'.$key.'%')->get();
            $jobs = Job::select('id','name','alias')->where('name','like','%'.$key.'%')->get();
            foreach ($jobs as $key => $value) {
                $output[] = array("result_name" => $value->name, "result_alias" => $value->alias);
            }
            foreach ($companies as $key => $value) {
                $output[] = array("result_name" => $value->name, "result_alias" => $value->alias);
            }   
        } else {
            $output[] = "";
        }

        return response()->json($output);
    }
    public function getListJobSearch(Request $req) {
        Cache::forget('listJobSearch');
        $key = $req->q;
        $city_name = $req->cname;
        $city = Cities::where('name', $req->cname)->first();
        
        if(empty($key) && empty($city_name)) {
            $jobs = Job::all();
        } else {
            if(empty($key) && !empty($city_name)) {
                return redirect()->route('seachJobByCity', $city->alias);
            }
            $emp = Employers::where('name', $key)->first();
            if(!empty($emp)) {
                return redirect()->route('getEmployers', $emp->alias);  
            } else {
                $jobs = Job::where('name', $key)->get();
                if(count($jobs) != 0) {
                    if(!empty($city_name)) {
                        $city = Cities::where('name', $city_name)->first();
                        if(!empty($city)) {
                            $jobs = Job::where('name', $key)
                                        ->where('city', $city_name)->get();
                            Cache::put('listJobSearch', $jobs, config('constant.cacheTime'));
                        } else {
                            Session::flash('match', false);
                        }
                    }
                } else {
                    Session::flash('match', false);
                }           
            }
        }
        Session::flash('jobname', $key);
        Session::flash('city', $city_name); 
        return view('layouts.alljobs', ['countjob' => count($jobs),
                                        'listJobLastest' => $jobs]);
    }
    //get list job by location
    public function getListJobByCity(Request $req) {
        $city = Cities::where('alias', $req->alias)->first();
        $jobs = new Job();

        if(!empty($city)) {
            $jobs = Job::where('city', $city->name)->get();
            Cache::put('listJobSearch', $jobs, config('constant.cacheTime'));
        } else {
            Session::flash('match', false);
        }
        Session::flash('city', $city->name);
        return view('layouts.alljobs', ['countjob' => count($jobs),
                                        'listJobLastest' => $jobs]);
    }
    public function getQuickJobBySkill(Request $req) {
        $skill = Skills::where('alias', $req->alias)->first();
        $listJobLastest = DB::table('job as j')
                    ->select('j.*', 'e.name as en', 'e.logo as le')
                    ->join(DB::raw('(Select skill_job.job_id from skill_job where skill_id='.$skill->_id.') a'), function($join){
                        $join->on('j.id', '=', 'a.job_id');
                    })->where('j.status', 1)
                        ->join('employers as e', 'j.emp_id', '=', 'e.id')
                        ->get();
        Session::flash('skillname', $skill->name);
        Cache::put('listJobSearch', $listJobLastest, config('constant.cacheTime'));
        return view('layouts.alljobs', ['countjob' => count($listJobLastest),
                    'listJobLastest' => $listJobLastest,
                    'match' => true]);
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
        $skills = DB::table('skills as s')
                    ->select('s.id','s.name','s.alias')
                    ->join(DB::raw('(select skill_id from skill_job where job_id='.$req->job_id.') as a'),function($join){
                        $join->on('s.id', '=', 'a.skill_id');
                    })->get();
        $relatedJob = [];
        foreach ($skills as $key => $skill) {
            $relatedJob[] = DB::table('job as j')
                            ->select('j.name','e.name as en','c.name as cn','j.salary')
                            ->join(DB::raw('(select job_id from skill_job where skill_id='.$skill->id.') as a'),function($join){
                                $join->on('j.id', '=', 'a.job_id');
                            })->join('employers as e', 'j.emp_id', '=', 'e.id')
                            ->join('cities as c', 'j.city_id', '=', 'c.id')
                            ->where('j.status', 1)
                            ->where('j.id','!=',$req->job_id)
                            ->offset(0)
                            ->take(10)
                            ->get();
        }
        return response()->json([$skills, $relatedJob]);
    }

    public function getApplyJob(Request $req) {
        $job = Job::where('id',$req->id)->first();

        $employer = Employers::where('id',$job->emp_id)->value('name');

        $user=new User();
        if(Auth::check()) {
            $user = Auth::user();
        }
        return view('layouts.apply',compact('user', 'job', 'employer'));
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
        }

        $application->note = $req->note;
        $cv->move('uploads/emp/cv/', $filename);
        $application->save();
        return redirect()->back()
                         ->with(['success' => 'Nộp CV thành công']);
    }
}
