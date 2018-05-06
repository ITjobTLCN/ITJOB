<?php

namespace App\Traits;
use MongoDB\BSON\UTCDateTime;
use App\Follows;
use Auth;

trait CommonMethod {

	protected function formatInputToSave(&$arrData)
	{
		$arrData['created_at'] = new UTCDateTime(round(microtime(true) * 1000));
		$arrData['updated_at'] = new UTCDateTime(round(microtime(true) * 1000));

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
}