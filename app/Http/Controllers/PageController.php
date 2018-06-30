<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Cities;
use App\Skills;
use App\Employers;
use App\Job;
use Auth;
use Cache;
use Mail;
use App\Events\SendMailContact;
use App\Traits\LatestMethod;
use App\Traits\CommonMethod;

class PageController extends Controller
{
    use LatestMethod, CommonMethod;

	public function getIndex() {
        set_time_limit(-1);
        $cities = Cache::remember('listLocation', config('constant.cacheTime'), function() {
            return Cities::all();
        });

        $top_emps = $this->getTopEmployers();
        $top_jobs = $this->getTopJobs();
        $this->getListJobLatest();
        return view('layouts.trangchu', compact('cities',
                                                'top_emps',
                                                'top_jobs'));
	}
    //get page contact
    public function getContact() {
    	return view('layouts.contact');
    }

    public function postContact(Request $request) {
        dispatch(new \App\Jobs\ContactMail($request->email,
                                            $request->name,
                                            $request->subtitle,
                                            $request->content));
        return redirect()->back()->with(['message' => 'Send mail successful']);
    }

    //get all skills
    public function getAllSkills() {
        $skills = Cache::remember('listSkill', config('constant.cacheTime'), function() {
            return Skills::all();
        });

        return $skills;
    }
    // clear all cache
    public function clearAllCache() {
        Cache::flush();

        return "Cache are cleared successful";
    }

    public function viewHelp($fileName) {
        //$fileName = base64_decode($fileName);
        $path = public_path() . '/uploads/emp/cv/' . $fileName;
        if (!file_exists($path)) {
            $path = public_path() . '/uploads/user/cv/' . $fileName;
        }

        return response()->file($path, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'. $fileName .'"'
        ]);
    }
}
