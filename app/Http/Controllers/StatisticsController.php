<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Applications;
use App\User;
use DB;
use App\Roles;
use App\Skills;
use App\Cities;
use Validator;
use App\Job;
use App\Employers;
use App\Registration;
use App\Access_log;
use App\Statistic_by_day;
use App\Statistic_by_month;
use Excel;
use Illuminate\Support\Facades\Input;
use DateTime;
use Carbon\Carbon;
use Cache;
use Auth;
use App\Notifications\ConfirmEmployer;
use App\Notifications\SendNotify;
use App\Traits\CommonMethod;
use App\Traits\User\UserMethod;

class StatisticsController extends Controller
{
    use UserMethod, CommonMethod;

    /**
     * Load view
     */
    public function loadStatistics() {
        return view('admin.statistics');
    }

    /**
     * THống kê số lượng Applications theo ngày (7 ngày) , hoặc 12 tháng
     */
    public function statisticApplication(Request $request) {
        // Validate
        // Get request
        $data = array();
        $type = $request->type;
        $today =   Carbon::today();


        if(!isset($request->day)){
            $today = Carbon::today();
        } else {
            $today = Carbon::create($request->year, $request->month, $request->day, 0);
        }

        $arrLabel = array();
        $arrData = array();

        switch($type){
            case config('constant.WEEK'):
                $i = 7;
                while ($i > 0) {
                    $dayOfWeek = $today->copy()->subDays($i);
                    array_push($arrLabel, $dayOfWeek->day.'/'.$dayOfWeek->month);
                    array_push($arrData, $this->_count_application_a_day($dayOfWeek->copy()));
                    $i--;
                }
                break;
            case config('constant.YEAR'):
                $i = 7;
                while ($i > 0) {
                    $dayOfWeek = $today->copy()->subMonths($i);
                    array_push($arrLabel, $dayOfWeek->month);
                    array_push($arrData, $this->_count_application_a_month($dayOfWeek->copy()));
                    $i--;
                }

                break;
            default:
                break;
        }
        $data['data'] = $arrData;
        $data['labels'] = $arrLabel;
        return response()->json($data);

    }

    /**
     * THống kê số lượng Applications theo ngày (7 ngày) , hoặc 12 tháng
     */
    public function statisticJob(Request $request) {
        // Validate
        // Get request
        $data = array();
        $type = $request->type;
        $today =   Carbon::today();


        if(!isset($request->day)){
            $today = Carbon::today();
        } else {
            $today = Carbon::create($request->year, $request->month, $request->day, 0);
        }

        $arrLabel = array();
        $arrData = array();

        switch($type){
            case config('constant.WEEK'):
                $i = 7;
                while ($i > 0) {
                    $dayOfWeek = $today->copy()->subDays($i);
                    array_push($arrLabel, $dayOfWeek->day.'/'.$dayOfWeek->month);
                    array_push($arrData, $this->_count_job_a_day($dayOfWeek->copy()));
                    $i--;
                }
                break;
            case config('constant.YEAR'):
                $i = 7;
                while ($i > 0) {
                    $dayOfWeek = $today->copy()->subMonths($i);
                    array_push($arrLabel, $dayOfWeek->month);
                    array_push($arrData, $this->_count_job_a_month($dayOfWeek->copy()));
                    $i--;
                }
                break;
            default:
                break;
        }
        $data['data'] = $arrData;
        $data['labels'] = $arrLabel;
        return response()->json($data);
    }

     /**
     * Statistical for daily active user
     * @param Request $request request from client
     * @return json
     */
    public function statisticUser(Request $request) {
        // Validate
        // Get request
        $data = array();
        $type = $request->type;
        $today =   Carbon::today();


        if(isset($request->day)){
            $today = Carbon::create($request->year, $request->month, $request->day, 0);
        }

        $arrLabel = array();
        $arrData = array();

        switch($type){
            case config('constant.WEEK'):
                $i = 7;
                while ($i > 0) {
                    $dayOfWeek = $today->copy()->subDays($i);
                    array_push($arrLabel, $dayOfWeek->day.'/'.$dayOfWeek->month);
                    array_push($arrData, $this->_count_active_user_day($dayOfWeek->copy()));
                    // Update current user by day
                    $this->update_active_user($dayOfWeek->copy());
                    $i--;
                }
                break;
            case config('constant.YEAR'):
                $i = 7;
                while ($i > 0) {
                    $dayOfWeek = $today->copy()->subMonths($i);
                    array_push($arrLabel, $dayOfWeek->month);
                    array_push($arrData, $this->_count_active_user_month($dayOfWeek->copy()));
                    // Update current user by month
                    $this->update_active_user_month($dayOfWeek->copy());
                    $i--;
                }

                break;
            default:
                break;
        }
        $data['data'] = $arrData;
        $data['labels'] = $arrLabel;
        return response()->json($data);

    }


