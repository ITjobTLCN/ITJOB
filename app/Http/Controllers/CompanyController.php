<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employers;
use App\Job;
use App\Follows;
use App\Reviews;
use App\Skills;
use DB;
use Auth;
use DateTime;
use Session;
use Cache;
use App\Traits\AliasTrait;
use App\Traits\Company\CompanyMethod;
use App\Traits\CommonMethod;

class CompanyController extends Controller
{
    use AliasTrait, CommonMethod, CompanyMethod;

    public function getIndex() {
        $cCompanies = Employers::count();
        $companies = Employers::orderBy('id', 'desc')
                              ->offset(0)
                              ->take(10)
                              ->get();
        return view('layouts.companies', [ 'companies' => $companies,
                                            'cCompanies' => $cCompanies,
                                            'match' => true
                                        ]);
    }
    public function countJobCompany($emp_id) {
        return Job::where('employer_id', $emp_id)->count();
    }

    public function getMoreJob(Request $req) {
        $dem = $req->dem;
        $com_id = $req->com_id;
        $jobs = Job::where('emp_id', $com_id)
                    ->offset($dem)
                    ->take(10)
                    ->get();
        return $dem;
    }
    public function getJobsCompany(Request $req) {
        $output = "";
        $emp_id = $req->emp_id;
        if (Cache::has('job-hirring'.$emp_id)) {
            $output = Cache::get('job-hirring'.$emp_id, '');
        } else {
            $jobs = Job::where('employer_id', $emp_id)
                    ->offset($req->offset)
                    ->take(config('constant.limitJob'))
                    ->get();
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

            Cache::put('job-hirring'.$emp_id, $output, config('constant.cacheTime'));
        }

        return $output;
    }
    public function getDetailsCompanies(Request $req) {
        $company = $this->getEmployerByKey($req->alias);
        if (empty($company) || is_null($company)) {
            return view('layouts.companies', ['match' => false]);
        }

        $skillsId = [];
        foreach ($company['skills'] as $key => $skill) {
            array_push($skillsId, $skill['_id']);
        }
        $skills = Skills::whereIn('_id', $skillsId)->get();
        $follow = [];

        if (Auth::check()) {
            $wheres = [
                    'user_id' => Auth::id(),
                    'followed_info' => [
                        '_id' => $company['_id'],
                        'deleted' => false,
                    ],
                    'type' => 'company'
                ];
            $objFollow = new Follows();
            $follow = $objFollow->where($wheres)->first();
        }
        return view('layouts.details-companies',
               compact('company', 'skills', 'follow'));
    }

    public function getCompaniesReview(Request $req, $offset = null, $limit = null) {
        $offset ? $offset : $offset = 0;
        $limit ? $limit : $limit = config('constant.limitCompany');
        $comHirring = Employers::orderBy('_id', 'desc')
                                ->offset($offset)
                                ->limit($limit)
                                ->get();
        $comFollow = Employers::orderBy('quantity_user_follow', 'desc')
                                ->offset($offset)
                                ->limit($limit)
                                ->get();
        return view('layouts.companies-reviews', compact('comHirring', 'comFollow'));
    }
    //get more companies hirring now
    public function getMoreHirring($offset = 0) {
       return  Employers::orderBy('id', 'desc')
                            ->offset((int)$offset)
                            ->take(config('constant.moreCompany'))
                            ->get();
    }
    //get more companies most followed
    public function getMoreMostFollowed($offset = 0) {
       return  Employers::orderBy('quantity_user_follow', 'desc')
                            ->offset((int)$offset)
                            ->take(config('constant.moreCompany'))
                            ->get();
    }

