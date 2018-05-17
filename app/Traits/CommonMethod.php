<?php

namespace App\Traits;
use MongoDB\BSON\UTCDateTime;
use App\Follows;
use Auth;
use App\Cities;
use Cache;

trait CommonMethod {

	protected function formatInputToSave(&$arrData)
	{
		$arrData['created_at'] = new UTCDateTime(round(microtime(true) * 1000));
		$arrData['updated_at'] = new UTCDateTime(round(microtime(true) * 1000));
        $arrData['deleted'] = false;
		return $arrData;
	}

	protected function findFollow($typeId, $type) {
		$wheres = [
            'user_id' => Auth::id(),
            'followed_info._id' => [
                '$eq' => $typeId,
                '$exists' => true
            ],
            'type' => $type
        ];
        return Follows::where($wheres)->first();
	}

	protected function getAllCities() {
        $locations = Cache::remember('listLocation', config('constant.cacheTime'), function() {
            return Cities::all();
        });
        return $locations;
    }

    protected function changToAlias($str) {
        $str = strtr(utf8_decode($str), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
        $str =   str_replace('?', '',strtolower($str));
        return  str_replace(' ', '-',strtolower($str));
    }
}