<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\User;
use App\Cities;
use App\Jobs;
use App\Employers;
use App\Skills;
use App\Skill_Job;
use App\Skill_Employer;
use App\Applications;
use App\Register_Employer;
use Excel;
use Illuminate\Support\Facades\Input;
use Validator;
use File;
use Hash;
use Storage;
use DateTime;

class HomeController extends Controller
{
    //remove Vietnamese 
    function stripVN($str) {
        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
        $str = preg_replace("/(đ)/", 'd', $str);

        $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
        $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
        $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
        $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
        $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
        $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
        $str = preg_replace("/(Đ)/", 'D', $str);
        return $str;
    }
    //plugin function
     public function changToAlias($str){
        return  str_replace(' ', '-',strtolower($str));
    }



    
    // index page
    public function getIndex(Request $request){
        //load default data
        $def_city = null;
        $def_city_name = null;
        $def_key = null;
        $q = Jobs::query()->where('jobs.status',1);
            //list cities
        $cities = Cities::take(2)->get(); //get HCM and Ha Noi City to Dropdown
            //list skill
        $skills = Skills::orderBy('rating','desc')->take(5)->get();
            //list skill_job
        $skill_job = Skill_Job::get();

        //request about city and key and (skill)*

        if($request->has('city')){
            //get data from request
            $req_city = $request->get('city');

            //gọi đến hàm get city
            $array = $this->filJobsReqCity($req_city,$q);
            $q=$array['q'];
            $def_city=$array['def_city'];
            $def_city_name=$array['def_city_name'];        
        }
        if($request->has('key')){
            $req_key = $request->get('key');
            //
            $array2 = $this->filJobsReqKey($req_key,$q);
            $q=$array2['q'];
            $def_key = ($array2['def_key']!=null)?$array2['def_key']:$def_key;
        }
        
        //
         // dd($q->get());
        $q->leftjoin('cities','jobs.city_id','=','cities.id')
            ->leftjoin('employers','jobs.emp_id','=','employers.id')
            ->select('jobs.*','cities.name as city_name','employers.logo as emp_logo');
        $jobs = $q->get();

    	return view('home.index',compact('jobs','cities','def_city','def_key','def_city_name','skills','skill_job'));
    }
    // information of A Job
    public function getJob($id){
        //list skill_job
        $skill_job = Skill_Job::get();

        $job = Jobs::findOrFail($id);
        // dd($detail);
    	return view('home.job',compact('job','skill_job'));
    }
    // infomation of Employer
    public function getEmployer($id){
        $employer  = Employers::findOrFail($id);
        $listskills = Skill_Employer::where('emp_id',$employer->id)->get();
        return view('home.employer',compact('employer','listskills')); 
    }

   


    /*Database Import-Export*/
    public function getImport(){
        return view('database.import');
    }
    //Lấy dữ liệu
     public function postImport(){
        try{
            $type = Input::has('type')?Input::get('type'):-1;

            if(Input::hasFile('file')){

                Excel::load(Input::file('file'),function($reader) use ($type){
                    
                    $reader->each(function($sheet) use ($type){

                        switch ($type) {
                            case 1:
                                // dd("Ehllo");
                                User::firstOrCreate($sheet->toArray()); //neu khong có first thì cái gì cũng tạo, còn không thì Không bị trùng mới tạo
                                break;  
                            case 2: 
                                Cities::firstOrCreate($sheet->toArray());
                                break;          
                            case 3: 
                                Jobs::firstOrCreate($sheet->toArray());
                                break;  
                            case 4: 
                                Employers::firstOrCreate($sheet->toArray());
                                break;  
                            case 5: 
                                Skills::firstOrCreate($sheet->toArray());
                                break;      
                            case 6: 
                                Skill_Job::firstOrCreate($sheet->toArray());
                                break;      
                            case 7: 
                                Applications::firstOrCreate($sheet->toArray());
                                break;      
                            default:
                                return redirect()->back()->with(['message'=>'ERRORS']);
                                break;
                        }
                    });
                });
                return redirect()->back()->with(['message'=>'Imported','type'=>$type]);
            }else{
                return redirect()->back()->with(['message'=>'File not found']);
            }
            
        }catch(\Exception $e){
            dd($e);
            return redirect()->back()->with(['message'=>'ERRORS TRY CATCH']);
        }
        
    }
    //xuất bảng dữ liệu
    public function getExport($type){
        $export ='';
        $name = 'Export_Data_';
        switch ($type) {
            case 1:
                $export = User::all();
                $name= $name.'Users';
                break;
            case 2:
                $export = Cities::all();
                $name= $name.'Cities';
                break;
            case 3:
                $export = Jobs::all();
                $name= $name.'Jobs';
                break;
            case 4:
                $export = Employers::all();
                $name= $name.'Employers';
                break;
            case 5:
                $export = Skills::all();
                $name= $name.'Skills';
                break;
            case 6:
                $export = Skill_Job::all();
                $name= $name.'Skill_Job';
                break;
            case 7:
                $export = Applications::all();
                $name= $name.'Applications';
                break;
            default:
                return redirect()->back()->with(['message'=>'ERRORS']);
                break;
        }

        Excel::create($name,function($excel) use ($export){
            $excel->sheet('export_data',function($sheet) use ($export){
                $sheet->fromArray($export);
            });
        })->export('xlsx');
    }

