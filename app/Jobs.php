<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jobs extends Model
{
     private $id;
     protected $table='jobs';
     protected $fillable=[
          "name","alias","user_id","emp_id","city_id"
     ];
     public function CV()
     {
     	return $this->belongsToMany('App\CV','applies','job_id','cv_id');
     }
     public function Skills()
     {
     	return $this->belongsToMany('App\Skills','skill_job','job_id','skill_id');
     }
     public function Cities()
     {
     	return $this->belongsTo('App\Cities','city_id','id');
     }
     public function Employers()
     {
     	return $this->belongsTo('App\Employers','employer_id','id');
     }
     public function User()
     {
     	return $this->belongsTo('App\User','user_id','id');
     }
     public function __toString(){
          return $this->id;
     }

}
