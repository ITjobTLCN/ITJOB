<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cities;
use App\Skills;
use App\Employers;
use App\Jobs;
use App\Skill_job;
use DB;
use View;
use Session;
class JobsController extends Controller
{
    public function getIndex(){
        $countjob=Jobs::count();
    	return view('layouts.alljobs',compact('countjob'));
    }
    public function getAttributeFilter(){
    	$locations=Cities::all();
    	$skills = Skills::all();
    	return response()->json(['locations'=>$locations,'skills'=>$skills]);
    }
    public function FilterJob(Request $req){
        $output=[];
        $id=[];
        $j=0;
        $k=0;
        $result="";
        for ($i=0; $i <count($req->info_city) ; $i++) { 
            $job=Jobs::where('city_id',$req->info_city[$i])->get();
            if(count($job)==0){
                continue;
            }
            else{
                for($i=0; $i <count($job) ; $i++){
                    $output[$j]=$job[$i];
                    $j++; 
                }         
            }
        }
        for ($i=0; $i <count($req->info_skill) ; $i++) { 
            $job=DB::table('jobs')->join('skill_job','jobs.id','=','skill_job.job_id')->where('skill_job.skill_id',$req->info_skill[$i])->select('jobs.*')->get();
            if(count($job)==0){
                continue;
            }else{
                for($i=0; $i <count($job) ; $i++){
                    $output[$j]=$job[$i];
                    $j++;
                }
            }
        }
        $collection=collect($output);
        $jobs = $collection->unique('id');
        if(count($jobs)==0){
            $temp=Session::get('listJobLastest');
            foreach ($temp as $key => $tem) {
                $result.='<div class="job-item">
                                <div class="row">
                                    <div class="col-xs-3 col-md-3 col-lg-2">
                                        <div class="logo job-search__logo">
                                            <a href=""><img title="" class="img-responsive" src="assets/img/logo-search-job.jpg" alt="">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-xs-8 col-md-8 col-lg-8">
                                        <div class="job-item-info">
                                            <h3 class="bold-red">
                                                <a href="it-job/'.$tem->alias.'-'.$tem->id.'" class="job-title" target="_blank">'.$tem->name.'</a>
                                            </h3>
                                            <div class="company text-clip">
                                                <span class="job-search__company">'.$tem->en.' </span>
                                                <span class="separator">|</span>
                                                <span class="job-search__location">'.$tem->cn.'</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-1 col-md-1 col-lg-2">
                                        <span data-toggle="tooltip" data-placement="left" title="Follow"><i class="fa fa-heart-o" aria-hidden="true"></i></span>
                                    </div>
                                </div>
                            </div>';

            }
        }else{
            foreach ($jobs as $key => $job) {
                $location=Cities::where('id',$job->city_id)->value('name');
                $companies=Employers::where('id',$job->employer_id)->value('name');
                $skills=DB::table('skills')->join('skill_job','skills.id','=','skill_job.skill_id')->where('skill_job.job_id',$job->id)->select('skills.name','skills.id')->get();
                
                $result.='<div class="job-item">
                                <div class="row">
                                    <div class="col-xs-3 col-md-3 col-lg-2">
                                        <div class="logo job-search__logo">
                                            <a href=""><img title="" class="img-responsive" src="assets/img/logo-search-job.jpg" alt="">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-xs-8 col-md-8 col-lg-8">
                                        <div class="job-item-info">
                                            <h3 class="bold-red">
                                                <a href="it-job/'.$job->alias.'-'.$job->id.'" class="job-title" target="_blank">'.$job->name.'</a>
                                            </h3>
                                            <div class="company text-clip">
                                                <span class="job-search__company">'.$companies.' </span>
                                                <span class="separator">|</span>
                                                <span class="job-search__location">'.$location.'</span>
                                            </div>
                                            <div class="tag-list">';
                    foreach ($skills as $key => $skill) {
                        $skill_name=$skill->name; 
                        $result.='<a href="" class="job__skill"><span>'.$skill_name.'</span></a>';
                    }
                 $result.='</div></div>
                        </div><div class="col-xs-1 col-md-1 col-lg-2">
                            <span data-toggle="tooltip" data-placement="left" title="Follow"><i class="fa fa-heart-o" aria-hidden="true"></i></span>
                        </div>
                    </div>
                </div>';
            }
        }
       return Response($result);
    }
    public function getSearchJob(Request $req){
        $key=$req->key;
        $output="";
        if($key!=""){
            $jobs=Jobs::select('id','name','alias')->where('name','like','%'.$key.'%')->get();
            $companies=Employers::select('id','name','alias')->where('name','like','%'.$key.'%')->get();
            $skills=Skills::select('id','name','alias')->where('name','like','%'.$key.'%')->get();
            if(count($companies)==0){
                foreach ($skills as $key => $sk) {
                    $output.='<li><a href="it-job/search-job/'.$sk->alias.'">'.$sk->name.'</a></li>';
                }
            }else if(count($skills)==0){
                foreach ($companies as $key => $com) {
                    $output.='<li><a href="it-job/search-job/'.$com->alias.'">'.$com->name.'</a></li>';
                }
            }
            else{
                foreach ($companies as $key => $com) {
                    foreach ($skills as $key => $sk) {
                        $output.='<li><a href="it-job/search-job/'.$sk->alias.'">'.$sk->name.'</a></li>';
                    }
                    $output.='<li><a href="it-job/search-job/'.$com->alias.'">'.$com->name.'</a></li>';
                }
            }
        }else{
            
        }
        return $output;
    }
    public function getListJobLastest(){
        $listJobLastest=DB::table('jobs as j')->join('cities as c','j.city_id','=','c.id')
                                ->join('employers as e','j.employer_id','=','e.id')
                                ->orderBy('j.id','desc')
                                ->select('j.*','c.name as cn','e.name as en')
                                ->get();
        Session::put('listJobLastest',$listJobLastest);
        return $listJobLastest;
    }
    public function getSkillByJobId(Request $req){
        $job_id=$req->job_id;
        // $skills=Skill_job::where('job_id',$job_id)->get();
        $skills=DB::table('skills')->join('skill_job','skills.id','=','skill_job.skill_id')->where('skill_job.job_id',$job_id)->select('skills.name','skills.id')->get();
        return $skills;
    }
    public function getListJobSearch(Request $req){
        $alias=$req->alias;

        $listByCompanyName=Employers::where('alias',$alias)->get();
        $skill_id=Skills::where('alias',$alias)->value('id');
        $listBySkillName=DB::table('jobs as j')
                            ->select('j.*','e.name as en','c.name as cn')
                        ->join(DB::raw('(Select skill_job.job_id from skill_job where skill_id='.$skill_id.') a'),function($join){
                                $join->on('j.id','=','a.job_id');
                            })->join('employers as e','j.employer_id','=','e.id')
                                ->join('cities as c','j.city_id','=','c.id')->get();
        if(count($listByCompanyName)==0){
            Session::flash('listBySkillName', $listBySkillName);
            $countjobSkillName=count($listBySkillName).' '.Skills::where('id',$skill_id)->value('name');
            return view('layouts.alljobs',compact('countjobSkillName'));
        }else{
            return view('layouts.details-companies',compact('listByCompanyName'));
        }
    }
    public function getDetailsJob(Request $req){
        $id=$req->id;
        return view('layouts.details-job',compact('id'));
    }
}
