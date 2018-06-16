<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Applications;
use App\User;
use App\Roles;
use Validator;
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
    public function changToAlias($str){
        //Remove Vietnamese
        $str = strtr(utf8_decode($str), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
        //
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
    public function getDashBoard() {
        return view('admin.dashboard');
    }
    public function getListUsers() {
        $user = User::get();
        $count_user_online = 0;
        foreach ($user as $u) {
            if(Cache::has('user-is-online-'.$u->id))
                $count_user_online++;
        }
        return view('admin.users',compact('count_user_online'));
    }
    public function getListEmps() {
        return view('admin.employers');
    }

    public function loadAdminRoles() {
        return view('admin.roles');
    }
    /**
     * ANGULAR USING
     * @return json for angular JS
     * Note: A object when delete: deleted_at field has value
     * So: when get list or user, check deleted_at is null
     */
            //----SHOW ALL----
    public function ngGetUsers() {
        $users = $this->get_list_users();
        return response()->json([config('constant.USERS') => $users]);
    }
            //----SHOW BY ID----
    public function ngGetUser($id){
        $user = User::findOrFail($id);
        return response()->json([config('constant.USER') => $user]);
    }
            //----CREATE USER----
    public function ngPostCreateUser(Request $request){
        // Form validation
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'name' => 'required',
            'role_id' => 'required'
        ]);
        // Check validation
        if ($validator->fails()) {
            return response()->json([config('constant.STATUS') => FALSE,
            config('constant.ERROR') => $validator]);
        }

        $email = $request->email;
        $password = $request->password;
        $name = $request->name;
        $role_id = $request->role_id;
        $status = ($request->exists('status'))? $request->status :
            config('constant.STATUS_DEFAULT');

        if(User::where('email',$email)->first()){
            return response()->json([config('constant.STATUS') => FALSE,
                config('constant.ERROR') => config('constant.ERROR_EMAIL_EXIST')]);
        }

        $user = new User;
        $user->name = $name;
        $user->email = $email;
        $user->password = bcrypt($password);
        $user->role_id = $role_id;
        $user->status = $status;
        $user->save();

        return response()->json([config('constant.STATUS') => TRUE,
        config('constant.MESSAGE') => config('constant.SUCCESS_CREATE_USER'),
            config('constant.USER') => $user]);
    }

            //----EDIT USER----
    public function ngPostEditUser(Request $request, $id) {
        // Form validation
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'name' => 'required',
            'role_id' => 'required'
        ]);
        // Check validation
        if ($validator->fails()) {
            return response()->json([config('constant.STATUS') => FALSE,
            config('constant.ERROR') => $validator]);
        }

        // Get user
        $user = User::findOrFail($id);

        $email = $request->email;
        $name = $request->name;
        $role_id = $request->role_id;
        $status = $request->status;

        if(User::where('email',$email)->where('email','<>',$user->email)->first()) {
            return response()->json([config('constant.STATUS') => FALSE,
                config('constant.ERROR') => config('constant.ERROR_EMAIL_EXIST')]);
        }

        // Update user
        if($request->has('password')){
            $password = $request->password;
            $user->password = bcrypt($password);
        }
        $user->name=$name;
        $user->email=$email;
        $user->role_id=$role_id;
        $user->status=$status;
        $user->save();

        // Get list users to Update in View
        $users = $this->get_list_users();
        return response()->json([config('constant.STATUS') => TRUE,
            config('constant.MESSAGE') => config('constant.SUCCESS_EDIT_USER'),
            config('constant.USERS') => $users]);
    }

        //----DELETE USER---
    public function ngGetDeleteUser($id) {
        try{
            $user = User::findOrFail($id);
            $user->delete();
             //get list users to Update by Table
            $users = $this->get_list_users();
            return response()->json([config('constant.STATUS') => TRUE,
                config('constant.MESSAGE') => config('constant.SUCCESS_DELETE_USER'), config('constant.USERS') => $users]);
        }catch(Exception $e){
            return response()->json([config('constant.STATUS') => FALSE,
                config('constant.MESSAGE') => config('constant.FAIL_DELETE_USER')]);
        }
    }


            //-----GET ROLE-----
    public function ngGetRoles() {
        $roles = $this->get_list_roles();
        return  response()->json(['roles'=>$roles]);
    }
    public function ngGetRole($id) {
        $role = Roles::find($id);
        return  response()->json(['role'=>$role]);
    }
    public function ngAddRole(Request $request) {
        // Form validation
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'detail' => 'required',
            'route' => 'required'
        ]);
        // Check validation
        if ($validator->fails()) {
            return response()->json([config('constant.STATUS') => FALSE,
            config('constant.ERROR') => $validator->errors()]);
        }
        try {
            // Create a new role
            $role = new Roles;
            $role->name = $request->name;
            $role->detail = $request->detail;
            $role->route = $request->route;
            $role->save();

            return response()->json([config('constant.STATUS') => TRUE,
            config('constant.MESSAGE') => config('constant.SUCCESS_CREATE_ROLE'),
                config('constant.ROLE') => $role]);
        } catch (Exception $e) {
            return response()->json([config('constant.STATUS') => FALSE,
            config('constant.ERROR') => $e->getMessage()]);
        }
    }
    public function ngEditRole(Request $request) {
        // Form validation
        $validator = Validator::make($request->all(), [
            '_id' => 'required',
            'name' => 'required',
            'detail' => 'required',
            'route' => 'required'
        ]);
        // Check validation
        if ($validator->fails()) {
            return response()->json([config('constant.STATUS') => FALSE,
            config('constant.ERROR') => $validator->errors()]);
        }
        try {
            // Edit role
            $role = Roles::find($request->_id);
            $role->name = $request->name;
            $role->detail = $request->detail;
            $role->route = $request->route;
            $role->updated_at = date('Y-m-d H:i:s');
            $role->save();

            //Get list new roles
            $roles = $this->get_list_roles();
            return response()->json([config('constant.STATUS') => TRUE,
            config('constant.MESSAGE') => config('constant.SUCCESS_EDIT_ROLE'),
                config('constant.ROLES') => $roles]);

        } catch (Exception $e) {
             return response()->json([config('constant.STATUS') => FALSE,
            config('constant.ERROR') => $e->getMessage()]);
        }
    }
    // Delete role if don't have any user in this role
    public function ngDeleteRole(Request $request) {
        $validator = Validator::make($request->all(), [
            '_id' => 'required'
        ]);
        // Check validation
        if ($validator->fails()) {
            return response()->json([config('constant.STATUS') => FALSE,
            config('constant.ERROR') => $validator->errors()]);
        }
        try {
            // Delete role
            $role = Roles::find($request->_id);
            $user_count = User::where('role_id',$request->_id)->get()->count();
            if ($user_count >0) {
                return response()->json([config('constant.STATUS') => FALSE,
                config('constant.ERROR') => config('constant.FAIL_DELETE_ROLE')]);
            } else {
                $role->delete();
            }

            //Get list new roles
            $roles = $this->get_list_roles();
            return response()->json([config('constant.STATUS') => TRUE,
            config('constant.MESSAGE') => config('constant.SUCCESS_DELETE_ROLE'),
                config('constant.ROLES') => $roles]);

        } catch (Exception $e) {
             return response()->json([config('constant.STATUS') => FALSE,
            config('constant.ERROR') => $e->getMessage()]);
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

        return response()->json(['status'=>TRUE,'countallusers'=>$countallusers,'countadmins'=>$countadmins,
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
            $emp->alias = $this->changToAlias($request->name);
            $emp->city_id = $request->city_id;
            $emp->address = $request->address;
            $emp->website = $request->website;
            $emp->status = $request->status;
            $emp->phone = $request->phone;

            $emp->save();

            //get all data and send to update table
            $emps = Employers::all();
            return response()->json(['status'=>TRUE,'message'=>'Create Successfully','emps'=>$emps]);
        }catch(Exception $e){
            return response()->json(['status'=>FALSE,'message'=>'Create failed','req'=>$request->all()]);
        }
    }
    public function ngPostEditEmp(Request $request,$id){
        try{
            $emp = Employers::findOrFail($id);
            $emp->name = $request->name;
            $emp->alias = $this->changToAlias($request->name);
            $emp->city_id = $request->city_id;
            $emp->address = $request->address;
            $emp->website = $request->website;
            $emp->status = $request->status;
            $emp->phone = $request->phone;
            $emp->save();
            //get all data and send to update table
            $emps = Employers::all();
            return response()->json(['status'=>TRUE,'message'=>'Edit Successfully','emps'=>$emps]);
        }catch(Exception $e){
            return response()->json(['status'=>FALSE,'message'=>'Edit failed']);
        }
    }
    public function ngGetDeleteEmp($id){
        try{
            $emp = Employers::findOrFail($id);
            $emp->delete();

            $emps = Employers::all();
            return response()->json(['status'=>TRUE,'message'=>'Delete Successfully','emps'=>$emps]);
        }catch(Exception $e){
            return response()->json(['status'=>FALSE,'message'=>'Delete failed']);
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
            $user->notify(new ConfirmEmployer($emp,TRUE));

            return response()->json(['status'=>TRUE,'message'=>'Confirm Successfully','emps'=>$emps]);
        }catch(Exception $e){
            return response()->json(['status'=>FALSE,'message'=>'Confirm failed']);
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

            $user->notify(new ConfirmEmployer($emp,FALSE));

            return response()->json(['status'=>TRUE,'message'=>'Deny Successfully','emps'=>$emps]);
        }catch(Exception $e){
            return response()->json(['status'=>FALSE,'message'=>'Deny failed']);
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

    /**
     * Common function: Get list users
     * Order: Desc
     */
    private function get_list_users() {
        return User::orderBy('created_at','desc')->get();
    }
    private function get_list_roles() {
        return Roles::orderBy('created_at', 'desc')->get();
    }
}
