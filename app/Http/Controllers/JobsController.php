<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cities;
use App\Skills;
use App\Employers;
use App\Job;
use App\Reviews;
use App\User;
use App\Follows;
use Session;
use Cache;
use Auth;
use Carbon\Carbon;
use App\Traits\AliasTrait;
use App\Traits\LatestMethod;
use App\Traits\Job\JobMethod;
use App\Traits\User\ApplyMethod;
use App\Traits\CommonMethod;

class JobsController extends Controller
{
    use CommonMethod, AliasTrait, LatestMethod, JobMethod, ApplyMethod;

    public function getIndex(Request $req, $limit = 20, $offset = 0) {
        $listJobLastest = [];
        $req->offset ? $offset = $req->offset : $offset;
        if (Cache::has('listJobLastest')) {
            $listJobLastest = Cache::get('listJobLastest', '');
        } else {
            $arrWheres = [
                'status' => 1,
                'city' => config('constant.defaultCity')
            ];
            $listJobLastest = Job::with('employer')->where($arrWheres)
                                                    ->orderBy('_id', 'desc')
                                                    ->offset($offset)
                                                    ->take($limit)
                                                    ->get();
            Cache::put('listJobLastest', $listJobLastest, config('constant.cacheTime'));
        }

        return view('layouts.alljobs', ['countjob' => count($listJobLastest),
                                        'listJobLastest' => $listJobLastest,
                                        'match' => true
                                    ]);
    }
    //return to detail-job page
    public function getDetailsJob(Request $req) {
        $job_id = $req->_id;
        if (Cache::has('job' . $job_id)) {
            $job = Cache::get('job' . $job_id);
            $relatedJob = Cache::get('relatedJob' . $job_id);
        } else {
            $job = Job::with('employer')
                        ->where('_id', $job_id)
                        ->first();
            $relatedJob = $this->getRelatedJob($job);

            Cache::put('job' . $job_id, $job, config('constant.cacheTime'));
            Cache::put('relatedJob' . $job_id, $relatedJob, config('constant.cacheTime'));
        }

        return view('layouts.details-job', compact(['job', 'relatedJob']));
    }
    //get list skills and locations to filter jobs
    public function getAttributeFilter() {
    	$locations = Cache::get('listLocation');
        $skills = Cache::get('listSkill');
    	return response()->json(['locations' => $locations, 'skills' => $skills]);
    }
    //filter job by skills and salary
    public function filterJob(Request $req) {
        $output = [];
        $result = "";
        $info_skill = $req->info_skill;
        $info_salary = $req->info_salary;
        $key = "";
        $arrWheres = [];
        if (Cache::has('key')) {
            $key = Cache::get('key');
            if (in_array(strtolower($key), config('constant.skills'))) {
                $skill = $this->getSkillByKey($key);
                if(empty($info_skill)) {
                    $info_skill = [];
                }
                array_push($info_skill, $skill->_id);
            } else {
                $arrWheres['$text'] = [
                    '$search' => $key
                ];
            }
        }
        if (Cache::has('city')) {
            $arrWheres['city'] = Cache::get('city');
        } else {
            $arrWheres['city'] = config('constant.defaultCity');
        }
        if (!empty($info_salary)) {
            $arrSalary = explode('-', $info_salary[0]);
            $arrWheres['detail.salary'] = [
                '$gte' => intval($arrSalary[0]),
                '$lt' => intval($arrSalary[1])
            ];
        }

        if (!empty($info_skill)) {
            $arrWheres['skills_id'] = [
                '$in' => array_unique($info_skill)
            ];
        }

        $jobs = $this->indexJob($arrWheres);
        foreach ($jobs as $key => $job) {
            $output[] = $job;
        }

        array_unique($output);
        foreach ($output as $key => $job) {
            $date = Carbon::parse($job->created_at)->format('d-m-Y');
            $today = date('d-m-Y');
            $skills = Skills::whereIn('_id', $job['skills_id'])->get();
            $result  .=  '<div class="job-item">
                            <div class="row">
                                <div class="col-xs-12 col-sm-2 col-md-3 col-lg-2">
                                    <div class="logo job-search__logo">
                                        <a href=""><img title="" class="img-responsive" src="uploads/emp/avatar/'. $job->employer['images']['avatar'] . '" alt="">
                                        </a>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                                    <div class="job-item-info">
                                        <h3 class="bold-red">
                                            <a href="it-job/' . $job->alias . '/' . $job->id . '" class="job-title" target="_blank" title="'. $job->name . '">' . $job->name . '</a>
                                        </h3>
                                        <div class="company">
                                            <span class="job-search__company">' . $job->employer['name'] . ' </span>
                                            <span class="separator">|</span>
                                            <span class="job-search__location"><i class="fa fa-map-marker" aria-hidden="true"></i> ' . $job->city . '</span>
                                        </div>
                                            <div class="company text-clip">';
                                            if (Auth::check()){
                                                $result .= '<span class="salary-job"><a href="" data-toggle="modal" data-target="#loginModal">' . $job->detail['salary'] . ' $</a></span>';
                                            } else {
                                                $result .= '<span class="salary-job"><a href="" data-toggle="modal" data-target="#loginModal">Đăng nhập để  xem lương </a></span>';
                                            }
                                            $result .= '<span class="separator"> | </span>';
                                            if ($date == $today){
                                                $result .= '<span class="">Today</span>';
                                            } else {
                                                $result .= '<span class=""> ' . $date . '</span>';
                                            }
                                            $result .= '</div>
                                        <div class="job__skill">';
                foreach ($this->getListSkillJobv($job->skills_id) as $key => $s) {
                    $result .= '<a href=""><span>' . $s->name . '</span></a>';
                }
                $result .= '</div></div></div><div class="col-xs-12 col-sm-2 col-md-1 col-lg-2">';
                if (Auth::check()) {
                    $result .= '<div class="follow' . $job->_id . '" id="followJob" job_id="'. $job->_id . '" emp_id="' . $job->employer_id . '">';
                    if ($this->getJobFollowed($job->id)) {
                        $result .= '<i class="fa fa-heart" aria-hidden="true" data-toggle="tooltip" title="UnFollow"></i>';
                    }else{
                        $result .= '<i class="fa fa-heart-o" aria-hidden="true" data-toggle="tooltip" title="Follow"></i>';
                    }
                } else {
                    $result .= '<i class="fa fa-heart-o" aria-hidden="true" id="openLoginModal" title="Login to follow"></i>';
                }
                $result .= '</div></div></div></div>';
        }

        return Response([$result, count($output), true]);
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
        if (!empty($key)) {
            $companies = Employers::where($wheres)
                                    ->get();
            $jobs = Job::where($wheres)
                                ->get();
            if (!empty($jobs)) {
                foreach ($jobs as $key => $job) {
                    $output[] = [ 'name' => $job->name ];
                }
            }
            if (!empty($companies)) {
                foreach ($companies as $key => $company) {
                    $output[] = [ 'name' => $company->name ];
                }
            }
        }

        return $output;
    }
    public function getListJobSearch(Request $req) {
        Cache::forget('listJobSearch');
        Session::flush();
        $jobs = $this->indexJob();

        return view('layouts.alljobs', ['countjob' => count($jobs),
                                        'listJobLastest' => $jobs,
                                        'match' => true]);
    }

