<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Registration;
use Auth;
use App\User;
use App\Employers;
use App\Skills;
use App\Cities;
use App\Skill_employer;
class EmpController extends Controller
{
	//Load trang 
   	public function getIndex(){return view('employer.dashboard');}
   	public function getAdvance(){$empid = Auth::user()->emp_id;
   		return view('employer.advance',compact('empid'));
   	}

   	/*-----------------TRANG QUẢN TRỊ CỦA EMPLOYER--------------------------
	*-----Thêm xóa sửa Assistant--- thong6 qua truy cập bảng Registration---
	*--Chấp nhận hoặc từ chối sự tham gia hỗ trợ đăng bài của thành viên----
   	*------------------Chỉnh sửa thông tin của Employer---------------------
   	*------------------------Route này của master---------------------------*/
	public function ngGetAdvance($id){
		$dataassis = $this->ngGetAssistantByEmpId($id);
		$assis = $dataassis['assis'];
		//info employer
		$emp = Employers::find($id);
		$city = $emp->city;
		//list skill
		$skills = Skill_employer::where('skill_employers.emp_id',$id)->join('skills','skills.id','=','skill_employers.skill_id')->select('skills.*')->get();
		//list city
		$cities = Cities::all();
		return response()->json(['assis'=>$assis,'emp'=>$emp,'skills'=>$skills,'city'=>$city,'cities'=>$cities]);
	}

		/*CONFIRM/DENY pending Employer*/
    public function ngGetConfirmAss($id,$user_id){	//id: employer_id 
        try{
            $user = User::findOrFail($user_id);
            //with assistant
            $regis = Registration::where('emp_id',$id)->where('user_id',$user_id)->first();
            //
            $regis->status = 11;
            $regis->save();
            //
            $user->role_id = 4;
            $user->emp_id = $id;
            $user->save();

            $data = $this->ngGetAssistantByEmpId($id);
            $assis = $data['assis'];
            return response()->json(['status'=>true,'message'=>'Confirm Successfully','assis'=>$assis]);
        }catch(Exception $e){
            return response()->json(['status'=>false,'message'=>'Confirm failed']);
        }
    }
    public function ngGetDenyAss($id,$user_id){
        try{
            //with master
         	$regis = Registration::where('emp_id',$id)->where('user_id',$user_id)->first();
            //
            $regis->status = 12;
            $regis->save();

            $data = $this->ngGetAssistantByEmpId($id);
            $assis = $data['assis'];

            return response()->json(['status'=>true,'message'=>'Deny Successfully','assis'=>$assis]);
        }catch(Exception $e){
            return response()->json(['status'=>false,'message'=>'Deny failed']);
        }
    }
        /*END CONFIRM/DENY pending Employer*/

        /*-----Edit Info of Employer---------*/
        /*-----End Edit Info of Employer-----*/

        /*function get list assistant by EmployerId*/
   	public function ngGetAssistantByEmpId($id){
		$assis = Registration::where('registration.emp_id',$id)->where(function($q){
			$q->orWhere('registration.status',10);
			$q->orWhere('registration.status',11);
			$q->orWhere('registration.status',12);
		})->join('users','users.id','=','registration.user_id')
		->select('users.*','registration.*')->get();	
		// dd($assis);
		return ['assis'=>$assis];
	}
        /*End function get list assistant by EmployerId*/

   	/*----------------------END TRANG QUẢN TRỊ----------------------------*/
}
