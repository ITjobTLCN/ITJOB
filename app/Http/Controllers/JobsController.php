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
use App\Libraries\MongoExtent;

class JobsController extends Controller
{
    use CommonMethod, AliasTrait, LatestMethod, JobMethod, ApplyMethod;

    public function getIndex(Request $req, $limit = 20, $offset = 0) {
        $this->clearCacheSearch();
        $listJobLastest = [];
        $req->offset ? $offset = $req->offset : $offset;

        $arrWheres = [
            'status' => 1,
            'city' => config('constant.defaultCity')
        ];
        $listJobLastest = Job::with('employer')->where($arrWheres)
                                                ->orderBy('_id', 'desc')
                                                ->offset($offset)
                                                ->take($limit)
                                                ->get();

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

        $condition = [
            'status' => 1,
            '_id' => [
                '$nin' => [MongoExtent::safeMongoId($job_id)]
            ]
        ];
        $topJobViewer = Cache::remember('topJobViewer', 10, function() use($condition) {
            return Job::with('employer')
                        ->where($condition)
                        ->orderBy('views desc')
                        ->offset(0)
                        ->take(config('constant.limit.company'))
                        ->get();
        });

        return view('layouts.details-job', compact(['job', 'relatedJob', 'topJobViewer']));
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
        $i = 0;
        if (Cache::has('key')) {
            $key = Cache::get('key');
            if (in_array(strtolower($key), config('constant.skills'))) {
                $skill = $this->getSkillByKey($key);
                if(empty($info_skill)) {
                    $info_skill = [];
                }
                array_push($info_skill, $skill->_id);
                $arrWheres['skills_id'] = [
                    '$in' => [$skill->_id]
                ];
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
            $arrWheres['$or'][0]['$and'][]['detail.salary'] = [
                '$gte' => intval($arrSalary[0]),
                '$lt' => intval($arrSalary[1])
            ];
        }

        if (!empty($info_skill)) {
            $arrWheres['$or'][0]['$and'][]['skills_id'] = [
                '$in' => array_unique($info_skill)
            ];
        }
        // return $arrWheres;
        $jobs = $this->indexJob($arrWheres);
        foreach ($jobs as $key => $job) {
            $output[] = $job;
        }

        array_unique($output);
        foreach ($output as $key => $job) {
            $date = Carbon::parse($job->created_at)->format('d-m-Y');
            $today = date('d-m-Y');
            // html
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
                                            <a href="detail-jobs/' . $job->alias . '/' . $job->id . '" class="job-title" target="_blank" title="'. $job->name . '">' . $job->name . '</a>
                                        </h3>
                                        <div class="company">
                                            <span class="job-search__company">' . $job->employer['name'] . ' </span>
                                            <span class="separator">|</span>
                                            <span class="job-search__location"><i class="fa fa-map-marker" aria-hidden="true"></i> ' . $job->city . '</span>
                                        </div>
                                            <div class="company text-clip">';
                                            $result .= '<span class="salary-job">' . ($job->detail['salary'] ?? 0) . ' $ </span><span class="separator"> | </span>';
                                            if ($date == $today) {
                                                $result .= '<span class="">Today</span>';
                                            } else {
                                                $result .= '<span class=""> ' . $date . '</span>';
                                            }
                                            $result .= '</div>
                                        <div class="job__skill">';
                foreach ($this->getListSkillJobv($job->skills_id) as $key => $s) {
                    $result .= '<span>' . $s->name . '</span> ';
                }
                $result .= '</div></div></div>';
                if (!Auth::check() || Auth::user()->role_id == config('constant.roles.candidate')) {
                    if (Auth::check()) {
                        $result .= '<div class="col-xs-12 col-sm-2 col-md-1 col-lg-2">
                        <div class="follow' . $job->_id . '" id="followJob" job_id="'. $job->_id . '" emp_id="' . $job->employer_id . '">';
                        if ($this->getJobFollowed($job->id)) {
                            $result .= '<i class="fa fa-heart" aria-hidden="true" data-toggle="tooltip" title="UnFollow"></i>';
                        }else{
                            $result .= '<i class="fa fa-heart-o" aria-hidden="true" data-toggle="tooltip" title="Follow"></i>';
                        }
                    } else {
                        $result .= '<i class="fa fa-heart-o" aria-hidden="true" id="openLoginModal" title="Login to follow"></i>';
                    }
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

    public function getListJobSearch(Request $request) {
        $this->clearCacheSearch();
        $jobs = $this->indexJob();

        return view('layouts.alljobs', ['countjob' => count($jobs),
                                        'listJobLastest' => $jobs,
                                        'match' => !in_array($request->match, config('constant.urlNotFound'))
                                    ]);
    }

    public function searchJob(Request $req) {
        $this->clearCacheSearch();
        $match = true;
        $key = $req->key;
        $city_alias = $req->cid;
        $listJobLastest = [];

        // $jobs = new Job();
        if (empty($key) && empty($city_alias)) {
             $listJobLastest = $this->indexJob();
        } else {
            if (empty($key)) {
                return redirect()->route('seachJobByCity', $city_alias);
            }
            $emp = $this->getEmployerByKey($key);
            if (!empty($emp)) {
                return redirect()->route('getEmployers', $emp->alias);
            } else {
                $job = $this->getJobByKey($key);
                if (count($job) == 0) {
                    $skill = $this->getSkillByKey($key);
                    if (is_null($skill) || count($skill) == 0) {
                        $match = false;
                    } else {
                        $city = $this->getCityByKey($city_alias);
                        $wheres = [
                            'skills_id' => [
                                '$in' => [$skill->_id]
                            ],
                            'status' => 1
                        ];
                        if (!empty($city)) {
                            $wheres['city'] = $city->name;
                            Cache::put('city', $city->name, 10);
                            Session::flash('city', $city_alias);
                        }
                        $listJobLastest =  Job::where($wheres)->get();

                    }
                    Session::flash('jobname', $key);
                    Cache::put('key', $key, 10);
                } else {
                   return $this->getJobFullOption($key, $city_alias);
                }
            }
        }

        return view('layouts.alljobs', [ 'match' => $match,
                                        'listJobLastest' => $listJobLastest,
                                        'countjob' => count($listJobLastest) ]);
    }

    public function getJobFullOption($key, $cityAlias) {
        $this->clearCacheSearch();
        $jobs = [];
        $match = true;
        $city = $this->getCityByKey($cityAlias);
        if (empty($this->getJobByKey($key)) && empty($city)) {
           $match = false;
        } else {
            $skill = Skills::where('name', $key)->orWhere('alias', $key)->first();

            if (!empty($skill)) {
                $arrWheres['$or'][]['skills_id'] = [
                    '$in' => [$skill['_id']]
                ];
            } else {
                $arrWheres['$or'][] = [
                    '$text' => [
                        '$search' => $key
                    ]
                ];
            }
            $arrWheres['city'] = !empty($city->name) ? $city->name : config('constant.defaultCity');
            $arrWheres['status'] = 1;
            $jobs = Job::with('employer')
                        ->where($arrWheres)
                        ->orderBy('_id', 'desc')
                        ->get();
        }

        Session::flash('jobname', $key);
        Cache::put('key', $key, 10);
        Cache::put('city', !empty($city->name) ? $city->name : config('constant.defaultCity'), 10);

        return view('layouts.alljobs', ['countjob' => count($jobs),
                                        'listJobLastest' => $jobs ?? [],
                                        'match' => $match]);
    }
    //get list job by location
    public function getListJobByCity(Request $req) {
        $this->clearCacheSearch();
        $city = $this->getCityByKey($req->alias);
        $match = true;
        $jobs = new Job();

        if (!empty($city)) {
            $jobs = Job::where('city', $city->name)
                        ->where('status', 1)
                        ->orderBy('_id', 'desc')
                        ->offset(0)
                        ->limit(config('constant.limit.job'))
                        ->get();
        } else {
           $match = false;
        }

        Session::put('city', $city->name);
        Cache::put('city', $city->name, 10);

        return view('layouts.alljobs', ['countjob' => count($jobs),
                                        'listJobLastest' => $jobs,
                                        'match' => $match]);
    }

    public function getQuickJobBySkill(Request $req) {
        $this->clearCacheSearch();
        $match = true;
        $skill = $this->getSkillByKey($req->alias);
        $listJobLastest = [];
        if (empty($skill)) {
            $match = false;
            Session::flash('jobname', $req->alias);
        } else {
            $wheres = [
                'status' => 1,
                'skills_id' => [
                    '$in' => [$skill->_id]
                ]
            ];
            $listJobLastest = Job::where($wheres)
                                    ->offset(0)
                                    ->take(config('constant.limit.job'))
                                    ->get();
            Session::flash('jobname', $skill->name);
        }

        Cache::put('key', Session::get('jobname'), 10);
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
            'job_id', 'fullname', 'email', 'new_cv', 'note', 'cv'
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

    protected function clearCacheSearch() {
        Cache::forget('key');
        Cache::forget('city');
    }
}