    public function postListJobSearch(Request $req) {
        Cache::forget('listJobSearch');
        $match = true;
        $key = $req->q;
        $city_alias = $req->calias;

        $jobs = new Job();
        if (empty($key) && empty($city_alias)) {
            $jobs = $this->indexJob();
        } else {
            if (empty($key)) {
                return redirect()->route('seachJobByCity', $city_alias);
            }
            $emp = $this->getEmployerByKey($key);
            if (!empty($emp)) {
                return redirect()->route('getEmployers', $emp->alias);
            } else {
                $job = $this->getJobByKey($key);
                Session::flash('jobname', $key);
                Session::flash('city', $city_alias);
                if (count($job) == 0) {
                    $skill = $this->getSkillByKey($key);
                    if (is_null($skill) || count($skill) == 0) {
                        $match = false;
                    } else {
                        Session::flash('jobname', $key);
                        $jobs =  Job::whereIn('skills_id', [$skill->_id])->get();
                    }
                    $city = $this->getCityByKey($city_alias);
                    Cache::put('city', $city->name, 10);
                    Cache::put('key', $key, 10);
                } else {
                    return redirect()->route('seachJobFullOption', [ $key, $city_alias ]);
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
        if (empty($this->getJobByKey($req->jobAlias)) || empty($city)) {
           $match = false;
        } else {
            $arrWheres = [
                '$text' => [
                    '$search' => $req->jobAlias
                ],
                'city' => $city->name
            ];
            $jobs = Job::where($arrWheres)->get();
        }
        Session::flash('jobname', $req->jobAlias);
        Cache::put('key', $req->jobAlias, 10);
        Cache::put('city', $city->name, 10);
        return view('layouts.alljobs', ['countjob' => count($jobs),
                                        'listJobLastest' => $jobs,
                                        'match' => $match]);
    }
    //get list job by location
    public function getListJobByCity(Request $req) {
        Cache::forget('key');
        $city = $this->getCityByKey($req->alias);
        $match = true;
        $jobs = new Job();

        if (!empty($city)) {
            $jobs = Job::where('city', $city->name)
                        ->offset(0)
                        ->limit(config('constant.limit.job'))
                        ->get();
            Cache::put('listJobSearch', $jobs, config('constant.cacheTime'));
        } else {
           $match = false;
        }
        Session::flash('city', $city->name);
        Cache::put('city', $city->name, 10);
        return view('layouts.alljobs', ['countjob' => count($jobs),
                                        'listJobLastest' => $jobs,
                                        'match' => $match]);
    }
    public function getQuickJobBySkill(Request $req) {
        $match = true;
        $skill = $this->getSkillByKey($req->alias);
        $listJobLastest = new Job();
        if (empty($skill)) {
            $match = false;
            Session::flash('jobname', $req->alias);
        } else {
            $listJobLastest = Job::whereIn('skills_id', [$skill->_id])->get();
            Session::flash('jobname', $skill->name);
        }
        Cache::put('key', Session::get('jobname'), 10);
        Cache::put('listJobSearch', $listJobLastest, config('constant.cacheTime'));
        return view('layouts.alljobs', ['countjob' => count($listJobLastest),
                                        'listJobLastest' => $listJobLastest,
                                        'match' => $match]);
    }
    public function getCities() {
        if (Cache::has('listLocation')) {
            $cities = Cache::get('listLocation','none');
        } else {
            $cities = Cities::get();
        }

        return $cities;
    }
    public function followJob(Request $req) {
        $job_id = $req->job_id;
        $com_id = $req->com_id;
        $user_id = Auth::id();
        $where = [
            'user_id' => $user_id,
            'followed_info._id' => [
                '$eq' => $job_id,
                '$exists' => true
            ]
        ];
        $objFollow = new Follows();
        $follow = $this->findFollow($job_id, 'job');
        if (!empty($follow)) {
            $deleted = $follow['followed_info']['deleted'];
            $this->jobUpdateQuantityFollowed($job_id, $deleted);
            try {
                $objFollow->where($where)->update(['followed_info.deleted' => !$deleted]);
            } catch(\Exception $ex){}
            return response()->json([
                'insert' => $deleted
            ]);
        } else {
            try {
                $this->userSaveFollowJob($user_id, $job_id);
            } catch(\Exception $ex) {}
        }
        return response()->json([
                'insert' => true
            ]);
    }

    public function getJobFollowed($jobId) {
        $wheres = [
            'user_id' => Auth::id(),
            'followed_info' => [
                '_id' => $jobId,
                'deleted' => false
            ],
            'type' => 'job'
        ];
        $follow = Follows::where($wheres)->first();

        return !is_null($follow) || !empty($follow);
    }

    public function getListSkillJobv($skillsId = []) {
        $skills = [];
        if ( !is_array($skillsId) || empty($skillsId)) {
            return $skills;
        }

        $skills = Skills::whereIn('_id', $skillsId)->get();

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
        if (!isset($job) || empty($job)) {
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
        $checkAlreadyApply = $this->checkUserAlreadyApply($req->email, $req->job_id);
        if (!is_null($checkAlreadyApply) && $checkAlreadyApply->getData()->error) {
            return redirect()->back()
                            ->with(['message' => $checkAlreadyApply->getData()->message]);
        }
        $data = $req->only([
            'job_id', 'fullname', 'email', 'new_cv', 'note'
        ]);
        $arrResponse = $this->saveApplication($data);

        return redirect()->back()
                ->with(['message' => $arrResponse->getData()->message]);
    }

    public function getJobsCompany(Request $req) {
        $output = "";
        $emp_id = $req->emp_id;

        $jobs = Job::where('employer_id', $emp_id)
                    ->offset((int)$req->offset)
                    ->limit(config('constant.limit.job'))
                    ->get();

        foreach ($jobs as $key => $job) {
           $output .=  "<div class='job-item'>
                        <div class='job-item-info'>
                            <div class='row'>
                                <div class='col-xs-12 col-sm-10 col-md-10 col-lg-10'>
                                    <h3>
                                        <a href='detai-jobs/$job->alias/$job->_id' class='job-title' target='_blank'>$job->name</a>
                                    </h3>
                                    <ul>
                                        <li><i class='fa fa-calendar' aria-hidden='true'></i>". $job->created_at->format('d-M Y')."</li>
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
