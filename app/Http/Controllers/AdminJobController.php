<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Applications;
use App\User;
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

class AdminJobController extends Controller
{
    use CommonMethod;

    /**
     * Load view function
     */
    //Load list view
    public function loadJobs()  {
        return view('admin.jobs');
    }
    //Load applications view
    public function loadApplications()  {
        return view('admin.applications');
    }
     //Load skills view
    public function loadSkills()  {
        return view('admin.skills');
    }

    /**
     * Function
     *
     * @return json
     */
    // Get method
    public function ngJobs() {
        $data['lists'] = Job::with('employer')->
            orderBy('_id', 'desc')->get();
        return response()->json($data);
    }

    // Get method
    public function ngApplications() {
        $data['lists'] = Applications::with(['job', 'employer'])
            ->orderBy('_id', 'desc')->get();
        return response()->json($data);
    }

    // List skills
    public function ngSkills() {
        $data['skills'] = Skills::orderBy('_id', 'desc')->get();
        return response()->json($data);
    }
    // Add skills
    public function ngAddSkill(Request $request) {
        // Form validation
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);
        // Check validation
        if ($validator->fails()) {
            return response()->json([config('constant.STATUS') => FALSE,
            config('constant.ERROR') => $validator->errors()]);
        }
        try {
            // Create a new skill
            $data = new Skills;
            $data->name = $request->name;
            $data->save();

            return response()->json([config('constant.STATUS') => TRUE,
            config('constant.MESSAGE') => config('constant.CREATE_SUCCESS'),
                config('constant.SKILL') => $data]);
        } catch (Exception $e) {
            return response()->json([config('constant.STATUS') => FALSE,
            config('constant.ERROR') => $e->getMessage()]);
        }
    }
    // Edit skill
    public function ngEditSkill(Request $request) {
        // Form validation
        $validator = Validator::make($request->all(), [
            '_id' => 'required',
            'name' => 'required'
        ]);
        // Check validation
        if ($validator->fails()) {
            return response()->json([config('constant.STATUS') => FALSE,
            config('constant.ERROR') => $validator->errors()]);
        }
        try {
            // Edit
            $data = Skills::find($request->_id);
            $data->name = $request->name;
            $data->updated_at = date('Y-m-d H:i:s');
            $data->save();

            //Get list
            $skills = $this->_get_list_skills();
            return response()->json([config('constant.STATUS') => TRUE,
            config('constant.MESSAGE') => config('constant.EDIT_SUCCESS'),
                config('constant.SKILLS') => $skills]);

        } catch (Exception $e) {
             return response()->json([config('constant.STATUS') => FALSE,
            config('constant.ERROR') => $e->getMessage()]);
        }
    }
    // Delete skill
    public function ngDeleteSkill(Request $request) {
        $validator = Validator::make($request->all(), [
            '_id' => 'required'
        ]);
        // Check validation
        if ($validator->fails()) {
            return response()->json([config('constant.STATUS') => FALSE,
            config('constant.ERROR') => $validator->errors()]);
        }
        try {
            // Delete skill
            $skill = Skills::find($request->_id);
            $skill->delete();

            //Get list new skills
            $skills = $this->_get_list_skills();
            return response()->json([config('constant.STATUS') => TRUE,
            config('constant.MESSAGE') => config('constant.DELETE_SUCCESS'),
                config('constant.SKILLS') => $skills]);

        } catch (Exception $e) {
             return response()->json([config('constant.STATUS') => FALSE,
            config('constant.ERROR') => $e->getMessage()]);
        }
    }

    /**
     * Common Function
     */
    private function _get_list_skills() {
        return Skills::orderBy('_id', 'desc')->get();
    }
    //
}
