<?php


namespace frontend\modules\user\helpers;


class SavePostRelationHelper
{
    public static function save($class, $params, $postId, $paramName , $cityId)
    {
        $class::deleteAll(['post_id' => $postId]);

        if (\is_array($params)) {

            foreach ($params as $param){

                $object = new $class;

                $object->$paramName = $param;
                $object->post_id = $postId;
                $object->city_id = $cityId;

                $object->save();

            }

        }else{

            $object = new $class;

            $object->$paramName = $params;
            $object->post_id = $postId;

            $object->save();

        }

    }
}