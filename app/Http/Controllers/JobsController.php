<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cities;
use App\Skills;
use App\Employers;
use App\Jobs;
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
class JobsController extends Controller
{
    public function getIndex(){
        $minutes=60;  
        $listJobLastest = Cache::remember('listJobLastest',5,function(){
            return DB::table('jobs as j')->select('j.*','c.name as cn','e.name as en','e.logo as le')
                                ->join('cities as c','j.city_id','=','c.id')
                                ->join('employers as e','j.emp_id','=','e.id')
                                ->orderBy('j.id','desc')
                                ->offset(0)->take(20)->get();
        });
        $countjob=Jobs::count();
        $cities=Cache::remember('listLocation', $minutes, function() {
            return Cities::all();
        });
    	return view('layouts.alljobs',compact('countjob','listJobLastest','cities'));
    }
    //return to detail-job page
    public function getDetailsJob(Request $req){
        $id = $req->id;
        $jobs = DB::table('employers as e')
                    ->select('a.*','e.name as en','e.alias as el','e.image','e.logo','e.address','e.description as ed','c.name as cn')
                    ->join(DB::raw('(select * from jobs where id ='.$id.') as a'),function($join){
                        $join->on('e.id','=','a.emp_id');
                    })->join('cities as c','a.city_id','=','c.id')->get();
        $relatedJob = Cache::remember('relatedJob', 10, function() use ($id){
            return DB::table('skills as s')
                    ->select('e.name as en','e.address','e.logo','c.name as cn','j.id','j.name','j.alias','j.salary')
                    ->join(DB::raw('(select skill_id from skill_job where job_id='.$id.') as a'),function($join){
                        $join->on('s.id','=','a.skill_id');
                    })->join('skill_job as sj','s.id','sj.skill_id')
                    ->join(DB::raw('(select id,name,alias,salary,emp_id from jobs where id !='.$id.') as j'),function($join){
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
    public function getAttributeFilter(){
    	$locations=Cache::get('listLocation');
        $skills=Cache::get('listSkill');
    	return response()->json(['locations'=>$locations,'skills'=>$skills]);
    }
    //filter job by skills and locations
    public function FilterJob(Request $req){
        $output=array();
        $city_a=array();
        $skill_a=array();
        $result="";
        $info_skill=$req->info_skill;
        $info_city=$req->info_city;
        if(Session::has('city_id')){
           $city_a[]=Session::get('city_id');
        }
        if(Session::has('skill_id')){
            $skill_a[]=Session::get('skill_id');
        }
        if(count($info_city)!=0 || count($info_skill)!=0){
            if(count($info_city)!=0){
                foreach ($info_city as $key => $ifc) {
                    $city_a[]=$ifc;
                } 
            }
            if(count($info_skill)!=0){
                foreach ($info_skill as $key => $ifs) {
                    $skill_a[]=$ifs;
                }
            }
            if(count($city_a)!=0 && count($skill_a)==0){
                 foreach ($city_a as $key => $ca) {
                    $jobs=Jobs::select('id','name','alias','salary','city_id','emp_id','created_at')
                            ->where('city_id',$ca)->get();
                    if(count($jobs)!=0){
                        foreach ($jobs as $key => $jo) {
                            $output[]=$jo;
                        }   
                    }
                }
            }else if(count($city_a)==0 && count($skill_a)!=0){
                foreach ($skill_a as $key => $sa) {
                    $sid=$sa;
                    $jobs=DB::table('jobs as j')
                            ->select('j.id','j.name','j.alias','j.salary','j.city_id','j.emp_id','j.created_at')
                            ->join(DB::raw('(select job_id from skill_job where skill_id='.$sid.') as a'),function($join){
                                $join->on('j.id','=','a.job_id');
                            })->get();
                    if(count($jobs)!=0){
                        foreach ($jobs as $key => $jo) {
                            $output[]=$jo;
                        }   
                    }
                }
            }else{
                foreach ($city_a as $key => $ca) {
                    foreach ($skill_a as $key => $sa) {
                        $jobs=new Jobs();
                        $sid=$sa;
                        $jobs=DB::table('jobs as j')
                                        ->select('j.id','j.name','j.alias','j.salary','j.city_id','j.emp_id','j.created_at')
                                        ->where('city_id',$ca)
                                        ->join(DB::raw('(select job_id from skill_job where skill_id='.$sid.') as a'),function($join){
                                            $join->on('j.id','=','a.job_id');
                                        })->get();
                        if(count($jobs)!=0){
                            foreach ($jobs as $key => $jo) {
                                $output[]=$jo;
                            }   
                        }
                   }
                }
            }
        }else{
             $listJobLastest=Cache::get('listJobSearch', Cache::get('listJobLastest'));
                foreach ($listJobLastest as $key => $tmp) {
                    $output[]=$tmp;
            }
        }
        $uniques=array();
        foreach ($output as $key => $temp) {
            if(!in_array($temp, $uniques)){
                $uniques[]=$temp;
            }
        }
        foreach ($uniques as $key => $job) {
            $location=Cities::where('id',$job->city_id)->value('name');
            $cn=Employers::where('id',$job->emp_id)->first();
            $date=Carbon::parse($job->created_at)->format('d-m-Y');
            $today=date('d-m-Y');
            $skills=DB::table('skills as s')
                        ->select('s.name','s.id')
                        ->join(DB::raw('(select skill_id from skill_job where job_id='.$job->id.') as a'),function($join){
                            $join->on('s.id','=','a.skill_id');
                        })->get();
            $result.='<div class="job-item">
                            <div class="row">
                                <div class="col-xs-12 col-sm-2 col-md-3 col-lg-2">
                                    <div class="logo job-search__logo">
                                        <a href=""><img title="" class="img-responsive" src="assets/img/logo/'.$cn->logo.'" alt="">
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
    public function getSearchJob(Request $req){
        $key =$req->search;
        $output=array();
        if($key!=""){
            $companies=Employers::select('id','name','alias')->where('name','like','%'.$key.'%')->get();
            $skills=Skills::select('id','name','alias')->where('name','like','%'.$key.'%')->get();
            foreach ($skills as $key => $sk) {
                $output[]=array("job_name"=>$sk->name,"job_alias"=>$sk->alias);
            }
            foreach ($companies as $key => $com) {
                $output[]=array("job_name"=>$com->name,"job_alias"=>$com->alias);
            }   
        }else{
            $output[]="";
        }
        return response()->json($output);
    }
    //get list job by location
    public function getListJobBySkill(Request $req){
        $keysearch=$req->alias;
        $skill_id=Skills::where('name',$keysearch)->value('id');
        if($skill_id){
            $listJobLastest=DB::table('jobs as j')
                                ->select('j.*','e.name as en','c.name as cn','e.logo as le')
                                ->join(DB::raw('(Select skill_job.job_id from skill_job where skill_id='.$skill_id.') a'),function($join){
                                    $join->on('j.id','=','a.job_id');})
                                ->join('employers as e','j.emp_id','=','e.id')
                                ->join('cities as c','j.city_id','=','c.id')->get();
            Session::flash('skillname',$keysearch);
            $countjob=count($listJobLastest);
            $cities=$this->getCities();
            Cache::put('listJobSearch', $listJobLastest, 60);
            Session::flash('skill_id',$skill_id);
            return view('layouts.alljobs',compact('countjob','listJobLastest','cities'));
        }

        $aliasEmp = Employers::where('name',$keysearch)->value('alias');
        if(!$aliasEmp){
            return redirect()->route('getEmployers',$keysearch);
        }
        return redirect()->route('getEmployers',$aliasEmp);
    }
    //get list job full option
    public function getListJobSearch(Request $req){
        
        $skill=Skills::where('alias',$req->alias)->first();
        $city=Cities::where('alias',$req->city)->first();   
        if($skill){
            $listJobLastest=DB::table('jobs as j')
                ->select('j.*','e.name as en','c.name as cn','e.logo as le')
                ->join(DB::raw('(Select skill_job.job_id from skill_job where skill_id='.$skill->id.') a'),function($join){
                    $join->on('j.id','=','a.job_id');})
                ->where('j.city_id',$city->id)
                ->join('employers as e','j.emp_id','=','e.id')
                ->join('cities as c','j.city_id','=','c.id')->get();
                Session::flash('skillname', $skill->name);
                Session::flash('city',$city->name);
                Session::flash('skill_id',$skill->id);
                Session::flash('city_id',$city->id);
                $countjob=count($listJobLastest);
                $cities=$this->getCities();
                Cache::put('listJobSearch', $listJobLastest, 60);
                return view('layouts.alljobs',compact('countjob','listJobLastest','cities'));
        }
        return redirect()->route('getEmployers',$req->alias);  
    }
    //redirect to the others route with every edition 
    public function getJobsBySearch(Request $req){
        Cache::forget('listJobSearch');
        $keysearch=$req->keysearch;
        $city=Cities::where('name',$req->nametp)->first();
        if($keysearch==""){
            if(!$city){
                return redirect()->route('alljobs');
            }else{
                return redirect()->route('seachjobByCity',$city->alias);
            }
        }else{
            if(!$city){
                return redirect()->route('seachjob1opt',$keysearch);
            }else{
                $alias = Skills::where('name',$keysearch)->value('alias');
                if(!$alias){
                    $alias = Employers::where('name',$keysearch)->value('alias');
                }
                return redirect()->route('seachjob',[$alias,$city->alias]);
            }
        }       
    }
    //get list job by location
    public function getListJobByCity(Request $req){
        $city=Cities::select('id','name')->where('alias',$req->city)->first();
        $listJobLastest=DB::table('jobs as j')
                            ->select('j.*','e.name as en','a.name as cn','e.logo as le')
                            ->join(DB::raw('(Select id,name from cities where id='.$city->id.') a'),function($join){
                                $join->on('j.city_id','=','a.id');})
                            ->join('employers as e','j.emp_id','=','e.id')
                            ->get();
        $countjob=count($listJobLastest);
        Session::flash('city',$city->name);
        Session::flash('city_id',$city->id);
        $cities=$this->getCities();
        Cache::put('listJobSearch', $listJobLastest, 60);
        return view('layouts.alljobs',compact('countjob','listJobLastest','cities'));
    }
    public function getCities(){
        if(Cache::has('listLocation')){
            $cities=Cache::get('listLocation','none');
        }else{
            $cities=Cities::get();
        }
        return $cities;
    }
    public function followJob(Request $req){
        $job_id=$req->job_id;
        $com_id=$req->com_id;
        $user_id=Auth::user()->id;
        
        $follow=Follow_jobs::where('user_id',$user_id)
                        ->where('job_id',$job_id)->first();
        $job=new Jobs();
        $job=Jobs::find($job_id);
        if($follow){
            $follow=Follow_jobs::where('user_id',$user_id)
                        ->where('job_id',$job_id)->delete();
            $job->follows-=1;
            $job->save();
            return "delete";
        }else{
            $table=new Follow_jobs();
            $table->user_id=$user_id;
            $table->job_id=$job_id;
            $table->created_at=new DateTime();
            $table->save();
            $job->follows+=1;
            $job->save();
            return "add";
        }
    }
    public function getJobFollowed($job_id){
        $follow=Follow_jobs::where('job_id',$job_id)
                        ->where('user_id',Auth::user()->id)
                        ->first();
        if($follow){
            return true;
        }
        return false;
    }
    public function getListSkillJobv($job_id){
        $skills=DB::table('skills as s')
                    ->select('s.name')
                    ->join(DB::raw('(select skill_id from skill_job where job_id='.$job_id.') as a'),function($join){
                        $join->on('s.id','=','a.skill_id');
                    })->get();
        return $skills;
    }
    public function getListSkillJob(Request $req){
        $skills=DB::table('skills as s')
                    ->select('s.id','s.name','s.alias')
                    ->join(DB::raw('(select skill_id from skill_job where job_id='.$req->job_id.') as a'),function($join){
                        $join->on('s.id','=','a.skill_id');
                    })->get();
        $relatedJob=array();
        foreach ($skills as $key => $skill) {
            $relatedJob[]=DB::table('jobs as j')
                            ->select('j.name','e.name as en','c.name as cn','j.salary')
                            ->join(DB::raw('(select job_id from skill_job where skill_id='.$skill->id.') as a'),function($join){
                                $join->on('j.id','=','a.job_id');
                            })->join('employers as e','j.emp_id','=','e.id')
                            ->join('cities as c','j.city_id','=','c.id')->where('j.id','!=',$req->job_id)->offset(0)->take(10)->get();
        }
        return response()->json([$skills,$relatedJob]);
        //return $skills;
    }
    public function getApplyJob(Request $req){
        $job=Jobs::where('id',$req->id)->first();
        $employer=Employers::where('id',$job->emp_id)->value('name');
        $user=new User();
        if(Auth::check()){
            $user=Auth::user();
        }
        return view('layouts.apply',compact('user','job','employer'));
    }
    public function applyJob(Request $req){
        $application=new Applications();
        if(Auth::check()){
            $application->user_id=Auth::id();
        }else{
            $application->user_id=0;
        }
        $temp = Applications::where('user_id',Auth::id())
                                ->where('job_id',$req->job_id)
                                ->first();
        if($temp){
            return redirect()->back()->with(['hasApply'=>'Bạn đã apply công việc này rồi']);
        }
        $application->job_id=$req->job_id;
        $application->name=$req->fullname;
        $application->email=$req->email;
        if($req->hasFile('new_cv')){
            $cv=$req->file('new_cv');
            $filename = $cv->getClientOriginalName();
            $application->cv=$filename;
        }
        $application->note=$req->note;
        $cv->move('uploads/emp/cv/' , $filename);
        dd($cv);
        $application->save();
        return redirect()->back()->with(['success'=>'Nộp CV thành công']);
    }
}
