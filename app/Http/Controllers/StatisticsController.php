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
use Excel;
use Illuminate\Support\Facades\Input;
use DateTime;
use Carbon\Carbon;
use Cache;
use Auth;
use App\Notifications\ConfirmEmployer;
use App\Notifications\SendNotify;
use App\Traits\CommonMethod;

class StatisticsController extends Controller
{
    use CommonMethod;

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
        $fstDayOfMonth =$month->copy()->startOfMonth();
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
             // DB::connection('mongodb' )->enableQueryLog();
            $count = Job::where($arrWhere)->count();
            // dd(DB::connection('mongodb')->getQueryLog());
            return $count;
        }
        return 0;
    }
}
