<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;
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
    public function getProfile()
    {
        return view('layouts.profile');
    }
    public function editEmail(Request $req)
    {
        $user=new User();
        $user=User::where('id',$req->id)->update(['email'=>$req->newEmail]);
        return "them thanh cong";
    }
    public function editProfile(Request $req)
    {
        $user=new User();
        $user=User::where('id',$req->id)->update(['name'=>$req->name,'describe'=>$req->desc]);
    }
}
