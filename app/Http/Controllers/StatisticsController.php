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
        $data = [];
        $type = $request->type;
        $arrWeek = array();
        $arrData = array();
        switch($type){
            case config('constant.WEEK'):
                $i = 0;

                while ($i < 7) {
                    $today = Carbon::today();
                    $dayOfWeek = $today->subDays($i);
                    array_push($arrWeek, $dayOfWeek->day.'/'.$dayOfWeek->month);
                    array_push($arrData, $this->_count_application_a_day($dayOfWeek->format('Y-m-d')));
                    $i++;
                }
                $data['data'] = $arrData;
                $data['labels'] = $arrWeek;
                break;
            case config('constant.YEAR'):

                break;
            default:
                break;
        }
        return response()->json($data);

    }


    /**
     * Common function
     */
    // Count application a day
    private function _count_application_a_day($day) {
        // check
        if (Carbon::createFromFormat('Y-m-d', $day) !== false) {
            // valid date
            DB::connection( 'mongodb' )->enableQueryLog();
            $count = Applications::where('created_at','<', $day)->count();
            dd(DB::connection('mongodb')->getQueryLog());
            // echo $day;
            return $count;
        }
        return 0;
    }
    // Count application a month
    private function _count_application_a_month($month) {
        // check value
        if (is_int($month) && $month <=12 && $month>0) {
            $data = Applications::whereMonth('created_at', $month)->count();
        }
        return 0;
    }
}