    public function getMoreCompanies(Request $req) {
        $output = "";
        if ($req->has('cNormal')) {
            $count = $req->cNormal;
            $output = "";
            $employers = Employers::orderBy('id','desc')
                                    ->offset($count)
                                    ->take(10)
                                    ->get();
            if (count($employers) == 0) {
                return $output;
            }
            foreach ($employers as $key => $emp) {
                $skills = $this->getListSkillEmployers($emp->id);
                $numJobs = Job::where('emp_id', $emp->id)->count();
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
        } else {
            $type = $req->type;
            $offset = $req->offset;
            ($type == 'hirring') ? $company = $this->getMoreHirring($offset) : $company = $this->getMoreHirring($offset);
            if (count($company) > 0) {
                foreach ($company as $key => $emp) {
                   $output.= '<div class="col-md-4 col-sm-4 col-lg-4">
                        <a href="companies/'.$emp->alias.'" class="company">
                            <div class="company_banner">
                                <img src="uploads/emp/cover/'.$emp->images['cover'].'" alt="Cover-photo" class="img-responsive image" title="'.$emp->name.'" class="property_img"/>
                            </div>
                            <div class="company_info">
                                <div class="company_header">
                                    <div class="company_logo">
                                        <img src="uploads/emp/logo/'.$emp->images['avatar'].'" alt="avatar-company" title="'.$emp->name.'">
                                    </div>
                                    <div class="company_name">'.$emp->name.'</div>
                                </div>
                                <div class="company_desc">'.$emp->info['description'].'</div>
                                <div class="company_footer">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <span class="company_start_rate">'.$emp->rating.'</span>
                                    <span class="company_city">
                                        Ho Chi Minh
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>';
                }
            }
        }
       return $output;
    }

    public function searchCompany(Request $req) {
        $key = $req->search;
        $output = [];
        if ($key != "") {
            $companies = Employers::where('name', 'like', '%'.$key.'%')
                                    ->get();
            foreach ($companies as $key => $com) {
                $output[] = [ "name" => $com->name ];
            }
        }
        return response()->json($output);
    }

    public function searchCompaniesByName(Request $req) {
        $com_name = $req->q;
        $alias = Employers::where('name', $com_name)->value('alias');
        $match = false;
        empty($alias) ? $match : $match = true;
        if (!empty($alias)) {
            return redirect()->route('getEmployers', $alias);
        } else {
            Session::flash('com_name', $com_name);
            return view('layouts.companies', ['match' => false]);
        }
    }

    public function followCompany(Request $req) {
        $output = "";
        $emp_id = $req->emp_id;
        $arrFollow = $this->findFollow($emp_id, 'company');
        if (!empty($arrFollow) || !is_null($arrFollow)) {
            $deleted = $arrFollow->followed_info['deleted'];
            $countFollow = $this->companyUpdateQuantityFollowed($emp_id, $deleted);
            try {
                $wheres = [
                    'user_id' => Auth::id(),
                    'followed_info._id' => [
                        '$eq' => $emp_id,
                        '$exists' => true
                    ],
                    'type' => 'company'
                ];
                $objFollow = new Follows();
                $objFollow->where($wheres)->update(['followed_info.deleted' => !$deleted]);
            } catch(\Exception $ex){}
            if ($deleted) {
                $output.= '<a class="btn btn-default unfollowed" id="followed">Following<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></a>';
            } else {
                $output.= '<a class="btn btn-default" id="followed">Follow ('.$countFollow.')
                    <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></a>';
            }
        } else {
            try {
                $this->userSaveFollowCompany($emp_id);
                $output.= '<a class="btn btn-default unfollowed" id="followed">Following<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></a>';
            } catch(\Exception $ex) {}
        }
        return $output;
    }

    public function getReviewCompanies($alias) {
        return view('layouts.review', [ 'company' => $this->getEmployerByKey($alias) ]);
    }

    public function postReviewCompanies(Request $req) {
        // $validate = $this->validator($req);
        $data = $req->only([
            'title', 'like', 'unlike', 'rating', 'suggest', 'recommend'
        ]);

        $arrResponse = $this->storeReview($data, $req->emp_id);
        if ($arrResponse->getData()->error) {
            return redirect()->back()
                         ->with('message', $arrResponse->getData()->message);
        }
        return redirect()->back()
                         ->with('message', 'Cảm ơn bài đánh giá của bạn');
    }

    public function seeMoreReviews(Request $req) {
        $output = "";
        $reviews = Reviews::where('emp_id', $req->emp_id)
                          ->offset($req->cReview)
                          ->take(10)
                          ->get();
        foreach ($reviews as $key => $rv) {
            $rating = "";
            for($i = 0; $i < $rv->rating; $i++){
                $rating = "<a href='' ><i class='fa fa-star' aria-hidden='true'></i></a>";
            }
            $output.= "<div class='content-of-review'>
                        <div class='short-summary'>
                            <div class='row'>
                                <div class='col-md-12'>
                                    <h3 class='short-title'>$rv->title</h3>
                                    <div class='stars-and-recommend'>
                                        <span class='rating-stars-box'>$rating</span>";
            if ($rv->recommend == 1) {
                $output.= '<span class="recommend"><i class="fa fa-thumbs-o-up"></i> Recommend</span>';
            }else{
                $output.= '<span class="recommend"><i class="fa fa-thumbs-o-down"></i>UnRecommend</span>';
            }
            $output.= '</div>
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
    public function getListSkillEmployer(Request $req) {
        $listSkillCompany = Employers::select('skills')
                                        ->where('_id', $req->emp_id)
                                        ->first();
        $skills = Skills::whereIn('_id', $listSkillCompany['skills'])->get();
        
        return $skills;
    }
    public function getDemo(Request $req)
    {
        return " ok";
    }
 }
