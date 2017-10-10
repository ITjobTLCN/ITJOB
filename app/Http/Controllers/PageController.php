<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;
use App\Cities;
use App\Skills;
use Auth;
class PageController extends Controller
{
	public function getIndex()
	{
		return view('layouts.trangchu');
	}
    public function getContact()
    {
    	return view('layouts.contact');
    }
    public function getListCity()
    {
        $table=Cities::get();
        return $table;
    }
    public function getAllSkills()
    {
        $skills=Skills::get();
        return $skills;
    }
}
