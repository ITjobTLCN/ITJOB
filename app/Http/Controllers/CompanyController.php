<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employers;
class CompanyController extends Controller
{
    public function getIndex()
    {
        # code...
    }
    public function getDetailsCompanies()
    {
        return view('layouts.details-companies');
    }
    public function getCompaniesReview()
    {
        return view('layouts.companies');
    }
    public function searchCompany(Request $req){
    	$key=$req->key;
    	$output="";
        $companies=Employers::where('name','like','%'.$key.'%')->get();
        $allcompanies=Employers::select('id','name','alias')->take(8)->get();
    	if($key==""){
            foreach ($allcompanies as $key => $com) {
                $output.='<li><a href="companies/'.$com->alias.'">'.$com->name.'</a></li>';
            }
    	}else{
    	   foreach ($companies as $key => $com) {
    			$output.='<li><a href="companies/'.$com->alias.'">'.$com->name.'</a></li>';
    		}
    	}
        return Response($output);
    }
    public function getMoreHirring(Request $req){
       $count=$req->count1;
       $output="";
       $employers=Employers::where('status',1)->orderBy('id','desc')->offset(0)->take(3)->get();
       foreach ($employers as $key => $emp) {
           $output.='<div class="col-md-4">
                <a href="" class="company">
                    <div class="company_banner">
                        <img src="assets/img/property_1.jpg" alt="Cover-photo" class="img-responsive image" title="" class="property_img"/>
                    </div>
                    <div class="company_info">
                        <div class="company_header">
                            <div class="company_logo">
                                <img src="https://itviec.com/system/production/employers/logos/100/fpt-software-logo-65-65.png?1459494092" alt="avatar-company">
                            </div>
                            <div class="company_name">'.$emp->name.'</div>
                        </div>
                        <div class="company_desc">'.$emp->description.'</div>
                        <div class="company_footer">
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <span class="company_start_rate">'.number_format($emp->rating,1).'</span>
                            <span class="company_city">
                                Ho Chi Minh
                            </span>
                        </div>
                    </div>
                </a>
            </div>';
       }
       return $output;
    }
    public function getMoreMostFollowed(Request $req){
       $count=$req->count2;
       $output="";
       $employers=Employers::where('status',1)->orderBy('id','desc')->offset(0)->take(3)->get();
       foreach ($employers as $key => $emp) {
           $output.='<div class="col-md-4">
                <a href="" class="company">
                    <div class="company_banner">
                        <img src="assets/img/property_1.jpg" alt="Cover-photo" class="img-responsive image" title="" class="property_img"/>
                    </div>
                    <div class="company_info">
                        <div class="company_header">
                            <div class="company_logo">
                                <img src="https://itviec.com/system/production/employers/logos/100/fpt-software-logo-65-65.png?1459494092" alt="avatar-company">
                            </div>
                            <div class="company_name">'.$emp->name.'</div>
                        </div>
                        <div class="company_desc">'.$emp->description.'</div>
                        <div class="company_footer">
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <span class="company_start_rate">'.number_format($emp->rating,1).'</span>
                            <span class="company_city">
                                Ho Chi Minh
                            </span>
                        </div>
                    </div>
                </a>
            </div>';
       }
       return $output;
    }
 }