    /*END Database Import-Export*/

    

    /*Load more Skill*/
    public function getMoreSkill($skip,$take){
        $count = Skills::count();
        if($skip>$count) 
            return response()->json(['flag'=>false]);
        $skills = Skills::orderBy('rating','desc')->skip($skip)->take($take)->get();

        // dd($skills);
        return response()->json(['flag'=>true,'skills'=>$skills]);
    }
    /*End load more Skill*/


    /*Filter by Check skill*/
    public function getFilterBySkill(Request $request,$list){
        //DEFAULT
        $skill_job = Skill_Job::join('skills','skill_job.skill_id','=','skills.id')->select('skill_job.*','skills.name as skill_name')->get();


        $q = Jobs::query()->where('jobs.status',1);
        //lấy 1 số kết quả liên quan tới resquest trên url
        if($request->has('city')){
            //gọi đến hàm get city
            $req_city = $request->get('city');
            $array = $this->filJobsReqCity($req_city,$q);
            $q=$array['q'];
        }
        if($request->has('key')){
            $req_key = $request->get('key');
            $array2 = $this->filJobsReqKey($req_key,$q);
            $q=$array2['q'];
        }
        // left join with skill
        // $q->join('skill_job','skill_job.job_id','=','jobs.id');



        //filter thông qua list truyền vào
            //get ra list các skill bằng cách cắt chuỗi (PHP 5, PHP 7) cat chuoi by string — Convert a string to an array
        if($list=="q") {
            $arr=[];
        }else{
            $arr = array_map('trim',explode(".",substr($list,1)));
            array_pop($arr); //loại bỏ phần tử rỗng cuối
        }
        // dd($arr);
        
        if(count($arr)>0){
            $subquery = "";
            foreach($arr as $key=>$ar){   //filter
                if($key!=(count($arr)-1)){
                    $subquery.="skill_id = ".$ar." or ";
                }else{
                    $subquery.="skill_id = ".$ar;
                }
            }
            $q->join(DB::raw("(select job_id FROM skill_job WHERE (".$subquery.") group by job_id having count(*) = ".count($arr).") as skill"),'skill.job_id','=','jobs.id');
        }
        
        $q->leftjoin('cities','jobs.city_id','=','cities.id')
            ->leftjoin('employers','jobs.emp_id','=','employers.id')
            ->select('jobs.*','cities.name as city_name','employers.logo as emp_logo');
        
        //OK
        //now we can order by anything and skip and take
        $jobs = $q->get();
        return response()->json(['flag'=>true,'jobs'=>$jobs,'skill_job'=>$skill_job]);
    }
    /*End filter by Check skill*/




    /*Function about filter and search jobs*/
    public function filJobsReqCity($req_city,$q){
        switch ($req_city) {
                case -1:
                    $def_city = -1;
                    $def_city_name = "All Cities";
                    break;
                case -2:
                    $q->where('city_id','<>',1)->where('city_id','<>',2);
                    $def_city = -2;
                    $def_city_name = "Others";
                    break;
                case 1:
                    $q->where('city_id','=',1);
                    $def_city = 1;
                    $def_city_name = "Ho Chi Minh";    
                    break;
                case 2:
                    $q->where('city_id','=',2);
                    $def_city = 2;
                    $def_city_name = "Ha Noi";
                    break;
                default:
                    dd("Không có kết quả nào trùng khớp");
                    break;
            }
            return ['q'=>$q,'def_city'=>$def_city,'def_city_name'=>$def_city_name];
    }
    public function filJobsReqKey($req_key,$q){
        $def_key =null;
        if($req_key!="") {
            $def_key =$req_key;
        }
        $q->where('jobs.name','like','%'.$req_key.'%'); 
        return ['q'=>$q,'def_key'=>$def_key];
    }
    /*End Function about filter and search jobs*/




