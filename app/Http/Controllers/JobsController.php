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
use DB;
use View;
use Session;
use Cache;
use Auth;
use DateTime;
class JobsController extends Controller
{
    public function getIndex(){
        $minutes = 60;//Thời gian hết hạn
        $listJobLastest = Cache::remember('listJobLastest',$minutes,function(){
            return DB::table('jobs as j')->select('j.*','c.name as cn','e.name as en')
                                ->join('cities as c','j.city_id','=','c.id')
                                ->join('employers as e','j.emp_id','=','e.id')
                                ->orderBy('j.id','desc')
                                ->offset(0)->take(20)->get();
        });
        $countjob=Cache::remember('countjob',$minutes,function(){
            return Jobs::count();
        });

        $cities=Cache::remember('listLocation', $minutes, function() {
            return Cities::all();
        });

    	return view('layouts.alljobs',compact('countjob','listJobLastest','cities'));
    }
    //return to detail-job page
    public function getDetailsJob(Request $req){
        $jobs=DB::table('employers as e')
                    ->select('a.*','e.name as en','e.alias as el','e.image','e.address','e.description as ed')
                    ->join(DB::raw('(select * from jobs where id ='.$req->id.') as a'),function($join){
                        $join->on('e.id','=','a.emp_id');
                    })->get();
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
        $result="";
        $info_skill=$req->info_skill;
        $info_city=$req->info_city;

        if(count($info_city)!=0){

            foreach ($info_city as $key => $ifc) {
                $job=Jobs::select('id','name','alias','description','city_id','emp_id')->where('city_id',$ifc)->get();
                if(count($job)!=0){
                    foreach ($job as $key => $jo) {
                        $output[]=$jo;
                    }   
                }
            }
        }else if(count($info_skill) !=0){
            foreach ($info_skill as $key => $ifs) {
                $job=DB::table('jobs as j')
                        ->select('j.*')
                        ->join(DB::raw('(Select job_id from skill_job where skill_id='.$ifs.') a'),function($join){
                                            $join->on('j.id','=','a.job_id');
                                        })->get();
                if(count($job)!=0){
                    foreach ($job as $key => $jo) {
                       $output[]=$jo;
                    }
                }
            }
        }else{
            $listJobLastest=Cache::get('listJobSearch', Cache::get('listJobLastest'));
            foreach ($listJobLastest as $key => $tmp) {
                $output[]=$tmp;
            }
        }
        foreach ($output as $key => $job) {
            $location=Cities::where('id',$job->city_id)->value('name');
            $companies=Employers::where('id',$job->emp_id)->value('name');
            $skills=DB::table('skills')->join('skill_job','skills.id','=','skill_job.skill_id')->where('skill_job.job_id',$job->id)->select('skills.name','skills.id')->get();
            $result.='<div class="job-item">
                            <div class="row">
                                <div class="col-xs-3 col-sm-2 col-md-2 col-lg-2">
                                    <div class="logo job-search__logo">
                                        <a href=""><img title="" class="img-responsive" src="assets/img/logo-search-job.jpg" alt="">
                                        </a>
                                    </div>
                                </div>
                                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                                    <div class="job-item-info">
                                        <h3 class="bold-red">
                                            <a href="it-job/'.$job->alias.'/'.$job->id.'" class="job-title" target="_blank">'.$job->name.'</a>
                                        </h3>
                                        <div class="company">
                                            <span class="job-search__company">'.$companies.' </span>
                                            <span class="separator">|</span>
                                            <span class="job-search__location">'.$location.'</span>
                                        </div>
                                        <div class="description-job">
                                                <h3>'.$job->description.'</h3>
                                            </div>
                                            <div class="company text-clip">
                                                <span class="salary-job"><a href="" data-toggle="modal" data-target="#loginModal">Đăng nhập để xem lương</a></span>
                                                <span class="separator">|</span>
                                                <span class="">Hôm nay</span>
                                            </div>
                                        <div class="tag-list">';
                foreach ($skills as $key => $skill) {
                    $skill_name=$skill->name; 
                    $result.='<a href="" class="job__skill"><span>'.$skill_name.'</span></a>';
                }
                $result.='</div></div></div><div class="col-xs-1 col-sm-2 col-md-2 col-lg-2">';
                if(Auth::check()){
                    $result.='<div class="follow'.$job->id.'" id="followJob" job_id="'.$job->id.'" emp_id="'.$job->emp_id.'">';
                    if($this->getJobFollowed($job->id)){
                        $result.='<i class="fa fa-heart" aria-hidden="true" data-toggle="tooltip" title="UnFollow"></i>';
                    }else{
                        $result.='<i class="fa fa-heart-o" aria-hidden="true" data-toggle="tooltip" title="Follow"></i>';
                    }
                }else{
                    $result.='<i class="fa fa-heart-o" aria-hidden="true" id="openLoginModal"></i>';
                }
                $result.='</div></div></div></div>';
        }
       return Response([$result,count($output)]);
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
        $name=$req->alias;
        $skill_id=Skills::where('name',$name)->value('id');
        if($skill_id){
            $listJobLastest=DB::table('jobs as j')
                                ->select('j.*','e.name as en','c.name as cn')
                                ->join(DB::raw('(Select skill_job.job_id from skill_job where skill_id='.$skill_id.') a'),function($join){
                                    $join->on('j.id','=','a.job_id');})
                                ->join('employers as e','j.emp_id','=','e.id')
                                ->join('cities as c','j.city_id','=','c.id')->get();
            Session::flash('skillname',$name);
            $countjob=count($listJobLastest);
            $cities=$this->getCities();
            Cache::put('listJobSearch', $listJobLastest, 60);
            return view('layouts.alljobs',compact('countjob','listJobLastest','cities'));
            
        }
        return redirect()->route('getEmployers',$name);
    }
    //get list job full option
    public function getListJobSearch(Request $req){
        $skill_id=Skills::where('name',$req->alias)->value('id');
        $city=Cities::select('id','name')->where('alias',$req->city)->first();
        if($skill_id){
            $listJobLastest=DB::table('jobs as j')
                ->select('j.*','e.name as en','c.name as cn')
                ->join(DB::raw('(Select skill_job.job_id from skill_job where skill_id='.$skill_id.') a'),function($join){
                    $join->on('j.id','=','a.job_id');})
                ->where('j.city_id',$city->id)
                ->join('employers as e','j.emp_id','=','e.id')
                ->join('cities as c','j.city_id','=','c.id')->get();
                Session::flash('skillname',$req->alias);
                Session::flash('city',$city->name);
                $countjob=count($listJobLastest);
                $cities=$this->getCities();
                Cache::put('listJobSearch', $listJobLastest, 60);
                return view('layouts.alljobs',compact('countjob','listJobLastest','cities'));
        }
        return redirect()->route('getEmployers',Employers::where('name',$req->alias)->value('alias'));  
    }
    //redirect to the others route with every edition 
    public function getJobsBySearch(Request $req){
        $keysearch=$req->keysearch;
        $city_id=Cities::where('name',$req->nametp)->value('id');
        $city=Cities::where('id',$city_id)->value('alias');
        if($keysearch==""){
            if($city_id==""){
                return redirect()->route('alljobs');
            }else{
                return redirect()->route('seachjobByCity',$city);
            }
        }else{
            if($city_id==""){
                return redirect()->route('seachjob1opt',$keysearch);
            }else{
                return redirect()->route('seachjob',[$keysearch,$city]);
            }
        }       
    }
    //get list job by location
    public function getListJobByCity(Request $req){
        $city=Cities::select('id','name')->where('alias',$req->city)->first();
        $listJobLastest=DB::table('jobs as j')
                            ->select('j.*','e.name as en','a.name as cn')
                            ->join(DB::raw('(Select id,name from cities where id='.$city->id.') a'),function($join){
                                $join->on('j.city_id','=','a.id');})
                            ->join('employers as e','j.emp_id','=','e.id')
                            ->get();
        $countjob=count($listJobLastest);
        Session::flash('city',$city->name);
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
        if($follow){
            $follow=Follow_jobs::where('user_id',$user_id)
                        ->where('job_id',$job_id)->delete();
            // $follow->delete();
            return "delete";
        }else{
            $table=new Follow_jobs();
            $table->user_id=$user_id;
            $table->job_id=$job_id;
            $table->save();
            $table->created_at=new DateTime();
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
    public function getListSkillJob(Request $req){
        $skills=DB::table('skills as s')
                    ->select('s.id','s.name','s.alias')
                    ->join(DB::raw('(select skill_id from skill_job where job_id='.$req->job_id.') as a'),function($join){
                        $join->on('s.id','=','a.skill_id');
                    })->get();
        return $skills;
    }
}
