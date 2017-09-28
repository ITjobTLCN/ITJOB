<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Cities;
class PageController extends Controller
{
	public function getIndex()
	{
		return view('layouts.trangchu');
	}
    public function getCompaniesReview()
    {
    	return view('layouts.companies');
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
}
