<?php

namespace App\Libraries;

use Carbon\Carbon;

class MongoExtent
{
    /**
     * Safe MongoId
     *
     * @param string $id
     * @return \MongoDB\BSON\ObjectID
     */
    public static function safeMongoId($id = null)
    {
        $id = (string)$id;

        if (self::isValidMongoId($id)) {
            return new \MongoDB\BSON\ObjectID($id);
        } else {
            return new \MongoDB\BSON\ObjectID();
        }
    }

    /**
     * Safe BSON Serialize
     *
     * @param $bson
     * @return mixed
     */
    public static function safeBSONSerialize($bson)
    {
        if (is_array($bson)) {
            array_walk_recursive($bson, array(__CLASS__, 'safeBSONSerializeRecursive'));
            // array($this,'safeBSONSerializeRecursive') | array(__CLASS__, 'safeBSONSerializeRecursive')
        }

        return $bson;
    }

    /**
     * Safe BSON Unserialize
     *
     * @param $json
     * @return mixed
     */
    public static function safeBSONUnserialize($json)
    {
        if (is_array($json)) {
            array_walk_recursive($json, array(__CLASS__, 'safeBSONUnserializeRecursive'));
            // array($this,'safeBSONUnserializeRecursive') | array(__CLASS__,'safeBSONUnserializeRecursive')
            $json = self::_normalizeMongoId($json);
        }

        return $json;
    }

    /**
     * Normalize MongoId
     *
     * @param $array
     * @return array
     */
    private static function _normalizeMongoId($array) {
        if (is_array($array) && !empty($array)) {
            foreach ($array as $key => $value) {
                if (isset($value['oid']) && is_object($value['oid']) && !empty($value['oid'])) {
                    $array[$key] = $value['oid'];
                } else {
                    $array[$key] = self::_normalizeMongoId($array[$key]);
                }
            }
        }

        return $array;
    }

    /**
     * safe serialize bson recursive
     *
     * @param mixed &$item
     * @param string $key
     */
    public static function safeBSONSerializeRecursive(&$item, $key)
    {
        if (is_object($item) && !empty($item)) {
            if ($item instanceof \MongoDB\BSON\ObjectID) {
                $item = [
                    'oid' => (string)$item
                ];
            } elseif ($item instanceof \MongoDB\BSON\UTCDatetime) {
                $item = Carbon::createFromTimestamp($item->toDateTime()
                    ->getTimestamp())
                    ->timezone(config('app.timezone'))
                    ->format('Y-m-d H:i:s');
            } elseif ($item instanceof \MongoDB\BSON\Regex) {
                $item = [
                    '$pattern' => $item->getPattern(),
                    '$flags' => $item->getFlags()
                ];
            }
            else {
                $item = @(string)$item;
            }
        }
    }

    /**
     * safe unserialize bson recursive
     *
     * @param mixed &$item
     * @param string $key
     */
    public static function safeBSONUnserializeRecursive(&$item, $key)
    {
        if ($key === 'oid' && self::isValidMongoId($item)) {
            $item = new \MongoDB\BSON\ObjectID($item);
        }
    }

    /**
     * check if mongoid is valid
     *
     * @param string $id
     * @return bool
     */
    public static function isValidMongoId($id)
    {
        $regex = '/^[0-9a-z]{24}$/';

        if (preg_match($regex, $id)) {
            return true;
        }

        return false;
    }
}


