<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Applications;
use App\User;
use App\Roles;
use App\Job;
use App\Employers;
use App\Cities;
use App\Registration;
use Excel;
use Illuminate\Support\Facades\Input;
use DateTime;
use Carbon\Carbon;
use Cache;
use Auth;
use App\Notifications\ConfirmEmployer;
use App\Notifications\SendNotify;

class AdminController extends Controller
{
     /*Function change from name to alias and remove Vietnamese*/
    function stripAccents($str) {
        return strtr(utf8_decode($str), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
    }
    public function changToAlias($str){
        $str =   str_replace('?', '',strtolower($str));
        return  str_replace(' ', '-',strtolower($str));
    }
    
    /*Import and export*/
     public function postImport(){
        try{
            $type = Input::has('type')?Input::get('type'):-1;

            if(Input::hasFile('file')){

                Excel::load(Input::file('file'),function($reader) use ($type){
                    
                    $reader->each(function($sheet) use ($type){

                        switch ($type) {
                            case 1:
                                User::firstOrCreate($sheet->toArray()); 
                                break;  
                            // case 2: 
                            //     Cities::firstOrCreate($sheet->toArray());
                            //     break;          
                            // case 3: 
                            //     Job::firstOrCreate($sheet->toArray());
                            //     break;  
                            // case 4: 
                            //     Employers::firstOrCreate($sheet->toArray());
                            //     break;  
                            // case 5: 
                            //     Skills::firstOrCreate($sheet->toArray());
                            //     break;      
                            // case 6: 
                            //     Skill_Job::firstOrCreate($sheet->toArray());
                            //     break;      
                            // case 7: 
                            //     Applications::firstOrCreate($sheet->toArray());
                            //     break;    
                            case 8: 
                                Roles::firstOrCreate($sheet->toArray());
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
    /*xuất bảng dữ liệu*/
     public function getExport($type){
        $export ='';
        $name = 'Export_Data_';
        switch ($type) {
            case 1:
                $export = User::all();
                $name= $name.'Users';
                break;
            // case 2:
            //     $export = Cities::all();
            //     $name= $name.'Cities';
            //     break;
            // case 3:
            //     $export = Job::all();
            //     $name= $name.'Job';
            //     break;
            // case 4:
            //     $export = Employers::all();
            //     $name= $name.'Employers';
            //     break;
            // case 5:
            //     $export = Skills::all();
            //     $name= $name.'Skills';
            //     break;
            // case 6:
            //     $export = Skill_Job::all();
            //     $name= $name.'Skill_Job';
            //     break;
            // case 7:
            //     $export = Applications::all();
            //     $name= $name.'Applications';
            //     break;
            case 8:
                $export = Roles::all();
                $name= $name.'Roles';
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




    /*
    |       ----------------ADMIN---------------------
    |       -----------get List Users-----------------
    |       -----Create - Read - Update - Delete------
    */

       /*-------Page loading by Laravel-------*/
    public function getDashBoard(){return view('admin.dashboard');}
    public function getListUsers(){
        $user = User::get();
        $count_user_online = 0;
        foreach($user as $u){
            if(Cache::has('user-is-online-'.$u->id))
                $count_user_online++;
        }
        return view('admin.users',compact('count_user_online'));}
    public function getListEmps(){return view('admin.employers');}
    /*
    |-------Angular using --------
    */
            //----SHOW ALL----
    public function ngGetUsers(){
        $users=User::get();
        return response()->json(['users'=>$users]);
    }
            //----SHOW BY ID----
    public function ngGetUser($id){
        try{
            $user = User::findOrFail($id);
            return response()->json(['user'=>$user]);
        }catch(\Exception $e){

        } 
    }
            //----CREATE USER----
    public function ngPostCreateUser(Request $request){
        $email = $request->email;
        $password = $request->password;
        $name = $request->name;
        $role_id = $request->role_id;
        $status = $request->status;

         if(User::where('email',$email)->first()){
             return response()->json(['status'=>false,'errors'=>"This email has already exists"]);
        }

        $user = new User();
        $user->name=$name;
        $user->email=$email;
        $user->password=bcrypt($password);
        $user->role_id=$role_id;
        $user->status=$status;
        $user->save();

        return response()->json(['status'=>true,'message'=>'Create Successfully','item'=>$user]);
    }
            //----EDIT USER----
    public function ngPostEditUser(Request $request,$id){
        $user = User::findOrFail($id);

        $email = $request->email;
        $name = $request->name;
        $role_id = $request->role_id;
        $status = $request->status;

         if(User::where('email',$email)->where('email','<>',$user->email)->first()){
             return response()->json(['status'=>false,'errors'=>"This email has already exists"]);
        }
        
        if($request->has('password')){
            $password = $request->password;
            $user->password=bcrypt($password);
        }
        $user->name=$name;
        $user->email=$email;
        $user->role_id=$role_id;
        $user->status=$status;
        $user->save();

        //get list users to Update by Table
        $users = User::get();
        return response()->json(['status'=>true,'message'=>'Edit Successfully','items'=>$users]);
    }
            //-----GET ROLE-----
    public function ngGetRoles(){
        $roles = Roles::get();
        return  response()->json(['roles'=>$roles]);
    }
            //----DELETE USER---
    public function ngGetDeleteUser($id){
        try{
            $user = User::findOrFail($id);
            $user->delete();
             //get list users to Update by Table
            $users = User::get();
             return response()->json(['status'=>true,'message'=>'Delete Successfully','items'=>$users]);
        }catch(Exception $e){
            return response()->json(['status'=>false,'message'=>'Delete failed']);
        }
    }

    /*------------------END USER---------------------*/




    /**----------------DASHBOARD------------------------
    * A some function in DASHBOARD, used in DashBoardController.js
    *               used with AngularJS
    *          Input: data,     Output: json[]
    */

    public function ngGetNumber(){
        $countallusers = User::where('status',1)->count();
        $countadmins = User::where('status',1)->where('role_id',2)->count();
        $countusers = User::where('status',1)->where('role_id',1)->count();
        $countemployers = User::where('status',1)->where(function($q){
            $q->orWhere('role_id',3);
            $q->orWhere('role_id',4);
        })->count();
        $countmasters = User::where('status',1)->where('role_id',3)->count();
        $countassistants = User::where('status',1)->where('role_id',4)->count();

        $countemps = Employers::count();
        $countpendingemps = Employers::where('status',0)->count();
        $countapprovedemps = Employers::where('status',1)->count();
        $countdeniedemps = Employers::where('status',2)->count();



        //main
        // $date = new Carbon('2017-12-05 18:06:49');
        $now = Carbon::now();
        $today = Carbon::today();

        $usertoday = User::where('status',1)->where('created_at','>',$today)->get();
        $countusertoday = $usertoday->count();

        $posttoday = Job::where('status',1)->where('created_at','>',$today)->get();
        $countposttoday = $posttoday->count();

        $applitoday = Applications::where('status',1)->where('created_at','>',$today)->get();
        $countapplitoday = $applitoday->count();

        // $now = gmdate('H:i:s',$now->diffInSeconds($diff));

        //POST
        $posts = Job::with('Employer')->get();
        //count post approved and expired
        $countposted = Job::where(function($q){
            $q->orWhere('status',1);
            $q->orWhere('status',11);
        })->get()->count();

        //APLLY
        $countapplies = Applications::where('status',1)->get()->count();

        /* Employers*/
            //new approved in today
        $newemps = Employers::join('registration','employers.id','=','registration.emp_id')->where('employers.status',1)->where('registration.status',1)->where('registration.created_at','>',$today)->select('emp_id')->get()->count();
        
        //count online user
        $user = User::get();$user_online = 0;
        foreach($user as $u){
            if(Cache::has('user-is-online-'.$u->id))
                $user_online++;
        }

        return response()->json(['status'=>true,'countallusers'=>$countallusers,'countadmins'=>$countadmins,
            'countusers'=>$countusers,'countemployers'=>$countemployers,'countmasters'=>$countmasters,
            'countassistants'=>$countassistants,
            'countemps'=>$countemps, 'countpendingemps'=>$countpendingemps,
            'countapprovedemps'=>$countapprovedemps,'countdeniedemps' => $countdeniedemps,
            //main
            'countusertoday' => $countusertoday,'countposttoday'=>$countposttoday,'countapplitoday'=>$countapplitoday,
            'posts'=>$posts,'countposted'=>$countposted,'countapplies'=>$countapplies,'newemps'=>$newemps, 'user_online'=>$user_online]);
    }
    /*----------------END DASHBOARD------------------*/


        /**---------------EMPLOYERS----------------------
    * A some function in Employer, used in EmpController.js
    * function: confirm/deny waiting employer
    * list employer - CRUD - sort search limit  
    * Number of masters and assistants, CRUD - sort search limit
    * Number of posts - total -current - expire - waiting POSTs
    */
        /*CRUD Employer*/
    public function ngGetEmps(){
        $emps = Employers::get();
        $cities = Cities::get();
        
        $regis = Registration::join('users','registration.user_id','=','users.id')->select('users.*','registration.*')->get();
        return response()->json(['emps'=>$emps,'cities'=>$cities,'regis'=>$regis]);
    }
    public function ngGetEmp($id){
        $emp = Employers::findOrFail($id);
        return response()->json(['emp'=>$emp]);
    }
    public function ngPostCreateEmp(Request $request){
        try{
            $emp = new Employers();
            $emp->name = $request->name;
            $emp->alias = $this->changToAlias($this->stripAccents($request->name));
            $emp->city_id = $request->city_id;
            $emp->address = $request->address;
            $emp->website = $request->website;
            $emp->status = $request->status;
            $emp->phone = $request->phone;

            $emp->save();

            //get all data and send to update table
            $emps = Employers::all();
            return response()->json(['status'=>true,'message'=>'Create Successfully','emps'=>$emps]);
        }catch(Exception $e){
            return response()->json(['status'=>false,'message'=>'Create failed','req'=>$request->all()]);
        }
    }
    public function ngPostEditEmp(Request $request,$id){
        try{
            $emp = Employers::findOrFail($id);
            $emp->name = $request->name;
            $emp->alias = $this->changToAlias($this->stripAccents($request->name));
            $emp->city_id = $request->city_id;
            $emp->address = $request->address;
            $emp->website = $request->website;
            $emp->status = $request->status;
            $emp->phone = $request->phone;
            $emp->save();
            //get all data and send to update table
            $emps = Employers::all();
            return response()->json(['status'=>true,'message'=>'Edit Successfully','emps'=>$emps]);
        }catch(Exception $e){
            return response()->json(['status'=>false,'message'=>'Edit failed']);
        }
    }
    public function ngGetDeleteEmp($id){
        try{
            $emp = Employers::findOrFail($id);
            $emp->delete();

            $emps = Employers::all();
            return response()->json(['status'=>true,'message'=>'Delete Successfully','emps'=>$emps]);
        }catch(Exception $e){
            return response()->json(['status'=>false,'message'=>'Delete failed']);
        }
    }
        /*END CRUD Employer*/

        /*CONFIRM/DENY pending Employer*/
    public function ngGetConfirmEmp($id){
        try{
            $emp = Employers::findOrFail($id);

            //with master
            $regis = Registration::where('emp_id',$emp->id)->where('status',0)->first();
            $user = User::findOrFail($regis->user_id);
            //
            $regis->status = 1;
            $regis->save();
            $emp->status = 1;
            $emp->save();
            $user->role_id = 3;
            $user->emp_id = $emp->id;
            $user->save();

            $emps = Employers::all();

            //send notification
            $user->notify(new ConfirmEmployer($emp,true));

            return response()->json(['status'=>true,'message'=>'Confirm Successfully','emps'=>$emps]);
        }catch(Exception $e){
            return response()->json(['status'=>false,'message'=>'Confirm failed']);
        }
    }

    public function ngGetDenyEmp($id){
        try{
            $emp = Employers::findOrFail($id);

            //with master
            $regis = Registration::where('emp_id',$emp->id)->where('status',0)->first();
            $user = User::findOrFail($regis->user_id);
            //
            $regis->status = 2;
            $regis->save();
            $emp->status = 2;
            $emp->save();

            $emps = Employers::all();

            $user->notify(new ConfirmEmployer($emp,false));

            return response()->json(['status'=>true,'message'=>'Deny Successfully','emps'=>$emps]);
        }catch(Exception $e){
            return response()->json(['status'=>false,'message'=>'Deny failed']);
        }
    }
        /*END CONFIRM/DENY pending Employer*/
    /*----------------END EMPLOYERS-------------------*/


    //Manage notification
    public function getAdminNotification(){
        return view('admin.notification');
    }
    public function createNotification(Request $request){
         //validate
        $this->validate($request,[
            'notification'=>'required|min:4',
            'roleid'=>'required'
        ]);
        // dd($request->all());
        //
        if($request->roleid<=0){ //all
            $userss = User::all();
            foreach($userss as $user){
                $user->notify(new SendNotify($request->notification));
            }
        }
        else{
            $users = User::where('role_id',$request->roleid)->get();
            foreach($users as $user){
                $user->notify(new SendNotify($request->notification));
            }
        }
        return redirect()->back();
    }
}
