<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employers;
use App\Jobs;
use App\Follow_companies;
use DB;
use Auth;
use DateTime;
class CompanyController extends Controller
{
    public function getIndex(){
        $companies=Employers::orderBy('id','desc')->offset(0)->take(10)->get();
        return view('layouts.companies',compact('companies'));
    }
    public function getMoreJob(Request $req){
        $dem=$req->dem;
        $com_id=$req->com_id;
        $jobs=Jobs::where('employer_id',$com_id)->offset($dem)->take(10)->get();
        return $dem;
    }
    public function getDetailsCompanies(Request $req){
        $company=Employers::where('alias',$req->alias)->first();
        $jobs=Jobs::where('employer_id',$company['id'])->offset(0)->take(10)->get();
        $skills=DB::table('skill_job as sj')
                    ->select('s.*')->distinct()
                    ->join(DB::raw('(select id from jobs where employer_id='.$company['id'].') as a'),function($join){
                        $join->on('sj.job_id','=','a.id');})
                    ->join('skills as s','sj.skill_id','=','s.id')->get();
        if(Auth::check()){
            $follow=Follow_companies::where('comp_id',$company['id'])
                                        ->where('user_id',Auth::user()->id)
                                        ->first();
            return view('layouts.details-companies',compact('company','skills','jobs','follow'));
        }
        return view('layouts.details-companies',compact('company','skills','jobs')); 
    }
    public function getCompaniesReview(){
        $comHirring=Employers::orderBy('id','desc')->offset(0)->take(6)->get();
        $comFollow=Employers::orderBy('follow','desc')->offset(0)->take(6)->get();
        return view('layouts.companies-reviews',compact('comHirring','comFollow'));
    }
    public function searchCompany(Request $req){
    	$key=$req->search;
        $output=array();
        $companies=Employers::where('name','like','%'.$key.'%')->get();
        if($companies){
        	foreach ($companies as $key => $com) {
                $output[]=array("com_alias"=>$com->alias,"com_name"=>$com->name);
            }
        }else{
            $output[]="";
        }
        return response()->json($output);
    }
    //get more companies hirring now
    public function getMoreHirring(Request $req){
       $count=$req->count1;
       $output="";
       $employers=Employers::where('status',1)->orderBy('id','desc')->offset($count)->take(6)->get();
       foreach ($employers as $key => $emp) {
           $output.='<div class="col-md-4">
                <a href="companies/'.$emp->alias.'" class="company">
                    <div class="company_banner">
                        <img src="assets/img/property_1.jpg" alt="Cover-photo" class="img-responsive image" title="" class="property_img"/>
                    </div>
                    <div class="company_info">
                        <div class="company_header">
                            <div class="company_logo">
                                <img src="https://itviec.com/system/production/employers/logos/100/fpt-software-logo-65-65.png?1459494092" alt="avatar-company">
                            </div>
                            <div class="company_name">'.$emp->name.'</div>
                        </div>
                        <div class="company_desc">'.$emp->description.'</div>
                        <div class="company_footer">
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <span class="company_start_rate">'.number_format($emp->rating,1).'</span>
                            <span class="company_city">
                                Ho Chi Minh
                            </span>
                        </div>
                    </div>
                </a>
            </div>';
       }
       return $output;
    }
    //get more companies most followed
    public function getMoreMostFollowed(Request $req){
       $count=$req->count2;
       $output="";
       $employers=Employers::where('status',1)
                            ->orderBy('follow','desc')
                            ->offset($count)
                            ->take(6)->get();
       foreach ($employers as $key => $emp) {
           $output.='<div class="col-md-4">
                <a href="companies/'.$emp->alias.'" class="company">
                    <div class="company_banner">
                        <img src="assets/img/property_1.jpg" alt="Cover-photo" class="img-responsive image" title="" class="property_img"/>
                    </div>
                    <div class="company_info">
                        <div class="company_header">
                            <div class="company_logo">
                                <img src="https://itviec.com/system/production/employers/logos/100/fpt-software-logo-65-65.png?1459494092" alt="avatar-company">
                            </div>
                            <div class="company_name">'.$emp->name.'</div>
                        </div>
                        <div class="company_desc">'.$emp->description.'</div>
                        <div class="company_footer">
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <span class="company_start_rate">'.number_format($emp->rating,1).'</span>
                            <span class="company_city">
                                Ho Chi Minh
                            </span>
                        </div>
                    </div>
                </a>
            </div>';
       }
       return $output;
    }
    public function searchCompaniesByName(Request $req){
        $com_name=$req->company_name;
        $alias=Employers::where('name',$com_name)->value('alias');
        return redirect()->route('getEmployers',$alias);
    }
    public function followCompany(Request $req){
        $output="";
        $emp_id=$req->emp_id;
        $temp=Follow_companies::where('comp_id',$emp_id)->where('user_id',Auth::user()->id)->first();
        
        $company=Employers::find($emp_id);
        if($temp){
            $curr=$company->follow;
            $company->follow=$curr-1;
            $company->save();
            $temp=Follow_companies::where('comp_id',$emp_id)->where('user_id',Auth::user()->id)->delete();
            $output.="<a class='btn btn-default'>Follow ($company->follow) <i class='fa fa-spinner fa-pulse fa-3x fa-fw'></i></a>";
        }else{
            $curr=$company->follow;
            $company->follow=$curr+1;
            $company->save();
            $temp=new Follow_companies();
            $temp->user_id=Auth::user()->id;
            $temp->comp_id=$emp_id;
            $temp->created_at=new DateTime();
            $temp->save();
            $output.="<a class='btn btn-default' id='unfollowed'>Following <i class='fa fa-spinner fa-pulse fa-3x fa-fw'></i></a>";
        }
        return $output;
    }
    public function hasFollow($value='')
    {
        # code...
    }
 }