     /*Login logout Register*/
    public function getLogin(){
        return view('layouts.login');
    }
    public function postLogin(Request $request){
        $email = $request->email;
        $password = $request->password;

        if(Auth::attempt(['email'=>$email,'password'=>$password])){
            switch (Auth::user()->role_id) {
                case 1:
                    break;
                case 2:
                    return redirect()->route('admin-index');
                    break;
                default:
                    break;
            }
            return redirect()->route('alljobs');
        }
        else{
            return redirect()->back()->withInput()->with(['message'=>'Login failed']);
        }
    }

    public function getLogout(){
        if(Auth::check()){
            Auth::logout();
        }
        return redirect()->back();
    }
   
    public function getRegister(){
        return view('home.register');
    }
    public function postRegister(Request $request){
        $validator  = Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|email',
            'password'=>'required|min:6|max:20|confirmed',
            'password_confirmation'=>'required|min:6|max:20',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $name = $request->name;
        $email = $request->email;
        $password = $request->password;

        if(User::where('email',$email)->first()){
             return redirect()->back()->withErrors("This email has already exists");
        }

        $user = new User();
        $user->name=$name;
        $user->email=$email;
        $user->password=bcrypt($password);
        $user->role_id=1;
        $user->save();
        return redirect()->back()->with(['message'=>'Create Successfully']);

    }
    /*End Login logout Register*/

    /*Account*/
    public function getAccount(){
        return view('home.account');
    }
    /*End Account*/
    

    /*Register COMPANY OR EMPLOYER*/
    public function getRegisterEmp(){
        return view('home.registeremp');
    }

    //get list employer suggest in "Choose One" 
    public function getEmployersByKey(Request $request){
        $key = ($request->has('key'))?($request->get('key')):"";
        $employers = Employers::where('name','like','%'.$key.'%')->where('status',1)->take(4)->get();

        return response()->json(['employers'=>$employers]);
    }
    public function getSuggestEmp2($key){
        $employers = Employers::findOrFail($key);
        return response()->json(['employers'=>$employers]);
    }


    public function postRegisterEmp(Request $request){
        $validator = Validator::make($request->all(),[
            'emp_id' =>     'required',
        ]);
        // dd($request->all());
        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }
        //
        if($request->emp_id==-1){
            $validator2 = Validator::make($request->all(),[
            'name'=>        'required',
            'website'=>    'required',
            'address'=>    'required',
            ]);
            if($validator2->fails()){
                return redirect()->back()->withErrors($validator2);
            }
        }


        //check user
        if(Register_Employer::where('user_id',Auth::user()->id)->first()){
            return redirect()->back()->withInput()->with(['message'=>'Error, Your account has been registered']);
        }
        //get user
        $user = User::findOrFail(Auth::user()->id);

        //get data from request
        $emp_id = $request->emp_id;
        $name = $request->name;
        $website = $request->website;
        $address = $request->address;

        try{
            if($emp_id==-1){
                $employer = new Employers();
                $employer->name=$name;
                $employer->alias=$this->changToAlias($this->stripVN($request->name));
                $employer->website=$website;
                $employer->address=$address;
                $employer->status=0;
                $employer->save();
            }else{
                $employer = Employers::findOrFail($emp_id);
            }
            $register_employer = new Register_Employer();
            $register_employer->user_id =  $user->id;
            $register_employer->emp_id = $employer->id;
            //Status of register   equal 0 : EMPLOYER   , equal 1 : EMPLOYEE, equal 2: success ,equal 3 : fail 
            $register_employer->status = ($emp_id==-1)?0:1;
            $register_employer->save();

        }catch(\Exception $e){
             return redirect()->back()->withInput()->with(['message'=>'ERROR try/catch']);
        }

