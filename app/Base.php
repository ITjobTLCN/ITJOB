<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use MongoDB\BSON\UTCDateTime;
use DB;

class Base extends Eloquent {

	use SoftDeletes;

    protected $dates = ['deleted_at'];
    
	// public function __construct($collection)
	// {
	// 	$this->collection = $;
	// }
	protected function insertDocument($data) {
		$data['created_at'] = new UTCDateTime(round(microtime(true) * 1000));
		$data['updated_at'] = new UTCDateTime(round(microtime(true) * 1000));
		
		$id = parent::insertGetId($data);
		return $id;	
	}
	private function updateDocument($data, $multi, $upsert)
	{
		
	}
}
