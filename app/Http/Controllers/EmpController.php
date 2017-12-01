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
use Validator;
use Illuminate\Support\Facades\Input;
use File;
class EmpController extends Controller
{
	 /*Function change from name to alias and remove Vietnamese*/
    public function changToAlias($str){
    	$str = strtr(utf8_decode($str), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
        $str =   str_replace('?', '',strtolower($str));
        return  str_replace(' ', '-',strtolower($str));
    }
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
		$myskills = Skill_employer::where('skill_employers.emp_id',$id)->join('skills','skills.id','=','skill_employers.skill_id')->select('skills.*')->get();
		//list city,skills
		$cities = Cities::all();
		$skills = Skills::all();
		return response()->json(['assis'=>$assis,'emp'=>$emp,'myskills'=>$myskills,'city'=>$city,'cities'=>$cities,'skills'=>$skills]);
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

        /*-------Edit Info of Employer---------*/
        /*-------without logo and cover------------*/
        /*------updated: 1-12-2017 has logo and cover----*/
        public function ngGetUpdateEmpInfo(Request $request,$id){
        	/*id name website address alias city_id phone description schedule overtime ListSkills*/
        	try{

        		$emp = Employers::findOrFail($id);
        		$emp->name = $request->emp['name'];
        		$emp->alias = $this->changToAlias($request->emp['name']);
        		$emp->website = $request->emp['website'];
        		$emp->address = $request->emp['address'];
        		$emp->city_id = $request->emp['city_id'];
        		$emp->phone = $request->emp['phone'];
        		$emp->description = $request->emp['description'];
        		$emp->schedule = $request->emp['schedule'];
        		$emp->overtime = $request->emp['overtime'];
        		$emp->save();

        		//xóa các skill cũ -> add lại skill mới
        		Skill_employer::where('emp_id',$id)->delete();
        		if(sizeof($request->skills)>0){
	        		foreach($request->skills as $skill){
	        			$ski = new Skill_employer();
	        			$ski->emp_id=$id;
	        			$ski->skill_id=$skill['id'];
	        			$ski->save();
	        		}
	        	}
        		return response()->json(['status'=>true,'message'=>'Update Successfully']);
        		
        	}catch(Exception $e){
        		return response()->json(['status'=>false,'message'=>'Failed']);
        	}
        }
            	//change logo and cover
	    public function postChangeLogoCoverEmp(Request $request,$empid,$type){//type:1-cover:2-logo
	    	$validator  = Validator::make($request->all(),[
	            'file'=>'max:5000|mimes:jpg,jpeg,bmp,png'
	        ]);
	        if ($validator->fails()) {
	            return redirect()->back()->withErrors('Size of image too large or is not the following type:jpg,jpeg,bmp,png');
	        }
	        // dd($request->all());
	        if(Input::hasfile('file') && $empid && $type) {
	        	try{
		            $file = Input::file('file');
		            //get extension of a image
		            $file_extension= File::extension($file->getClientOriginalName());
		            $employer = Employers::findOrFail($empid);

		            if($type==1){
		            	$filename = "cover_employer_".$empid.".".$file_extension;
			            $file->move('uploads/emp/cover',$filename);
			            $employer->cover=$filename;
		            }else{
		            	if($type==2){
		            		$filename = "logo_employer_".$empid.".".$file_extension;
				            $file->move('uploads/emp/logo',$filename);
				            $employer->logo=$filename;
		            	}
		            }
		            $employer->save();
	        	}catch(\Exception $e){
	        		 return redirect()->back()->withErrors('Error while save!');
	        	}
	        }else{
	            return redirect()->back()->withErrors("File haven't choose!");
	        }
	        return redirect()->back()->with(['message'=>'Change successful!']);
	    }

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

   	/*----------------------END TRANG QUẢN TRỊ----------------------------*/
}
