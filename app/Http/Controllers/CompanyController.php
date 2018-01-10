<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employers;
use App\Jobs;
use App\Follow_employers;
use App\Reviews;
use DB;
use Auth;
use DateTime;
use Session;
use Cache;
class CompanyController extends Controller
{
    public function getIndex(){
        $cCompanies = Employers::count();
        $companies = Employers::orderBy('id','desc')
                            ->offset(0)
                            ->take(10)
                            ->get();
        
        return view('layouts.companies',compact('companies','cCompanies'));
    }
    public function countJobCompany($emp_id)
    {
        return Jobs::where('emp_id',$emp_id)->count();
    }
    public function getMoreJob(Request $req){
        $dem=$req->dem;
        $com_id=$req->com_id;
        $jobs=Jobs::where('emp_id',$com_id)->offset($dem)->take(10)->get();
        return $dem;
    }
    public function getJobsCompany(Request $req){
        $output="";
        $jobs=Jobs::where('emp_id',$req->emp_id)
                    ->offset($req->dem)
                    ->take(10)
                    ->get();
        foreach ($jobs as $key => $job) {
           $output.='<div class="job-item">
                    <div class="job-item-info">
                        <div class="row">
                            <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
                                <h3>
                                    <a href="" class="job-title" target="_blank">'.$job->name.'</a>
                                </h3>
                                <ul>
                                    <li><i class="fa fa-calendar" aria-hidden="true"></i>'.$job->created_at->format('d-M Y').'</li>
                                    <li><a href="" class="salary-job"><i class="fa fa-money " aria-hidden="true"></i> Login to see salary</a></li>
                                    <li></li>
                                </ul>
                                <div class="company text-clip">
                                </div>
                            </div>
                            <div class="hidden-xs col-sm-2 col-md-2 col-lg-2 view-detail">
                                <a href="" target="_blank">Detail</a>
                            </div>
                        </div>
                    </div>
                </div>';
        }
        return $output;
    }
    public function getDetailsCompanies(Request $req){
        $company=Employers::where('alias',$req->alias)->first();
        if($company==null){
            Session::flash('haveNotCompany',$req->alias);
            return view('layouts.companies');
        }
        $jobs=Jobs::where('emp_id',$company->id)
                    ->count();
    $skills=DB::table('skills as s')
                    ->select('s.name','s.alias')
                    ->join(DB::raw('(select skill_id from skill_employers where emp_id='.$company['id'].') as a'),function($join){
                            $join->on('s.id','=','a.skill_id');
                        })
                    ->get();
        $reviews=Reviews::where('emp_id',$company['id'])
                            ->offset(0)
                            ->take(2)
                            ->get();
        if(Auth::check()){
            $follow=Follow_employers::where('emp_id',$company['id'])
                                        ->where('user_id',Auth::user()->id)
                                        ->first();
            return view('layouts.details-companies',compact('company','skills','jobs','follow','reviews'));
        }
        return view('layouts.details-companies',compact('company','skills','jobs','reviews')); 
    }
    public function getCompaniesReview(){
        $comHirring=DB::table('cities as c')
                        ->select('a.id','a.alias','a.description','a.name','a.rating','a.logo','a.cover','c.name as cn')
                        ->join(DB::raw('(select * from employers order by id desc limit 0,6) as a'),function($join){
                            $join->on('c.id','=','a.city_id');
                        })->get();
        $comFollow=DB::table('cities as c')
                        ->select('a.id','a.alias','a.description','a.name','a.rating','a.logo','a.cover','c.name as cn')
                        ->join(DB::raw('(select * from employers order by follow desc limit 0,6) as a'),function($join){
                            $join->on('c.id','=','a.city_id');
                        })->get();
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
       $count=$req->cHirring;
       $output="";
       $employers=Employers::where('status',1)->orderBy('id','desc')->offset($count)->take(6)->get();
       foreach ($employers as $key => $emp) {
           $output.='<div class="col-md-4">
                <a href="companies/'.$emp->alias.'" class="company">
                    <div class="company_banner">
                        <img src="uploads/emp/cover/'.$emp->cover.'" alt="Cover-photo" class="img-responsive image" title="" class="property_img"/>
                    </div>
                    <div class="company_info">
                        <div class="company_header">
                            <div class="company_logo">
                                <img src="uploads/emp/logo/'.$emp->logo.'" alt="avatar-company">
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
       $count=$req->cMostFollow;
       $output="";
       $employers=Employers::where('status',1)
                            ->orderBy('follow','desc')
                            ->offset($count)
                            ->take(6)
                            ->get();
       foreach ($employers as $key => $emp) {
           $output.='<div class="col-md-4">
                <a href="companies/'.$emp->alias.'" class="company">
                    <div class="company_banner">
                        <img src="uploads/emp/cover/'.$emp->cover.'" alt="Cover-photo" class="img-responsive image" title="'.$emp->name.'" class="property_img"/>
                    </div>
                    <div class="company_info">
                        <div class="company_header">
                            <div class="company_logo">
                                <img src="uploads/emp/logo/'.$emp->logo.'" alt="avatar-company" title="'.$emp->name.'">
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
    public function getMoreCompanies(Request $req){
        $count = $req->cNormal;
        $output = "";
        $employers=Employers::orderBy('id','desc')
                            ->offset($count)
                            ->take(10)
                            ->get();
        if(count($employers) == 0){
            return $output;
        }
        foreach ($employers as $key => $emp) {
            $skills = $this->getListSkillEmployers($emp->id);
            $numJobs = Jobs::where('emp_id',$emp->id)->count();
            $skill = "";
            foreach ($skills as $key => $s) {
                $skill .= "<li class='employer-skills__item'>
                            <a href='' target='_blank'>{$s}</a>
                        </li>";
            }
           $output .= "<div class='row'>
                        <div class='col-xs-3 col-md-3 col-lg-2'>
                            <div class='logo job-search__logo'>
                                <a href=''><img title='{$emp->name}' class='img-responsive' src='uploads/emp/logo/{$emp->logo}' alt=''>
                                </a>
                            </div>
                        </div>
                        <div class='col-xs-9 col-md-9 col-lg-9'>
                            <div class='companies-item-info'>
                                <a href='companies/{$emp->alias}' class='companies-title' target='_blank'>{$emp->name}</a>
                                <div class='company text-clip'>
                                    <span class='job-search__location'>{$emp->address}</span>
                                </div>
                                <div class='description-job'>
                                    <h3>{$emp->description}</h3>
                                </div>
                                <div class='company text-clip'>
                                    <span class='people'><i class='fa fa-users' aria-hidden='true'></i> 100</span>
                                    <span class='website'><i class='fa fa-desktop' aria-hidden='true'></i>{$emp->website}</span>
                                </div>
                                <div id='skills'>
                                    <ul>
                                    {$skill}
                                    </ul>
                                </div>
                                <div class='sum-job'>
                                    <a href='companies/{$emp->alias}' id='job' class='dotted'>{$numJobs} jobs </a><i class='fa fa-caret-down' aria-hidden='true'></i>
                                </div>
                            </div>
                        </div>
                    </div>";
       }
       return $output;
    }
    public function searchCompaniesByName(Request $req){
        $com_name=$req->company_name;
        $alias=Employers::where('name',$com_name)->value('alias');
        if($alias == null){
            return redirect()->route('getEmployers',$com_name);
        }
        return redirect()->route('getEmployers',$alias);
    }
    public function followCompany(Request $req){
        $output="";
        $emp_id=$req->emp_id;
        $temp=Follow_employers::where('emp_id',$emp_id)->where('user_id',Auth::user()->id)->first();
        
        $company=Employers::find($emp_id);
        if($temp){
            $curr=$company->follow;
            $company->follow=$curr-1;
            $company->save();
            $temp=Follow_employers::where('emp_id',$emp_id)->where('user_id',Auth::user()->id)->delete();
            $output.='<a class="btn btn-default">Follow ('.$company->follow.')<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></a>';
        }else{
            $curr=$company->follow;
            $company->follow=$curr+1;
            $company->save();
            $temp=new Follow_employers();
            $temp->user_id=Auth::user()->id;
            $temp->emp_id=$emp_id;
            $temp->created_at=new DateTime();
            $temp->save();
            $output.='<a class="btn btn-default" id="unfollowed">Following <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></a>';
        }
        return $output;
    }
    public function getReviewCompanies($alias){
        $company = Employers::where('alias',$alias)->first();
        return view('layouts.review',compact('company'));
    }
    public function postReviewCompanies(Request $req){
        //get value from form
        $title = $req->title;
        $like = $req->like;
        $unlike = $req->unlike;
        $rating = $req->cStar;
        $suggest = $req->suggest;
        $recommend = $req->recommend;
        $emp_id = $req->emp_id;
        //create a review
        $table = new Reviews();
        $table->rating = $rating;
        $table->title = $title;
        $table->like = $like;
        $table->unlike = $unlike;
        $table->suggests = $suggest;
        $table->user_id = Auth::id();
        $table->emp_id = $emp_id;
        $table->recommend = $recommend;
        $table->save();
        //update rating of company
        Employers::where('id', $req->emp_id)
                   ->update(['rating' => Reviews::where('emp_id', $emp_id)->avg('rating')]);
        return redirect()->back()->with('message', 'Cảm ơn bài đánh giá của bạn');
    }
    public function seeMoreReviews(Request $req){
        $output = "";
        $reviews = Reviews::where('emp_id', $req->emp_id)
                            ->offset($req->cReview)
                            ->take(10)
                            ->get();
        foreach ($reviews as $key => $rv) {
            $rating="";
            for($i = 0; $i < $rv->rating; $i++){
                $rating = "<a href='' ><i class='fa fa-star' aria-hidden='true'></i></a>";
            }
            $output .= "<div class='content-of-review'>
                        <div class='short-summary'>
                            <div class='row'>
                                <div class='col-md-12'>
                                    <h3 class='short-title'>$rv->title</h3>
                                    <div class='stars-and-recommend'>
                                        <span class='rating-stars-box'>$rating</span>";
            if($rv->recommend == 1){
                $output.='<span class="recommend"><i class="fa fa-thumbs-o-up"></i> Recommend</span>';
            }else{
                $output.='<span class="recommend"><i class="fa fa-thumbs-o-down"></i>UnRecommend</span>';
            }
            $output.='</div>
            <div class="date">'.$rv->created_at->format('d-M Y').'</div>
            </div></div></div>
            <div class="details-review">
                <div class="what-you-liked">
                    <h3>Điều tôi thích</h3>
                    <div class="content paragraph">
                        <p>'.$rv->like.'</p>
                    </div>
                </div>
                <div class="feedback">
                    <h3>Đề nghị cải thiện</h3>
                    <div class="content paragraph">
                        <p>'.$rv->suggests.'</p>
                    </div>
                </div>
            </div></div>';                                          
        }
        return $output;
    }
    public function getListSkillEmployer(Request $req){
        $skills=DB::table('skills as s')
                ->select('s.name')
                ->join(DB::raw('(select skill_id from skill_employers where emp_id='.$req->emp_id.') as a')
                    ,function($join){
                        $join->on('s.id','=','a.skill_id');
                })
                ->get();
        return $skills;
    }
    public function getListSkillEmployers($emp_id){
        $skills=DB::table('skills as s')
                ->select('s.name')
                ->join(DB::raw('(select skill_id from skill_employers where emp_id='.$emp_id.') as a')
                    ,function($join){
                        $join->on('s.id','=','a.skill_id');
                })
                ->get();
        return $skills;
    }
 }