    /**
     * Common function
     */
    // Count application a day
    private function _count_application_a_day($today) {
        if ($today) {
            $arrWhere = [
                'deleted' => false,
                'created_at' => [
                    '$gte'  => $today,
                    '$lt' => $today->copy()->addDay()
                ],
            ];
             // DB::connection('mongodb' )->enableQueryLog();
            $count = Applications::where($arrWhere)->count();
            // dd(DB::connection('mongodb')->getQueryLog());
            return $count;
        }
        return 0;
    }
    // Count application a month
    private function _count_application_a_month($month) {
        $fstDayOfMonth = $month->copy()->startOfMonth();
        $lstDayOfMonth = $month->copy()->endOfMonth();
        if ($month) {
            $arrWhere = [
                'deleted' => false,
                'created_at' => [
                    '$gte'  => $fstDayOfMonth,
                    '$lte' => $lstDayOfMonth
                ],
            ];
             // DB::connection('mongodb' )->enableQueryLog();
            $count = Applications::where($arrWhere)->count();
            // dd(DB::connection('mongodb')->getQueryLog());
            return $count;
        }
        return 0;
    }
    // Count job posted a day
    private function _count_job_a_day($today) {
        if ($today) {
            $arrWhere = [
                'status' => 1,
                'created_at' => [
                    '$gte'  => $today,
                    '$lt' => $today->copy()->addDay()
                ],
            ];
             // DB::connection('mongodb' )->enableQueryLog();
            $count = Job::where($arrWhere)->count();
            // dd(DB::connection('mongodb')->getQueryLog());
            return $count;
        }
        return 0;
    }
    // Count job posted a month
    private function _count_job_a_month($month) {
        $fstDayOfMonth =$month->copy()->startOfMonth();
        $lstDayOfMonth = $month->copy()->endOfMonth();
        if ($month) {
            $arrWhere = [
                'status' => 1,
                'created_at' => [
                    '$gte'  => $fstDayOfMonth,
                    '$lte' => $lstDayOfMonth
                ],
            ];
            $count = Job::where($arrWhere)->count();
            return $count;
        }
        return 0;
    }
    // Count active user a day
    private function _count_active_user_day($today) {
        $format_date = date('Y-m-d', strtotime($today));
        if ($format_date) {
            $count = Statistic_by_day::where('date', $format_date)->first();
            if ($count) {
                return $count->num_of_user;
            }
            return 0;
        }
        return 0;
    }
    // Count active user a month
    private function _count_active_user_month($today) {
        $month = date('m', strtotime($today->copy()));
        $year = date('Y', strtotime($today->copy()));
        if ($month && $year) {
            $arrWhere = [
                'month' => $month,
                'year' => $year
            ];
            // DB::connection('mongodb')->enableQueryLog();
            $count = Statistic_by_month::where($arrWhere)->first();
            // dd(DB::connection('mongodb')->getQueryLog());
            if ($count) {
                return $count->num_of_user;
            }
            return 0;
        }
        return 0;
    }

    /**
     * Run batch job update daily active
     * @return void
     */
    public function update_active_user($today) {
        if ($today) {
            $arrQuery = [
                'created_at' => [
                    '$gte'  => $today->copy()->addDay(),
                    '$lt' => $today->copy()->addDay()->addDay()
                ],
            ];

            $format_date = date('Y-m-d', strtotime($today));
            $countUser = Access_log::where($arrQuery)->count();
            // Check exist date in database
            $exist = Statistic_by_day::where('date', $format_date)->first();

            if (!$exist) {
                 // Insert to Database
                $dataInsert = array(
                    'date' => $format_date,
                    'num_of_user' => $countUser
                );
                return $this->insertStatisticByDay($dataInsert);
            } else {
                // Update database
                $dataUpdate = array(
                    'num_of_user' => $countUser
                );
                return $this->updateStatisticByDay($exist->_id, $dataUpdate);
            }
        }
        return false;
    }

    /**
     * Run batch job update monthly active
     * @return void
     */
    public function update_active_user_month($today) {
        if ($today) {
            $fstDayOfMonth = $today->copy()->startOfMonth();
            $lstDayOfMonth = $today->copy()->endOfMonth();
            $month = date('m', strtotime($today->copy()));
            $year = date('Y', strtotime($today->copy()));

            $arrQuery = [
                'created_at' => [
                    '$gte'  => $fstDayOfMonth,
                    '$lt' => $lstDayOfMonth
                ],
            ];
            $arrQuery2 = [
                'month' => $month,
                'year' => $year
            ];

            $countUser = Access_log::where($arrQuery)->count();
            // Check exist date in database
            $exist = Statistic_by_month::where($arrQuery2)->first();

            if (!$exist) {
                 // Insert to Database
                $dataInsert = array(
                    'month' => $month,
                    'year' => $year,
                    'num_of_user' => $countUser
                );
                return $this->insertStatisticByMonth($dataInsert);
            } else {
                // Update database
                $dataUpdate = array(
                    'num_of_user' => $countUser
                );
                return $this->updateStatisticByMonth($exist->_id, $dataUpdate);
            }
        }
        return false;
    }
}
