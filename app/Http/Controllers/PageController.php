<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;
use App\Cities;
use App\Skills;
use App\Employers;
use Auth;
use Cache;
class PageController extends Controller
{
	public function getIndex(){
        Cache::forget('listJobSearch');
        $minutes=60;
        if(Cache::has('listLocation')){
            $cities=Cache::get('listLocation');
        }else{
            $cities=Cache::remember('listLocation',$minutes,function(){
                return Cities::all();  
            });
        }
        
		return view('layouts.trangchu',compact('cities'));
	}
    //get page contact
    public function getContact(){
    	return view('layouts.contact');
    }
    public function getAllCities()
    {
        $minutes=60;
        if(Cache::has('listLocation')){
            $locations=Cache::get('listLocation');
        }else{
            $locations=Cache::remember('listLocation',$minutes,function(){
                return Cities::all();  
            });
        }
        return $locations;
    }
    //get all skills
    public function getAllSkills(){
        $minutes=60;
        if(Cache::has('listSkill')){
            $skills=Cache::get('listSkill');
        }else{
            $skills=Cache::remember('listSkill',$minutes,function(){
                return Skills::all();  
            });
        }
        return $skills;
    }
}