        return redirect()->back()->with(['message'=>'Sendding request!']);
    }
    /*END Register COMPANY OR EMPLOYER*/


    /*Change Avatar of Account*/
    public function postChangeAvatar(Request $request){
        $validator  = Validator::make($request->all(),[
            'image'=>'max:5000|mimes:jpg,jpeg,bmp,png'
        ]);
        
        if ($validator->fails()) {
            return response()->json(['mess'=>'Image has size too large or has type:jpg,jpeg,bmp,png','flag'=>false]);
        }
        $filename="";
        if(Input::hasfile('image') && $request->has('id')) {
            $id = $request->get('id');
            $file = Input::file('image');
            //get extension of a image
            $file_extension= File::extension($file->getClientOriginalName());
            
            $user = User::findOrFail($id);
            $filename = "avatar_user_".$id.".".$file_extension;
            $file->storeAs('public/user/avatar',$filename);
            $user->image=$filename;
            $user->save();
        }else{
            return response()->json(['mess'=>'No quest Image or id','flag'=>false]);
        }
        return response()->json(['mess'=>'OK google','flag'=>true]);
    }
    /*END Change Avatar of Account*/

    /*Change profile account*/
    public function getAccountInfo($id){
        try{
             $user=User::findOrFail($id);
        }catch(\Exception $e){
             return response()->json(['flag'=>false]);
        }
        return response()->json(['flag'=>true,'user'=>$user]);
    }
    //post account edit
    public function postAccountEdit(Request $request){
        //biến thay đổi email || password
        $changemail = false;
        $changepassword =($request->changepass==1)?true:false;
        // dd($request->all());
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|email',
            'cv'=>'mimes:pdf,docx,doc'
        ]);
        $validator2 = Validator::make($request->all(),[
            'password'=>'required|min:6',
            'new-password'=>'required|min:6',
            'renew-password'=>'required|min:6|same:new-password',
        ]);

        
       
        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        //validate for password
        if($changepassword){
            if ($validator2->fails()) {
                return redirect()->back()
                        ->withErrors($validator2)
                        ->withInput();
            }
        }


        try{//edit info of user
            $user = User::findOrFail($request->id);
            if($user->email!=$request->email) $changemail = true; //changstatus of the changemail status

            // confimee password
            if($changepassword){
                if(!Hash::check($request->password,$user->password))
                return redirect()->back()->withInput()->withErrors(['Old password invalid']);
                else{
                    $user->password=bcrypt($request->get('new-password')); 
                }
            }
            //edit cv file
            if(Input::hasFile('cv')){
                $file=Input::file('cv');
                $extension = $file->getClientOriginalExtension();

                $filename = "cv_user_profile_".$user->id.".".$extension;
              
                $file->storeAs('public/user/cv',$filename);
                $user->cv = $filename;

            }

            $user->name=$request->name;
            $user->email=$request->email;
            $user->describe=$request->describe;
            $user->save();
        }catch(\Exception $e){
            return redirect()->back()->withInput()->with(['mess'=>'Fail try/catch']);
        }
        if($changemail||$changepassword){
            Auth::logout();
            return redirect()->route('getlogin')->with(['message'=>'Edit successful. You has changed email or password! Please login again']);
        }
        return redirect()->back()->with(['mess'=>'Edit info Successfully']);
    }
    /*END Change profile account*/


    /*Apply a job*/
    public function getApplyCV($job_id){
        $job= Jobs::findOrFail($job_id);
        return view('home.apply',compact('job'));
    }
    public function postApplyCV(Request $request,$job_id){
        // dd($request->all());
        $validator = Validator::make($request->all(),[
            'user_id' =>'required',
            'name' => 'required',
            'email' => 'required|email',
            'cv' =>'mimes:doc,docx,pdf',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }
        // dd($request->all());
        
        $user_id = $request->get('user_id');
        $name= $request->get('name');
        $email= $request->get('email');

        $app = new  Applications();
        $app->name=$name;
        $app->email=$email;
        $app->user_id=($user_id==-1)?0:$user_id;
        $app->job_id=$job_id;

        $temp = (new DateTime())->getTimestamp();
        if(Input::hasFile('cv')){   //apply all()
            $file=Input::file('cv');
            $extension = $file->getClientOriginalExtension();
            
            if($user_id>0){
                $filename = "cv_user_".$user_id."_apply_".$job_id."_".$temp.".".$extension;
            }
            else{

               $filename = "cv_user_0_apply_".$job_id."_".$temp.".".$extension; 
            }
            $file->storeAs('public/emp/cv',$filename);
            $app->cv = $filename;
        }else{ //check user && has cv=>apply else validate
            $user = User::where('id',$user_id)->first();
            if($user && $user->cv!=null){ //has login and has cv
                //save file -> copy file
                    //get extension of tring in cv
                    $extension = pathinfo($user->cv, PATHINFO_EXTENSION);
                    $filename="cv_user_".$user->id."_apply_".$job_id."_".$temp.".".$extension;
                    Storage::copy('public/user/cv/'.$user->cv,'public/emp/cv/'.$filename);
                //save to db
                $app->cv=$filename;
            }else{//no login or no has cv
                return redirect()->back()->withErrors(["You don't have any CV"]);
            }
        }
        // dd($request->all());
        $app->save();
        return redirect()->back()->with(['mess'=>'You have applied CV! Thank you!']);
    }
    /*END Apply a job*/

}
