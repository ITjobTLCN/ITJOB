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
class PageController extends Controller
{
	public function getIndex() {
        $minutes=10;
        Cache::has('listLocation') ?
            $cities = Cache::get('listLocation')
            :
            $cities = Cache::remember('listLocation', $minutes, function() {
                return Cities::all();  
            });

        $top_emps = Cache::remember('top_emps', $minutes, function() {
            return Employers::select('_id', 'name', 'alias', 'logo')
                                ->orderBy('rating desc')
                                ->orderBy('follow desc')
                                ->offset(0)
                                ->take(6)
                                ->get();
        }); 
        
        $top_jobs = Cache::remember('top_jobs', $minutes, function(){
            return DB::collection('employers as e')
                        ->select('e.name as em','a._id','a.name','a.alias','e._id as ei')
                        ->join(DB::raw('(select _id, name, alias, emp_id 
                                        from job) as a'), function($join) {
                            $join->on('a.emp_id','=','e._id');
                        })->get();
        });

        return view('layouts.trangchu',compact('cities',
                                                'top_emps',
                                                'top_jobs'));
	}
    //get page contact
    public function getContact() {
    	return view('layouts.contact');
    }

    public function postContact(Request $req) {
        event(new SendMailContact($req->email, 
                                 $req->name, 
                                 $req->subtitle, 
                                 $req->content));
        return redirect()->back();
    }

    public function getAllCities() {
        $minutes=60;
        if(Cache::has('listLocation')) {
            $locations=Cache::get('listLocation');
        } else {
            $locations=Cache::remember('listLocation', $minutes, function(){
                return Cities::all();  
            });
        }
        return $locations;
    }

    //get all skills
    public function getAllSkills() {
        $minutes = 60;

        $skills = Cache::remember('listSkill', $minutes, function(){
            return Skills::all();  
        });

        return $skills;
    }
    
    public function getDemo()
    {
        $abc = Employers::with('jobs')->first();
        $temp = [];
            dd($abc['jobs']);
            $temp[] = Job::find('5a801c36bb8cc222ac0040e9');
        dd($temp);
        //$d = $abc->jobs();
        dd($abc);
    }
}
