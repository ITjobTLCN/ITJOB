<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cities;
use App\Skills;
use App\Employers;
use App\Jobs;
use App\Skill_job;
use DB;
class JobsController extends Controller
{
    public function getIndex(){

    	return view('layouts.alljobs');
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
                                            <a href="" class="job-title" target="_blank">'.$job->name.'</a>
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
       return Response($result);
    }
    public function getSearchJob(Request $req){
        $key=$req->key;
        $output=[];
        $job=DB::table('skill_job')->join('jobs','skill_job.job_id','=','jobs.id')
                                ->join('skills','skill_job.skill_id','=','skills.id')
                                ->where('jobs.name','like','%'.$key.'%')
                                ->orWhere('skills.name','like','%'.$key.'%')
                                ->select('jobs.id','jobs.name','skills.name')->get();
        return $job;
    }
    public function getListJobLastest(){
        $i=0;
        $output=[];
        $result=DB::table('jobs')->join('cities','jobs.city_id','=','cities.id')
                                ->join('employers','jobs.employer_id','=','employers.id')
                                ->select('jobs.*','cities.name as cn','employers.name as en')
                                ->get();
        // foreach ($result as $key => $rs) {
        //     $skills[$i]=DB::table('skills')->join('skill_job','skills.id','=','skill_job.skill_id')->where('skill_job.job_id',$rs->id)->select('skills.name','skills.id')->get();
        //     $i++;
        // }
        return $result;
    }
    public function getSkillByJobId(Request $req){
        $job_id=$req->job_id;
        // $skills=Skill_job::where('job_id',$job_id)->get();
        $skills=DB::table('skills')->join('skill_job','skills.id','=','skill_job.skill_id')->where('skill_job.job_id',$job_id)->select('skills.name','skills.id')->get();
        return $skills;
    }
}
